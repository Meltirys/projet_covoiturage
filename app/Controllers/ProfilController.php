<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Models\BookingModel;
use App\Models\JourneyDriveModel;
use App\Models\UserModel;

class ProfilController extends BaseController
{
    public function index()
    {
        helper('form');

        //Loading the cars of the user
        $carModel = new CarModel();
        $cars = $carModel->getCarsByUser(session()->user_id);

        $bookingModel = new BookingModel();
        $journeyModel = new JourneyDriveModel();
        $userModel    = new UserModel();
        $today        = date('Y-m-d');

        // Partie passager
        $allBookings       = $bookingModel->where('id_user', session('user_id'))->findAll();
        $upcomingConfirmed = [];
        $upcomingPending   = [];
        $pastJourney       = [];
        foreach ($allBookings as $booking) {
            $journey = $journeyModel->find($booking['id_journey_drive']);
            $booking['journey']     = $journey;
            $driver                 = $userModel->find($journey['driver']);
            $booking['driver_name'] = $driver['first_name'] . ' ' . substr($driver['last_name'], 0, 1) . '.';
            if ($journey['departure'] < $today) {
                $pastJourney[] = $booking;
            } elseif ($booking['is_validated']) {
                $upcomingConfirmed[] = $booking;
            } else {
                $upcomingPending[] = $booking;
            }
        }

        // Partie conducteur
        $myJourneys      = $journeyModel->where('driver', session('user_id'))->findAll();
        $driveUpcoming   = [];
        $drivePast       = [];
        $pendingRequests = [];
        foreach ($myJourneys as $journey) {
            $placesOccupees = (int) $bookingModel
                ->selectSum('seat_taken')
                ->where('id_journey_drive', $journey['id_journey_drive'])
                ->where('is_validated', true)
                ->where('deletion_date IS NULL')
                ->get()->getRow()->seat_taken;
            $journey['places_restantes'] = $journey['number_of_place'] - $placesOccupees;
            if ($journey['departure'] < $today) {
                $drivePast[] = $journey;
            } else {
                $driveUpcoming[] = $journey;
            }
            $requests = $bookingModel
                ->where('id_journey_drive', $journey['id_journey_drive'])
                ->where('is_validated', false)
                ->where('is_driver', false)
                ->findAll();
            foreach ($requests as $r) {
                $passenger = $userModel->find($r['id_user']);
                $r['passenger_name'] = $passenger['first_name'] . ' ' . substr($passenger['last_name'], 0, 1) . '.';
                $pendingRequests[] = array_merge($r, ['journey' => $journey]);
            }
        }

        return view('profil/index', [
            'cars'              => $cars,
            'errors'            => session('errors') ?? null,
            'upcomingConfirmed' => $upcomingConfirmed,
            'upcomingPending'   => $upcomingPending,
            'pastJourney'       => $pastJourney,
            'driveUpcoming'     => $driveUpcoming,
            'drivePast'         => $drivePast,
            'pendingRequests'   => $pendingRequests,
        ]);
    }

    public function modify() {}

    public function update() {}
}
