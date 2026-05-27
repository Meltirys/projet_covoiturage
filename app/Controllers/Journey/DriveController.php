<?php

namespace App\Controllers\Journey;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\JourneyDriveModel;
use App\Models\CarModel;
use App\Validators\CreateJourneyDriveValidator;
use App\Validators\SearchJourneyDriveValidator;
use PDOException;

class DriveController extends BaseController
{
    /**
     * Searches for matching itineraries
     */
    public function search()
    {
        /* Inputs :
         * start = ['label', 'city', 'postcode', 'lat', 'lon']
         * end = [...]
         * date
         * passengers (default 1)
         * (optional) filters
         */

        $data = $this->request->getPost();

        // Validation
        $validator = new SearchJourneyDriveValidator;

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
     * Saves an itinerary
     */
    public function save()
    {
        helper('form');

        /* Inputs :
         * start = ['label', 'city', 'postcode', 'lat', 'lon']
         * end = [...]
         * stops = [0 = [...], 1 = [...],]
         * id_car, number_of_place
         * departure['date', 'time'], estimated_arrival['date', 'time']
         * 
         * TODO :
         * - Check geocoding validity of address inputs
         * - Options ?
         */

        $data = $this->request->getPost();

        // Validation
        $validator = new CreateJourneyDriveValidator;

        if (! $validator->validate($data)) {
            log_message('debug', 'Validation failed. Errors: ' . json_encode($validator->getErrors()));
            return redirect()->back()
                ->with('errors', $validator->getErrors())
                ->withInput();
        }

        log_message('debug', 'Validation passed. Creating journey...');

        // Logic
        try {
            $journeyService = service('journeyService');

            // === Ajouter options quand possible !
            $journeyId = $journeyService->createJourneyDrive(
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
