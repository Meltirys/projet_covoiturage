<?php

namespace App\Controllers\Journey;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\JourneyRequestModel;
use App\Models\CarModel;
use App\Validators\CreateJourneyRequestValidator;
use DateTime;
use PDOException;

class RequestController extends BaseController
{
    /**
     * Displays the search page listing itineraries
     */
    public function search()
    {
        helper('form');
        return view('itinerary/search/SearchView');
    }

    /**
     * Displays the page for a specific trip
     * 
     * parameter : itinerary id
     */
    public function show(?string $slug = null)
    {
        $model = model(JourneyRequestModel::class);

        $data['itinerary'] = $model->getItinerary($slug);

        if ($data['itinerary'] === null) {
            throw new PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        return view('news/view', $data);
    }

    /**
     * Displays the creation page for a new itinerary
     */
    public function create()
    {
        helper('form');
        return view('itinerary/create/CreateView');
    }


    /**
     * Saves an itinerary
     */
    public function save()
    {
        helper('form');

        /* Inputs
         * start = ['label', 'city', 'postcode', 'lat', 'lon']
         * end = [...]
         * departure['date', 'time'], estimated_arrival['date', 'time']
         * range-start, range-end
         * 
         * options?
         */

        $data = $this->request->getPost('request');

        $data['start-datetime'] = (new DateTime(
            $data['start-date'] . ' ' . $data['start-time']
        ))->format('Y-m-d H:i:s');

        $data['end-datetime'] = (new DateTime(
            $data['end-date'] . ' ' . $data['end-time']
        ))->format('Y-m-d H:i:s');


        // Validation
        $validator = new CreateJourneyRequestValidator;

        if (! $validator->validate($data)) {
            log_message('debug', 'Validation failed. Errors: ' . json_encode($validator->getErrors()));
            return redirect()->back()
                ->with('request_errors', $validator->getErrors())
                ->with('failed_form', 'request')
                ->withInput();
        }

        log_message('debug', 'Validation passed. Creating journey...');



        // Logic
        try {
            $journeyService = service('journeyService');

            // === Ajouter options quand possible !
            $journeyId = $journeyService->createJourneyRequest(
                $data,
                session()->get('user_id')
            );

            log_message('debug', 'Journey created successfully. ID: ' . $journeyId);
            return redirect()->to('/')
                ->with('status', 'Itinéraire créé avec succès');
        } catch (\DomainException $e) {
            // user error (e.g. chosen more seats than available in car)
            log_message('debug', 'Domain error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        } catch (\Throwable $e) {
            // system error
            log_message('error', 'Error in save(): ' . $e->getMessage());
            log_message('error', 'Stack: ' . $e->getTraceAsString());
            var_dump($data);
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
