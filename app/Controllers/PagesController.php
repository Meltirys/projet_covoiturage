<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Models\JourneyDriveModel;
use DateTime;

class PagesController extends BaseController
{
    /**
     * Home page
     */
    public function home()
    {
        helper('form');

        return view('HomeView');
    }

    /**
     * Journey creation page
     */
    public function createJourney()
    {
        helper('form');

        $carModel = model(CarModel::class);

        $userId = session()->get('user_id');

        $cars = $carModel->getCarsByUser($userId);

        $data = [
            'cars' => array_map(fn($c) => [
                'id_car' => $c['id_car'],
                'label' => $c['brand'] . ' - ' . $c['model'],
                'seats' => $c['number_of_seat'],
            ], $cars)
        ];

        return view('itinerary/create/CreateView', $data);
    }

    /**
     * Itinerary search page
     */
    public function searchJourney()
    {
        helper('form');

        return view('itinerary/search/SearchView');
    }

    /**
     * 
     */
    public function editJourney(?int $id = null)
    {
        if ($id === null) {
            return view('404');
        }

        helper('form');
        helper('french');

        $journeyDriveModel = model(JourneyDriveModel::class);

        $data['journey'] = $journeyDriveModel->getAllJourneyInfos($id);

        $userId = session()->get('user_id');

        // Echoue si l'utilisateur n'est pas le propriétaire du trajet
        if ($data['driver'] != $userId) {
            return view('404');
        }

        // Formattage des données
        $data['journey']['departure_label'] = $data['journey']['departure_address'];
        $data['journey']['departure_address'] = $data['journey']['departure_label'] . " " . $data['journey']['departure_postcode'] . " " . $data['journey']['departure_city'];

        $data['journey']['arrival_label'] = $data['journey']['arrival_address'];
        $data['journey']['arrival_address'] = $data['journey']['arrival_label'] . " " . $data['journey']['arrival_postcode'] . " " . $data['journey']['arrival_city'];

        $data['journey']['stages']['label'] = $data['journey']['stages']['address'];
        $data['journey']['stages']['city'] = $data['journey']['stages']['city_name'];
        $data['journey']['stages']['address'] = $data['journey']['stages']['label'] . " " . $data['journey']['stages']['postcode'] . " " . $data['journey']['stages']['city'];

        $dateDeparture = new Datetime($data['journey']['departure']);
        $data['journey']['departure_date'] = $dateDeparture->format('Y-m-d');
        $data['journey']['departure_time'] = $dateDeparture->format('H:i');

        $dateArrival = new DateTime($data['journey']['estimated_arrival']);
        $data['journey']['arrival_date'] = $dateArrival->format('Y-m-d');
        $data['journey']['arrival_time'] = $dateArrival->format('H:i');

        return view('itinerary/edit/EditDriveView', $data);
    }
}
