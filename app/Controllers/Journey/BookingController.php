<?php

namespace App\Controllers\Journey;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\JourneyDriveModel;

class BookingController extends BaseController
{
    // Show user reservations when connected (à intégrer dans le profil)
    public function index()
    {
        $bookingModel = new BookingModel();
        $journeyModel = new JourneyDriveModel();
        $today = date('Y-m-d');

        // Partie passager
        $allBookings = $bookingModel->where('id_user', session('user_id'))->findAll();
        $upcomingConfirmed = [];
        $upcomingPending   = [];
        $pastJourney       = [];
        foreach($allBookings as $booking) {
            $journey = $journeyModel->find($booking['id_journey_drive']);
            $booking['journey'] = $journey;

            if($journey['departure'] < $today) {
                $pastJourney[] = $booking;
            }
            elseif($booking['is_validated']) {
                $upcomingConfirmed[] = $booking;
            }
            else
            {
                $upcomingPending[] = $booking;
            }
        }

        // Partie conducteur

        $myJourneys = $journeyModel->where('driver', session('user_id'))->findAll();
        $driveUpcoming   = [];
        $drivePast       = [];
        $pendingRequests  = [];
        foreach($myJourneys as $journey) {

            if($journey['departure'] < $today) {
                $drivePast[] = $journey;
            }
            else
            {
                $driveUpcoming[] = $journey;
            }

            $requests = $bookingModel
                ->where('id_journey_drive', $journey['id_journey_drive'])
                ->where('is_validated', false)
                ->where('is_driver', false)
                ->findAll();
                foreach ($requests as $request) {
                    $pendingRequests[] = array_merge($request, ['journey' => $journey]);
                }
        }

        $data = [
            'upcomingConfirmed' => $upcomingConfirmed,
            'upcomingPending'   => $upcomingPending,
            'pastJourney'       => $pastJourney,
            'driveUpcoming'     => $driveUpcoming,
            'drivePast'         => $drivePast,
            'pendingRequests'   => $pendingRequests,
        ];
        return view('booking/MyBookingsView', $data);
    }

    public function show($id_journey_drive)
    {
        helper('form');

        $journeyModel = new JourneyDriveModel();
        $journey = $journeyModel->find($id_journey_drive);
        if(!$journey) {
            return redirect()->to('trajet')
            ->with('error', 'Trajet introuvable');
        }
        return view('booking/BookingView', ['journey' => $journey]);
    }

    public function save()
    {
        $journeyModel = new JourneyDriveModel();
        $bookingModel = new BookingModel();
        $journeyID = $this->request->getPost('id_journey_drive');
        $journey   = $journeyModel->find($journeyID);
        // If route doesn't exist
        if(!$journey) {
            return redirect()->back()
            ->with('error', 'Trajet introuvable');
        }
        // If is the driver
        if($journey['driver'] == session('user_id')) {
            return redirect()->back()
            ->with('error', 'Vous ne pouvez pas réserver votre propre trajet !');
        }
        // If already reserved
        $exist = $bookingModel
            ->where('id_journey_drive', $journeyID)
            ->where('id_user', session('user_id'))
            ->first();
        if($exist) {
            return redirect()->back()
                ->with('error', 'Vous avez déjà une réservation sur ce trajet !');
        }
        // If there still available seat
        $seatTaken = (int) ($this->request->getPost('seat_taken') ?? 1);
        if($seatTaken < 1 || $seatTaken > $journey['number_of_place']) {
            return redirect()->back()
                ->with('error', 'Plus aucune place de disponible');
        }
        //
        $bookingModel->insert([
            'booking_date'      => date('Y-m-d'),
            'seat_taken'        => $seatTaken,
            'id_user'           => session('user_id'),
            'id_journey_drive'  => $journeyID,
            'is_validated'      => false,
            'is_driver'         => false,

        ]);

        return redirect()->to('mes-reservations')
            ->with('success', 'Réservation réussie');
    }

    // Annulation d'une réservation d'un utilisateur

    public function cancel($id_booking)
    {
        $bookingModel = new BookingModel();
        $booking = $bookingModel->find($id_booking);
        if(! $booking || $booking['id_user'] != session('user_id')) {
            return redirect()->to('mes-reservations')
                ->with('error', 'Réservation introuvable');
        }

        $bookingModel->delete($id_booking);
        return redirect()->to('mes-reservations')
            ->with('success', 'Réservation annulée');
    }

    // Acceptation d'une réservation de la part d'un conducteur

    public function accept($id_booking)
    {
        $bookingModel = new BookingModel();
        $journeyModel = new JourneyDriveModel();
        $booking = $bookingModel->find($id_booking);
        if(!$booking) {
            return redirect()->to('mes-reservations')
                ->with('error', 'Réservation introuvable');
        }

        $journey = $journeyModel->find($booking['id_journey_drive']);
        if(!$journey || $journey['driver'] != session('user_id')) {
            return redirect()->to('mes-reservations')
                ->with('error', 'Action non autorisée');
        }

        $bookingModel->update($id_booking, ['is_validated' => true]);
        return redirect()->to('mes-reservations')
            ->with('success', 'Demande acceptée !');
    }

    public function refuse($id_booking)
    {
        $bookingModel = new BookingModel();
        $journeyModel = new JourneyDriveModel();
        $booking = $bookingModel->find($id_booking);
        if(!$booking) {
            return redirect()->to('mes-reservations')
                ->with('error', 'Réservation introuvable');
        }

        $journey = $journeyModel->find($booking['id_journey_drive']);
        if(!$journey || $journey['driver'] != session('user_id')) {
            return redirect()->to('mes-reservations')
                ->with('error', 'Action non autorisée');
        }

        $bookingModel->delete($id_booking);
        return redirect()->to('mes-reservations')
            ->with('success', 'Réservation refusée');
    }
}
