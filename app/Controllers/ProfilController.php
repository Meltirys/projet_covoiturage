<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Models\BookingModel;
use App\Models\JourneyDriveModel;
use App\Models\UserModel;

class ProfilController extends BaseController
{
    /**
     * Shows the profil of the connected user
     */
    public function index()
    {
        helper('form');

        //Loading the cars of the user
        $carModel = new CarModel();
        $cars = $carModel->getCarsByUser(session()->user_id);

        $bookingModel = new BookingModel();
        $journeyModel = new JourneyDriveModel();
        $userModel    = new UserModel();
        $today        = date('Y-m-d H:i:s');

        // Partie passager
        $allBookings       = $bookingModel->where('id_user', session('user_id'))->findAll();
        $upcomingConfirmed = [];
        $upcomingPending   = [];
        $pastJourney       = [];
        $passengerJourneyDone = 0;
        foreach ($allBookings as $booking) {
            $journey = $journeyModel->where('deletion_date IS NULL')
                ->find($booking['id_journey_drive']);

            //checking the journey still exists
            if ($journey) {
                $booking['journey']     = $journey;
                $driver                 = $userModel->find($journey['driver']);
                $booking['driver_name'] = $driver['first_name'] . ' ' . substr($driver['last_name'], 0, 1) . '.';
                if ($journey['departure'] < $today) {
                    $pastJourney[] = $booking;
                    if ($booking['is_validated']) $passengerJourneyDone++; //Updating the stats

                } elseif ($booking['is_validated']) {
                    $upcomingConfirmed[] = $booking;
                } else {
                    $upcomingPending[] = $booking;
                }
            }
        }

        // Partie conducteur
        $myJourneys      = $journeyModel->where('driver', session('user_id'))->where('deletion_date', null)->findAll();
        $driveUpcoming   = [];
        $drivePast       = [];
        $pendingRequests = [];
        $driverJourneyDone = 0;
        $passengerTaken = 0;
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
                $driverJourneyDone++;
                $passengerTaken += $placesOccupees;
            } else {
                $driveUpcoming[] = $journey;
            }
            $requests = $bookingModel
                ->where('id_journey_drive', $journey['id_journey_drive'])
                ->where('is_validated', false)
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
            'passengerJourneyDone' => $passengerJourneyDone,
            'driverJourneyDone' => $driverJourneyDone,
            'passengerTaken' => $passengerTaken
        ]);
    }

    /**
     * Show the view which allows to modify the user information (except for the password)
     */
    public function modify()
    {
        helper('form');

        $data['user'] = $this->loadUserInfos();

        //Retrieving the potential errors in the forms
        if (session()->getFlashdata('user_update_error')) {
            $data['errors'] = session()->getFlashdata('user_update_error');
        }
        if (session()->getFlashdata('avatar_update_error')) {
            $data['errors'] = session()->getFlashdata('avatar_update_error');
        }

        return view('profil/modify', $data);
    }

    public function show(int $id)
    {
        helper('form');

        $userModel    = new UserModel();
        $journeyModel = new JourneyDriveModel();
        $bookingModel = new BookingModel();
        $today        = date('Y-m-d H:i:s');

        $user = $userModel->find($id);
        
        //Storing the id of the user we consult in session to ensure the reported user is valid
        session()->set('viewed_user_id', $id);

        if (!$user) {
            return redirect()->to('/')->with('error', 'Utilisateur introuvable');
        }

        $connectedId   = session('user_id');
        $isOwnProfile  = (int) $id === (int) $connectedId;

        if ($isOwnProfile) {
            return redirect()->to('/myprofil');
        }

        // Vérifie si les deux utilisateurs partagent un trajet (pour le signalement)
        $canReport = false;
        $connectedDriverJourneys = $journeyModel->where('driver', $connectedId)->where('deletion_date', null)->findAll();
        $connectedDriverIds      = array_column($connectedDriverJourneys, 'id_journey_drive');

        $connectedBookings     = $bookingModel->where('id_user', $connectedId)->where('deletion_date IS NULL')->findAll();
        $connectedPassengerIds = array_column($connectedBookings, 'id_journey_drive');

        $allJourneyIds = array_unique(array_merge($connectedDriverIds, $connectedPassengerIds));

        if (!empty($allJourneyIds)) {
            $targetIsDriver = $journeyModel
                ->where('driver', $id)
                ->whereIn('id_journey_drive', $allJourneyIds)
                ->where('deletion_date', null)
                ->first();

            $targetIsPassenger = $bookingModel
                ->where('id_user', $id)
                ->whereIn('id_journey_drive', $allJourneyIds)
                ->where('deletion_date IS NULL')
                ->first();

            $canReport = $targetIsDriver || $targetIsPassenger;
        }

        $driverJourneyDone = 0;
        $passengerTaken = 0;

        $myJourneys = $journeyModel->where('driver', $id)->where('deletion_date', null)->findAll();
        foreach ($myJourneys as $journey) {
            if ($journey['departure'] < $today) {
                $driverJourneyDone++;
                $passengerTaken += (int) $bookingModel
                    ->selectSum('seat_taken')
                    ->where('id_journey_drive', $journey['id_journey_drive'])
                    ->where('is_validated', true)
                    ->where('deletion_date IS NULL')
                    ->get()->getRow()->seat_taken;
            }
        }

        $passengerJourneyDone = $bookingModel
            ->where('id_user', $id)
            ->where('is_validated', true)
            ->where('deletion_date IS NULL')
            ->countAllResults();

        return view('profil/public', [
            'user'                 => $user,
            'driverJourneyDone'    => $driverJourneyDone,
            'passengerTaken'       => $passengerTaken,
            'passengerJourneyDone' => $passengerJourneyDone,
            'canReport'            => $canReport,
        ]);
    }

    /*
    * Shows the page where the password can be changed. Access route is /profil/changePassword
    */
    public function showPasswordChange()
    {
        helper('form');

        $data['errors'] = [];

        if (session()->getFlashdata('password_change_error')) {
            $data['errors'] = session()->getFlashdata('password_change_error');
        }

        return view('profil/changePassword', $data);
    }

    /**
     * Returns the informations of the user, including the name of the city, the post code, the address and all the attributes in the User table
     * @return array An array that contains the informations of the user
     */
    private function loadUserInfos(): array
    {
        $userModel = model('UserModel');
        $cityModel = model('CityModel');
        $locationModel = model('LocationModel');

        $user = $userModel->find(session()->user_id); // Retrieving the user infos

        $address = $locationModel->find($user['id_location']); // Retrieving the address
        $user['address'] = $address['address'];

        $city = $cityModel->find($address['id_city']); //Retrieving the city infos
        $user['city'] = $city['name'];
        $user['postcode'] = $city['postcode'];

        return $user;
    }
}
