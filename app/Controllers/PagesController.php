<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Models\JourneyDriveModel;
use App\Services\JourneyService;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\School;
use DateTime;

class PagesController extends BaseController
{
    /**
     * Home page
     */
    public function home(): string
    {
        helper('form');
        helper('french_helper');

        $datas = [];

        //If an user is logged in, we retrieve the latest journey available
        if (session('logged_in')) {
            $journeyService = new JourneyService();
            $datas['journeys'] = $journeyService->getNextAvailableJourneys('drive', 5); //Loads the available journeys
            //Transforming the dates
            foreach ($datas['journeys'] as &$journey) {
                $journey['departure'] = format_date_fr($journey['departure']);
            }
            unset($journey); //Cleaning the memory
        }

        if (session()->errors) {
            $datas['errors'] = session()->errors; // Loading the errors of the contact form
        }

        return view('HomeView', $datas);
    }

    /**
     * Mentions légales
     */
    public function mentionsLegales(): string
    {
        return view('legal/LegalNotice');
    }

    /**
     * CGU
     */
    public function cgu(): string
    {
        return view('legal/CGU');
    }

    /**
     * Comment ça marche ?
     */
    public function HowItWorks(): string
    {
        return view('HowItWorks');
    }

    /**
     * Contact
     */
    public function contactPage(): string
    {
        helper('form');
        $datas = [];
        if (session()->errors) {
            $datas['errors'] = session()->errors; // Loading the errors of the contact form
        }
        return view('ContactView', $datas);
    }

    /**
     * Journey creation page
     */
    public function createJourney(): string
    {
        helper('form');
        $school = config(School::class);

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

        //Store the school name in a 
        $data['schoolName'] = $school->name ?? 'Nom de l\'école introuvable';

        return view('itinerary/create/CreateView', $data);
    }

    /**
     * Itinerary search page (currently only JourneyDrive searching)
     */
    public function searchJourney()
    {
        helper('form');

        return view('itinerary/search/SearchView');
    }

    /**
     * JourneyDrive edition page
     * @param ?int $id = null
     */
    public function editJourneyDrive(?int $id = null)
    {
        if ($id === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $school = config(School::class);
        $schoolName = $school->name;

        helper('form');

        $journeyDriveModel = model(JourneyDriveModel::class);
        $carModel = model(CarModel::class);

        $journey = $journeyDriveModel->getAllJourneyInfos($id);

        if (!$journey) {
            throw PageNotFoundException::forPageNotFound('Une erreur s\'est produite. Impossible de trouver l\'itinéraire : ' . $id);
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

        foreach ($journey['stages'] as $key => $stage) {
            $journey['stages'][$key]['label'] =  $stage['address'];
            $journey['stages'][$key]['city'] =  $stage['city_name'];
            $journey['stages'][$key]['address'] = $journey['stages'][$key]['label'] . " " . $stage['postcode'] . " " . $stage['city_name'];
        }

        $dateDeparture = new Datetime($journey['departure']);
        $journey['departure_date'] = $dateDeparture->format('Y-m-d');
        $journey['departure_time'] = $dateDeparture->format('H:i');

        $dateArrival = new DateTime($journey['estimated_arrival']);
        $journey['arrival_date'] = $dateArrival->format('Y-m-d');
        $journey['arrival_time'] = $dateArrival->format('H:i');

        $cars = $carModel->where('id_user', $journey['driver'])->findAll();

        return view('itinerary/edit/EditDriveView', ['journey' => $journey, 'cars' => $cars, 'schoolName' => $schoolName]);
    }
}
