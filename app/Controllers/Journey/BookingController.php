<?php

namespace App\Controllers\Journey;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\JourneyDriveModel;
use App\Models\UserModel;
use App\Validators\BookingValidator;
use App\Services\MailService;
use PhpParser\Node\Expr\AssignOp\Mod;

class BookingController extends BaseController
{

    // Display BookingView with journey details with id_journey_drive
    public function show($id_journey_drive)
    {
        return redirect()->to('drive/show/' . $id_journey_drive);
    }

    /**
     * Validate and insert a booking with conditions for : 
     * journey exist, is not the driver, there no duplicate and still available seats
     */
    public function save()
    {
        $journeyModel = new JourneyDriveModel();
        $bookingModel = new BookingModel();
        $journeyID = $this->request->getPost('id_journey_drive');
        $journey   = $journeyModel->find($journeyID);
        // If route doesn't exist
        if (!$journey) {
            return redirect()->back()
                ->with('error', 'Trajet introuvable');
        }
        // If departure is already passed
        if ($journey['departure'] <= date('Y-m-d H:i:s')) {
            return redirect()->back()
                ->with('error', 'Impossible de réserver un trajet déjà passé');
        }
        // If is the driver
        if ($journey['driver'] == session('user_id')) {
            return redirect()->back()
                ->with('error', 'Vous ne pouvez pas réserver votre propre trajet !');
        }
        // If already reserved
        $exist = $bookingModel
            ->where('id_journey_drive', $journeyID)
            ->where('id_user', session('user_id'))
            ->first();
        if ($exist) {
            return redirect()->back()
                ->with('error', 'Vous avez déjà une réservation sur ce trajet !');
        }

        //  Cancelled bookings (soft deleted) are automatically excluded.
        $seatPicked = (int) $bookingModel
            ->selectSum('seat_taken')
            ->where('id_journey_drive', $journeyID)
            ->where('deletion_date IS NULL')
            ->get()->getRow()->seat_taken;

        $availableSeat = $journey['number_of_place'] - $seatPicked;
        if ($availableSeat < 1) {
            return redirect()->back()
                ->with('error', 'Trajet complet');
        }
        $seatTaken = 1;
        //
        $validator = new BookingValidator();
        $data = [
            'booking_date'     => date('Y-m-d'),
            'seat_taken'       => $seatTaken,
            'id_user'          => session('user_id'),
            'id_journey_drive' => $journeyID,
        ];

        if (!$validator->validate($data)) {
            return redirect()->back()
                ->with('error', implode(' ', $validator->getErrors()));
        }

        $idBooking = $bookingModel->save($data);

        try {
            //Preparing the mail
            $mailService = new MailService();
            $infos = $this->gatherMailInfos($idBooking);


            //Gathering the infos for the mail
            $mailService->sendBookingRequest($infos['driver_email'], [
                'driver_name'          => $infos['driver_name'],
                'journey_date'         => $infos['departure'],
                'journey_departure'    => $infos['start_address'],
                'journey_arrival'      => $infos['end_address'],
                'journey_seats'        => $availableSeat,
                'passenger_name'       => $infos['passenger_name'],
                'passenger_email'      => $infos['passenger_email'],
                'passenger_mobile'     => $infos['passenger_mobile'],
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Erreur envoi mail : ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Demande de réservation envoyée');
    }

    // Cancel the booking to the passenger with id_booking
    public function cancel($id_booking)
    {
        $bookingModel = new BookingModel();
        $booking = $bookingModel->find($id_booking);
        if (! $booking || $booking['id_user'] != session('user_id')) {
            return redirect()->to('myprofil')
                ->with('error', 'Réservation introuvable');
        }

        $journeyModel = new JourneyDriveModel();
        $journey      = $journeyModel->find($booking['id_journey_drive']);

        if ($journey['departure'] <= date('Y-m-d H:i:s')) {
            return redirect()->to('myprofil')
                ->with('error', 'Impossible d\'annuler un trajet passé');
        }

        $bookingModel->delete($id_booking);
        return redirect()->back()
            ->with('success', 'Demande de réservation annulée');
    }

    // Set the 'is_validated' to true. Only to the journey driver with id_booking

    public function accept($id_booking)
    {
        $bookingModel = new BookingModel();
        $journeyModel = new JourneyDriveModel();
        $booking = $bookingModel->find($id_booking);
        if (!$booking) {
            return redirect()->to('myprofil')
                ->with('error', 'Réservation introuvable');
        }

        $journey = $journeyModel->find($booking['id_journey_drive']);
        if (!$journey || $journey['driver'] != session('user_id')) {
            return redirect()->to('myprofil')
                ->with('error', 'Action non autorisée');
        }

        if ($journey['departure'] <= date('Y-m-d H:i:s')) {
            return redirect()->to('myprofil')
                ->with('error', 'Impossible de valider une réservation d\'un trajet passé');
        }

        // Cheking if seats are still available

        $seatPicked = (int) $bookingModel
            ->selectSum('seat_taken')
            ->where('id_journey_drive', $journey['id_journey_drive'])
            ->where('is_validated', true)
            ->where('deletion_date IS NULL')
            ->get()->getRow()->seat_taken;
        if ($journey['number_of_place'] - $seatPicked < 1) {
            return redirect()->to('myprofil')
            ->with('error', 'Aucune place disponible sur le trajet');
        }

        // Checking user validation if already booking

        if($booking['is_validated']) {
            return redirect()->to('myprofil')
            ->with('error', 'Ce trajet à déjà été validé');
        }

        $bookingModel->update($id_booking, ['is_validated' => true]);

        //Preparing the mail service
        $mailService = new MailService();

        //Retrieving the infos needed for the mail
        $infos = $this->gatherMailInfos($id_booking, $booking['id_user']);

        //Send the mail to the passenger that it's application has been refused
        $mailService->sendBookingAccepted($infos['passenger_email'], [
            'passenger_name'       => $infos['passenger_name'],
            'journey_date'         => $infos['departure'],
            'journey_departure'    => $infos['start_address'],
            'journey_arrival'      => $infos['end_address'],
            'driver_name'          => $infos['driver_name'],
        ]);
        return redirect()->to('myprofil')
            ->with('success', 'Demande acceptée !');
    }

    // Delete the pending booking. Only to the journey driver with id_booking

    public function refuse($id_booking)
    {
        $bookingModel = new BookingModel();
        $journeyModel = new JourneyDriveModel();
        $booking = $bookingModel->find($id_booking);
        if (!$booking) {
            return redirect()->to('myprofil')
                ->with('error', 'Réservation introuvable');
        }

        $journey = $journeyModel->find($booking['id_journey_drive']);
        if (!$journey || $journey['driver'] != session('user_id')) {
            return redirect()->to('myprofil')
                ->with('error', 'Action non autorisée');
        }

        if ($journey['departure'] <= date('Y-m-d H:i:s')) {
            return redirect()->to('myprofil')
                ->with('error', 'Refus impossible sur un trajet déjà passé');
        }


        //Must be called before delete() because soft delete make booking unfindable with find()
        $infos = $this->gatherMailInfos($id_booking, $booking['id_user']);

        $bookingModel->delete($id_booking);

        //Preparing the mail service
        $mailService = new MailService();

        //Send the mail to the passenger that it's application has been refused
        $mailService->sendBookingRefused($infos['passenger_email'], [
            'passenger_name'       => $infos['passenger_name'],
            'journey_date'         => $infos['departure'],
            'journey_departure'    => $infos['start_address'],
            'journey_arrival'      => $infos['end_address'],
            'driver_name'          => $infos['driver_name'],
        ]);

        return redirect()->to('myprofil')
            ->with('success', 'Réservation refusée');
    }

    /**
     * @param int $idBooking The booking id we want to prepare the mail for
     * @param int $idPassenger Optionnal, if not set, it took the id of the connected user
     * 
     * @return array A list of infos that are needed for the mail, see the code for the full list
     */
    private function gatherMailInfos(int $idBooking, int $idPassenger = -1): array
    {
        //We check if an id has been provided, if not we set the id to the connected user
        if ($idPassenger === -1) {
            $idPassenger = session('user_id');
        }

        //Model declaration
        $bookingModel = model('BookingModel');
        $userModel = model('UserModel');
        $journeyModel = model('JourneyDriveModel');
        $locationModel = model('LocationModel');

        //Gathering all informations
        $booking = $bookingModel->find($idBooking);
        $journey = $journeyModel->find($booking['id_journey_drive']);

        $passenger = $userModel->find($idPassenger);
        $driver = $userModel->find($journey['driver']);



        //Prepare the infos in an array
        $infos['passenger_name'] = $passenger['first_name'] . " " . $passenger['last_name'];
        $infos['passenger_email'] = $passenger['email'];
        $infos['passenger_mobile'] = $passenger['mobile'];

        $infos['driver_name'] = $driver['first_name'] . " " . $driver['last_name'];
        $infos['driver_email'] = $driver['email'];
        $infos['driver_mobile'] = $driver['mobile'];

        $infos['departure'] = $journey['departure'];
        $infos['start_address'] = $locationModel->getFormattedAddress($journey['start']);
        $infos['end_address'] = $locationModel->getFormattedAddress($journey['end']);
        return $infos;
    }
    // Canceling a trip from a driver

    public function cancelJourney($id_journey_drive)
    {
        $journeyModel = new JourneyDriveModel();
        $bookingModel = new BookingModel();

        $journey = $journeyModel->find($id_journey_drive);
        if (!$journey || $journey['driver'] != session('user_id')) {
            return redirect()->to('myprofil')
                ->with('error', 'Trajet introuvable ou action non autorisée');
        }
        // If the journey is no longer active
        if ($journey['departure'] <= date('Y-m-d H:i:s')) {
            return redirect()->to('myprofil')
                ->with('error', 'Impossible d\'annuler un trajet passé');
        }

        // Cancel the journey and all related reservations
        $bookingModel
            ->where('id_journey_drive', $id_journey_drive)
            ->set(['deletion_date' => date('Y-m-d')])
            ->update();


        // Cancel the trip
        $journeyModel->update($id_journey_drive, ['deletion_date' => date('Y-m-d')]);

        return redirect()->to('myprofil')
            ->with('success', 'Trajet annulé');
    }
}
