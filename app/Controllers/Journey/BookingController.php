<?php

namespace App\Controllers\Journey;

use App\Controllers\BaseController;
use App\Helpers\EmailTemplates;
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
        // If route doesn't exist or has been deleted
        if (!$journey || !is_null($journey['deletion_date'])) {
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

        $validator = new BookingValidator();
        $data = [
            'booking_date'     => date('Y-m-d'),
            'seat_taken'       => $seatTaken,
            'meeting_point'    => $this->request->getPost('meeting_point') ?? null,
            'id_user'          => session('user_id'),
            'id_journey_drive' => $journeyID,
        ];

        if (!$validator->validate($data)) {
            return redirect()->back()
                ->with('error', implode(' ', $validator->getErrors()));
        }

        $idBooking = $bookingModel->insert($data);

        try {
            //Preparing the mail
            $mailService = new MailService();
            helper('mail_helper');
            $infos = $this->gatherMailInfos($idBooking);

            $bodyPassenger = EmailTemplates::bookingRequestConfirmation(
                $infos['passenger_name'],
                $infos['start_address'],
                $infos['end_address'],
                $infos['departure']
            );

            $bodyDriver = EmailTemplates::bookingRequestPending(
                $infos['driver_name'],
                $infos['passenger_name'],
                $infos['start_address'],
                $infos['end_address'],
                $infos['departure']
            );

            //Sending the mail to the user that the request has been sent
            $mailService->send(
                $infos['passenger_email'],
                'Votre demande de participation a bien été envoyée',
                $bodyPassenger
            );

            //Sending the mail to inform the driver a new reservation has been made
            $mailService->send(
                $infos['driver_email'],
                'Une demande de validation de participation à un trajet en attente',
                $bodyDriver
            );
        } catch (\Exception $e) {
            log_message('error', 'Erreur envoi mail : ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Demande de réservation envoyée');
    }

    /**
     * Cancel the booking of the passenger with id_booking
     * @param mixed $id_booking The if of the id to cancel
     */
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

        if ($journey['departure'] <= date('Y-m-d H:i:s') || !is_null($journey['deletion_date'])) {
            return redirect()->to('myprofil')
                ->with('error', 'Impossible d\'annuler un trajet passé ou supprimé');
        }

        $infos = $this->gatherMailInfos($id_booking); //Gather infos before deletion

        $bookingModel->delete($id_booking);

        //Sending the mail
        try {
            //Preparing the mail service
            $mailService = new MailService();
            helper('mail_helper');

            //Retrieving the infos needed for the mail
            $body = EmailTemplates::passengerCancelledConfirmation(
                $infos['passenger_name'],
                $infos['start_address'],
                $infos['end_address'],
                $infos['departure'],
            );
            //Send the mail to the passenger that it's application has been refused
            $mailService->send(
                $infos['passenger_email'],
                'Votre demande de participation à un trajet à bien été annulée',
                $body
            );
        } catch (\Exception $e) {
            log_message('error', 'Erreur envoi mail : ' . $e->getMessage());
        }
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

        if ($journey['departure'] <= date('Y-m-d H:i:s') || !is_null($journey['deletion_date'])) {
            return redirect()->to('myprofil')
                ->with('error', 'Impossible de valider une réservation d\'un trajet passé ou supprimé');
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

        if ($booking['is_validated']) {
            return redirect()->to('myprofil')
                ->with('error', 'Ce trajet à déjà été validé');
        }

        $bookingModel->update($id_booking, ['is_validated' => true]);

        //Sending the mail
        try {
            //Preparing the mail service
            $mailService = new MailService();
            helper('mail_helper');

            //Retrieving the infos needed for the mail
            $infos = $this->gatherMailInfos($id_booking, $booking['id_user']);
            $body = EmailTemplates::requestAccepted(
                $infos['passenger_name'],
                $infos['start_address'],
                $infos['end_address'],
                $infos['departure'],
                $journey['id_journey_drive']
            );
            //Send the mail to the passenger that it's application has been refused
            $mailService->send(
                $infos['passenger_email'],
                'Votre demande de participation à un trajet à été accepté',
                $body
            );
        } catch (\Exception $e) {
            log_message('error', 'Erreur envoi mail : ' . $e->getMessage());
        }

        return redirect()->to('myprofil')
            ->with('success', 'Demande acceptée !');
    }


    /**
     * Delete the pending booking. Only to the journey driver can refuse
     * @param mixed $id_booking The id of the booking to refuse
     */
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

        if ($journey['departure'] <= date('Y-m-d H:i:s') || !is_null($journey['deletion_date'])) {
            return redirect()->to('myprofil')
                ->with('error', 'Refus impossible sur un trajet déjà passé ou supprimé');
        }


        //Must be called before delete() 
        $infos = $this->gatherMailInfos($id_booking, $booking['id_user']);

        $bookingModel->delete($id_booking);

        try {
            //Preparing the mail service
            $mailService = new MailService();
            helper('mail_helper');

            //Retrieving the infos needed for the mail
            $body = EmailTemplates::requestRefused(
                $infos['passenger_name'],
                $infos['start_address'],
                $infos['end_address'],
                $infos['departure']
            );
            //Send the mail to the passenger that it's application has been refused
            $mailService->send(
                $infos['passenger_email'],
                'Votre demande de participation à un trajet à été refusée',
                $body
            );
        } catch (\Exception $e) {
            log_message('error', 'Erreur envoi mail : ' . $e->getMessage());
        }

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

    /**
     * Used when a driver wants to cancel his journey. It desactivates all the booking and soft delete the journey
     * @param int $id_journey_drive
     */
    public function cancelJourney(int $id_journey_drive)
    {
        $journeyModel = new JourneyDriveModel();
        $bookingModel = new BookingModel();

        $journey = $journeyModel->find($id_journey_drive);
        if (!$journey || $journey['driver'] != session('user_id')) {
            return redirect()->to('myprofil')
                ->with('error', 'Trajet introuvable ou action non autorisée');
        }
        // If the journey is no longer active
        if ($journey['departure'] <= date('Y-m-d H:i:s') || !is_null($journey['deletion_date'])) {
            return redirect()->to('myprofil')
                ->with('error', 'Impossible d\'annuler un trajet passé ou déjà annulé');
        }

        //Retrivieving the ids of the users on the journey
        $bookings =  $bookingModel
            ->where('id_journey_drive', $id_journey_drive)
            ->where('is_validated', true)
            ->findAll();
        try {
            //Preparing the mail service
            $mailService = new MailService();
            helper('mail_helper');

            foreach ($bookings as $booking) {
                //Retrieving the infos needed for the mail
                $infos = $this->gatherMailInfos($booking['id_booking'], $booking['id_user']);
                $body = EmailTemplates::driverCancelledJourney(
                    $infos['passenger_name'],
                    $infos['start_address'],
                    $infos['end_address'],
                    $infos['departure'],
                );

                //Send the mail to the passenger that it's journey has been cancelled
                $mailService->send(
                    $infos['passenger_email'],
                    'Un conducteur a annulé un trajet sur lequel vous étiez inscrit',
                    $body
                );
            }
        } catch (\Exception $e) {
            log_message('error', 'Erreur envoi mail : ' . $e->getMessage());
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
