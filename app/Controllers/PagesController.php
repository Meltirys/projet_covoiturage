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
     */
    public function home(): string
    {
        helper('form');

        return view('HomeView');
    }

    /**
     * Journey creation page
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
        $carModel = model(CarModel::class);

        $journey = $journeyDriveModel->getAllJourneyInfos($id);

        if (!$journey) {
            throw PageNotFoundException::forPageNotFound('Une erreur s\'est produite. Impossible de trouver l\'itinéraire : ' + $id);
        }

        // Echoue si l'utilisateur n'est pas le propriétaire du trajet
        if ($journey['driver'] != session()->get('user_id')) {
            throw PageNotFoundException::forPageNotFound(); // Remplacer par une page de non-authorisation
        }

        // Formattage des données
        $journey['departure_label'] = $journey['departure_address'];
        $journey['departure_address'] = $journey['departure_label'] . " " . $journey['departure_postcode'] . " " . $journey['departure_city'];

        $journey['arrival_label'] = $journey['arrival_address'];
        $journey['arrival_address'] = $journey['arrival_label'] . " " . $journey['arrival_postcode'] . " " . $journey['arrival_city'];

        foreach ($journey['stages'] as $stage) {
            $stage['label'] =  $stage['address'];
            $stage['city'] = $stage['city_name'];
            $stage['address'] = $stage['label'] . " " . $stage['postcode'] . " " . $stage['city'];
        }

        $dateDeparture = new Datetime($journey['departure']);
        $journey['departure_date'] = $dateDeparture->format('Y-m-d');
        $journey['departure_time'] = $dateDeparture->format('H:i');

        $dateArrival = new DateTime($journey['estimated_arrival']);
        $journey['arrival_date'] = $dateArrival->format('Y-m-d');
        $journey['arrival_time'] = $dateArrival->format('H:i');

        $cars = $carModel->where('id_user', $journey['driver'])->findAll();

        return view('itinerary/edit/EditDriveView', ['journey' => $journey, 'cars' => $cars]);
    }
}
