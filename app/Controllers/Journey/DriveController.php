<?php

namespace App\Controllers\Journey;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\JourneyDriveModel;
use App\Models\CarModel;
use App\Validators\JourneyDriveValidator;
use PDOException;

class DriveController extends BaseController
{
    /**
     * Displays the search page listing itineraries
     */
    public function search()
    {
        $data = ['type' => 'drive'];

        helper('form');
        return view('itinerary/search/SearchView', $data);
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
        helper('form');

        /* Needed inputs
         * id_car, start_city, start_city_postcode, end_city, end_city_postcode,
         * start, start_lat, start_long,
         * end, end_lat, end_long,
         * number_of_place, departure, estimated_arrival
         * stops[city_name, city_postcode, address, latitude, longitude]
         * 
         * options?
         */

        $data = $this->request->getPost();

        // Validation
        $validator = new JourneyDriveValidator;

        if (! $validator->validate($data)) {
            return redirect()->back()
                ->with('errors', $validator->getErrors())
                ->withInput();
        }



        // Logic
        try {
            $journeyService = service('journeyService');

            // === Ajouter options quand possible !
            $journeyId = $journeyService->createJourneyDrive(
                $data,
                session()->get('user_id')
            );

            return redirect()->to('/')
                ->with('status', 'Itinéraire créé avec succès');
        } catch (\DomainException $e) {
            // user error (e.g. chosen more seats than available in car)
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        } catch (\Throwable $e) {
            // system error
            log_message('error', $e->getMessage());

            return redirect()->back()
                ->with('error', 'Une erreur s\'est produite')
                ->withInput();
        }
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
