<?php

namespace App\Controllers\Journey;

use App\Controllers\BaseController;
use App\Models\JourneyRequestModel;
use App\Validators\CreateJourneyRequestValidator;
use DateTime;

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
    public function show($id)
    {
        helper('form');
        $requestModel  = model(JourneyRequestModel::class);
        $locationModel = model('LocationModel');
        $userModel     = model('UserModel');

        $request = $requestModel->find($id);

        if (! $request) {
            return redirect()->to('request/list')
                ->with('error', 'Demande introuvable');
        }

        $request['start_address'] = $locationModel->getFormattedAddress($request['start']);
        $request['end_address']   = $locationModel->getFormattedAddress($request['end']);
        $author = $userModel->find($request['id_user']);

        $ownRequest = $request['id_user'] == session('user_id');

        return view('itinerary/show/RequestShowView', [
            'request' => $request, 
            'author' => $author,
            'ownRequest' => $ownRequest,]);
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
     *  Display the list of all journey
     */
    public function index()
    {
        $requestModel = model(JourneyRequestModel::class);
        $locationModel = model('LocationModel');
        $allRequest = $requestModel->findAll();

        foreach ($allRequest as &$request) {
            $request['start_address'] = $locationModel->getFormattedAddress($request['start']);
            $request['end_address'] = $locationModel->getFormattedAddress($request['end']);
        }
        return view('itinerary/show/RequestListView', ['requests' => $allRequest]);
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
            return redirect()->back()
                ->with('error', 'Une erreur s\'est produite')
                ->withInput();
        }
    }

    /**
     * Edit an existing itinerary
     * 
     * parameter : itinerary id
     */
    public function edit($id)
    {
        helper('form');
        $requestModel = model(JourneyRequestModel::class);
        $request      = $requestModel->find($id);

        if (! $request || $request['id_user'] != session('user_id')) {
            return redirect()->to('request/list')
                ->with('error', 'Demande introuvable');
        }

        return view('itinerary/edit/EditRequestView', ['request' => $request]);
    }

    /**
     * Updates an existing itinerary
     * 
     * parameter : itinerary id
     */
    public function update($id)
    {
        $requestModel = model(JourneyRequestModel::class);
        $request = $requestModel->find($id);

        if (!$request || $request['id_user'] != session('user_id')) {
            return redirect()->to('request/list')
                ->with('error', 'Demande introuvable');
        }
        $data = $this->request->getPost('request');
        $rangeStart = $data['range-start'] ?? '';
        $rangeEnd = $data['range-end'] ?? '';

        if (empty($rangeStart) || empty($rangeEnd) || $rangeEnd <= $rangeStart) {
            return redirect()->back()
                ->with('error', 'Les heures sont invalides')
                ->withInput();
        }

        $rangeOfTime = $rangeStart . ' - ' . $rangeEnd;
        $requestModel->update($id, [
            'description' => $data['description'],
            'range_of_time' => $rangeOfTime,
        ]);
        return redirect()->to('request/list')
            ->with('success', 'Votre demande à bien été mise à jour');
    }

    /**
     * Deletes an existing itinerary
     * 
     * parameter : itinerary id
     */
    public function delete($id)
    {
        $requestModel = model(JourneyRequestModel::class);
        $request = $requestModel->find($id);

        if (!$request || $request['id_user'] != session('user_id')) {
            return redirect()->to('request/list')
                ->with('error', 'Demande introuvable');
        }

        $requestModel->delete($id);
        return redirect()->to('request/list')
            ->with('success', 'Suppression réussite');
    }
    
}
