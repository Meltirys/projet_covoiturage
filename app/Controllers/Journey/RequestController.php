<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JourneyRequestModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ItineraryController extends BaseController
{
    /**
     * Displays the search page listing itineraries
     */
    public function search()
    {
        $data = ['type' => 'request'];

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
        $model = model(JourneyRequestModel::class);

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
        $data = ['type' => 'request'];

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
         * start_city, start_city_postcode, end_city, end_city_postcode,
         * start, start_lat, start_long,
         * end, end_lat, end_long,
         * description, range_of_time
         * 
         * 
         * options?
         */

        $data = $this->request->getPost();

        // Validation
        $validator = new JourneyRequestValidator;

        if (! $validator->validate($data)) {
            return redirect()->back()
                ->with('errors', $validator->getErrors())
                ->withInput();
        }

        // Logic
        try {
            $journeyService = service('journeyService');

            // === Ajouter options quand possible !
            $journeyId = $journeyService->createJourneyRequest(
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
