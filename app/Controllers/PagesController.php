<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Models\JourneyDriveModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use DateTime;

class PagesController extends BaseController
{
    /**
     * Home page
     * @return string
     */
    public function home(): string
    {
        helper('form');

        return view('HomeView');
    }

    /**
     * Journey creation page
     * @return string
     */
    public function createJourney(): string
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
     * Itinerary search page (currently only JourneyDrive searching)
     * @return string
     */
    public function searchJourney(): string
    {
        helper('form');

        return view('itinerary/search/SearchView');
    }

    /**
     * JourneyDrive edition page
     * @param ?int $id = null
     * @return string|PageNotFoundException
     */
    public function editJourneyDrive(?int $id = null): string|PageNotFoundException
    {
        if ($id === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        helper('form');
        helper('french');

        $journeyDriveModel = model(JourneyDriveModel::class);

        $data['journey'] = $journeyDriveModel->getAllJourneyInfos($id);

        // Echoue si l'utilisateur n'est pas le propriétaire du trajet
        if ($data['driver'] != session()->get('user_id')) {
            throw PageNotFoundException::forPageNotFound();
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
