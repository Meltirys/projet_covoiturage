<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Validators\RegistrationValidator;
use App\Models\JourneyDriveModel;
use App\Models\CarModel;
use App\Models\CityModel;
use App\Models\LocationModel;

class ItineraryController extends BaseController
{
    /**
     * Displays the search page listing itineraries
     */
    public function search()
    {
        $data = ['type' => 'drive'];

        helper('form');
        return view('commons/header')
            . view('itinerary/search/SearchView', $data)
            . view('commons/footer');
    }

    /**
     * Displays the page for a specific trip
     * 
     * parameter : itinerary id
     */
    public function show(?string $slug = null)
    {
        $model = model(JourneyDriveModel::class);

        $data['itinerary'] = $model->getItinerary($slug);

        if ($data['itinerary'] === null) {
            throw new PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        return view('templates/header', $data)
            . view('news/view', $data)
            . view('templates/footer');
    }

    /**
     * Displays the creation page for a new itinerary
     */
    public function create()
    {
        $carModel = model(CarModel::class);

        $data = [
            'type' => 'drive',
            'cars' => $carModel->getCarsByUser(session('user_id'))
        ];

        helper('form');
        return view('commons/header')
            . view('itinerary/create/CreateView', $data)
            . view('commons/footer');
    }

    /**
     * Saves an itinerary
     */
    public function save()
    {
        // Etapes :
        // 1. Vérifier voiture
        // 2. Créer city/location
        // 3. Créer trajet
        // 4. Créer stages
        // 5. Insérer options

        helper('form');

        $journey = [
            'number_of_place'      => intval($this->request->getPost('seats')),
            'departure' => $this->request->getPost('start-time'),
            'estimated_arrival' => $this->request->getPost('end-time'),
            'id_car'        => intval($this->request->getPost('car')),
        ];

        $startLocation = [
            'start'      => $this->request->getPost('start'),
            'start_lat' => 10,
            'start_long' => 10,
        ];

        $startCity = [
            'start_city' => mb_convert_case(trim('Vannes'), MB_CASE_TITLE, "UTF-8"),
            'start_city_postcode' => '56000',
        ];

        $endLocation = [
            'end' => $this->request->getPost('end'),
            'end_lat' => 10,
            'end_long' => 10,
        ];

        $endCity = [
            'end_city' => mb_convert_case(trim('Vannes'), MB_CASE_TITLE, "UTF-8"),
            'end_city_postcode' => '56000',
        ];

        // Reste :
        # 'options'    => $this->request->getPost('options')
        # 'stops'       => $this->request->getPost('stop'),

        // TODO : Validation step

        // === Gets car
        $carModel = model(CarModel::class);

        $car = $carModel
            ->where('id_car', $journey['car_id'])
            ->where('id_user', session()->get('user_id'))
            ->first();

        if (! $car) {
            return redirect()->back()
                ->with('error', 'Voiture invalide');
        }
        // ===

        // === Gets city (insertion if didn't exist)
        $cityModel = model(CityModel::class);

        $startCityID = $cityModel->getOrCreate($startCity['start_city'], $startCity['start_city_postcode']);
        $endCityID = $cityModel->getOrCreate($endCity['end_city'], $endCity['end_city_postcode']);
        //

        // === Gets location (insertion if didn't exist)
        $locationModel = model(LocationModel::class);

        $journey['start'] = $locationModel->getOrCreate($startLocation['start'], $startCityID, $startLocation['start_lat'], $startLocation['start_long']);
        $journey['end'] = $locationModel->getOrCreate($endLocation['end'], $endCityID, $endLocation['end_lat'], $endLocation['end_long']);
        // ===

        // === Creates journey
        $journeyDriveModel = model(JourneyDriveModel::class);


        if (! $journeyDriveModel->save($journey)) {
            $errors = $userModel->errors();

            return redirect()->to('/')
                ->with('errors', $errors)
                ->withInput()
                ->with('error', 'Votre trajet n\'a pas pu être créé');
        }
        // ===

        // === Créer stages
        // ===

        // === Ajouter options
        // ===

        return redirect()->to('/')
            ->with('status', 'Itinéraire créé avec succès');
    }

    /**
     * Updates an existing itinerary
     * 
     * parameter : itinerary id
     */
    public function update($id) {}

    /**
     * Deletes an existing itinerary
     * 
     * parameter : itinerary id
     */
    public function delete($id) {}
}
