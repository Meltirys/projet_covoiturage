<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Validators\RegistrationValidator;
use App\Models\JourneyDriveModel;
use App\Models\CarModel;

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
        // Valeurs :
        // string(start) string(end) array{string(stop),string(stop)} string(start-time) string(end-time) array(car) string(seats) string(options)

        // What I need to do :
        // 1. Vérifier voiture
        // 2. Créer city/location
        // 3. Créer trajet
        // 4. Associer voiture
        // 5. Créer stages
        // 6. Insérer options
        // 7. Créer booking conducteur

        helper('form');

        $journey = [
            'start'      => $this->request->getPost('start'),
            'end'        => $this->request->getPost('end'),
            'stop'       => $this->request->getPost('stop'),
            'start-time' => $this->request->getPost('start-time'),
            'car'     => intval($this->request->getPost('car')),
            'seats'      => intval($this->request->getPost('seats')),
            'options'    => $this->request->getPost('options'),
            'user_id'    => session()->get('user_id')
        ];

        $carModel = model(CarModel::class);

        // Replaces the "car" field from the car's ID to all its information in the Car table
        $journey['car'] = $carModel
            ->where('id_car', $journey['car_id'])
            ->where('id_user', $journey['user_id'])
            ->first();

        if (! $journey['car']) {
            return redirect()->back()
                ->with('error', 'Voiture invalide');
        }

        //Calling the specific validator
        $validator = new RegistrationValidator();

        //If an error is detected, return to the form with the errors described
        if (!$validator->validate($journey)) {
            return view('CreateView', [
                'errors' => $validator->getErrors()
            ]);
        }

        $journeyDriveModel = model(JourneyDriveModel::class);

        /* 
         * Tries to save a new user.    
         * If there were errors, returns to view with them in the following format :
         * [ 'field1' => 'error message', 'field2' => 'error message', ]
         */
        if (! $journeyDriveModel->save($journey)) {
            $errors = $journeyDriveModel->errors();

            return redirect()->to('/')
                ->with('errors', $errors)
                ->withInput()
                ->with('status', 'Votre trajet n\'a pas pu être crée');
        }

        //gpt booking creation
        // $bookingModel = new BookingModel();

        // $bookingModel->insert([
        //     'booking_date'    => date('Y-m-d H:i:s'),
        //     'seat_taken'      => 1,
        //     'is_validated'    => 1,
        //     'is_driver'       => 1,
        //     'id_user'         => $userId,
        //     'id_journey_drive'=> $journeyId
        // ]);

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
