<?php

namespace App\Controllers\Journey;

use App\Controllers\BaseController;
use App\Models\JourneyRequestModel;
use App\Services\JourneyService;
use App\Validators\JourneyRequest\CreateJourneyRequestValidator;
use App\Validators\JourneyRequest\SearchJourneyRequestValidator;
use App\Validators\JourneyRequest\UpdateJourneyRequestValidator;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class RequestController extends BaseController
{
    private JourneyRequestModel $journeyRequestModel;
    private JourneyService $journeyService;

    public function __construct()
    {
        $this->journeyRequestModel = model(JourneyRequestModel::class);
        $this->journeyService = service('journeyService');
    }

    /**
     * Displays the search page listing itineraries
     */
    public function search()
    {
        helper('form');

        /* Inputs :
        * start = ['label', 'city', 'postcode', 'lat', 'lon']
        * end = [...]
        * date
        * free-seats (default 1)
        * (optional) filters
        */

        $getData = $this->request->getGet();

        if (isset($getData['start'])) {
            // Validation
            $validator = new SearchJourneyRequestValidator;

            if (! $validator->validate($getData)) {
                log_message('debug', 'Validation failed. Errors: ' . json_encode($validator->getErrors()));
                return redirect()->back()
                    ->with('errors', $validator->getErrors())
                    ->withInput();
            }

            // Logic
            $journeyService = $this->journeyService;
            try {
                // === Ajouter options quand possible !
                $getData['journeys'] = $journeyService->searchJourneyDrive($getData);
            } catch (\Throwable $e) {
                // system error
                log_message('error', $e->getMessage());

                return redirect()->back()
                    ->with('error', 'Une erreur s\'est produite')
                    ->withInput();
            }
        }


        return view('itinerary/search/SearchRequestView', $getData);
    }

    /**
     * Displays the page for a specific trip
     * @param int $id Journey ID
     * @return string|RedirectResponse
     */
    public function show(int $id): string|RedirectResponse
    {
        helper('form');

        $locationModel = model('LocationModel');
        $userModel     = model('UserModel');

        $request = $this->journeyRequestModel->find($id);

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
            'ownRequest' => $ownRequest,
        ]);
    }


    /**
     * Displays the creation page for a new itinerary
     * @return string|RedirectResponse
     */
    public function create(): string|RedirectResponse
    {
        helper('form');
        return view('itinerary/create/CreateView');
    }

    /**
     *  Display the list of all journey
     * 
     * @return string|RedirectResponse
     */
    public function index(): string|RedirectResponse
    {
        $locationModel = model('LocationModel');
        $allRequest = $this->journeyRequestModel->findAll();

        foreach ($allRequest as &$request) {
            $request['start_address'] = $locationModel->getFormattedAddress($request['start']);
            $request['end_address'] = $locationModel->getFormattedAddress($request['end']);
        }

        return view('itinerary/show/RequestListView', ['requests' => $allRequest]);
    }

    /**
     * Saves an itinerary
     * @return string|RedirectResponse
     */
    public function save(): string|RedirectResponse
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
        log_message('debug', json_encode($data));

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
            // === Ajouter options quand possible !
            $journeyId = $this->journeyService->createJourneyRequest(
                $data,
                session()->get('user_id')
            );

            log_message('debug', 'Journey created successfully. ID: ' . $journeyId);
            return redirect()->to('/')
                ->with('success', 'Itinéraire créé avec succès');
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
     * @param int $id
     * @return string|RedirectResponse
     */
    public function edit(int $id): string|RedirectResponse
    {
        helper('form');

        $request = $this->journeyRequestModel->find($id);

        if (! $request || $request['id_user'] != session('user_id')) {
            return redirect()->to('request/list')
                ->with('error', 'Demande introuvable');
        }

        return view('itinerary/edit/EditRequestView', ['request' => $request]);
    }

    /**
     * Updates an existing itinerary
     * @param int $id
     * @return string|RedirectResponse
     */
    public function update(?int $id = null): string|RedirectResponse
    {
        if ($id === null) {
            log_message('debug', 'Journey ID not found');
            throw PageNotFoundException::forPageNotFound();
        }

        $data = $this->request->getPost('request');

        // Validation
        $validator = new UpdateJourneyRequestValidator;

        if (! $validator->validate($data)) {
            log_message('debug', 'Validation failed. Errors: ' . json_encode($validator->getErrors()));
            return redirect()->back()
                ->with('errors', $validator->getErrors())
                ->with('failed_form', 'request')
                ->withInput();
        }

        log_message('debug', 'Validation passed. Updating journey...');

        try {
            $request = $this->journeyRequestModel->find($id);

            if (!$request) {
                throw new \DomainException('Ce trajet n\'existe pas');
            }

            $this->canManageJourney($request('id_user'));

            $this->journeyService->updateJourneyRequest($id, $data, session()->user_id);

            log_message('debug', 'Journey updated successfully.');

            return redirect()->to('request/list')
                ->with('success', 'Votre demande à bien été mise à jour');
        } catch (\DomainException $e) {
            // domain error
            log_message('debug', 'Domain error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        } catch (\Throwable $e) {
            // system error
            log_message('error', 'Error in update(): ' . $e->getMessage());
            log_message('error', 'Stack: ' . $e->getTraceAsString());
            return redirect()->back()
                ->with('error', 'Une erreur s\'est produite')
                ->withInput();
        }
    }

    /**
     * Deletes an existing itinerary
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        try {
            $request = $this->journeyRequestModel->find($id);

            if (!$request) {
                throw new \DomainException('Ce trajet n\'existe pas');
            }

            $ownerId = $request['user_id'];

            $this->canManageJourney($ownerId);

            $this->journeyService->deleteJourneyRequest($id);

            return redirect()->back()
                ->with('success', 'Suppression réussite');
        } catch (\DomainException $e) {
            log_message('debug', 'Domain error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            log_message('error', 'Error in delete(): ' . $e->getMessage());
            log_message('error', 'Stack: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Une erreur s\'est produite');
        }
    }

    /**
     * Checks the user's authorization to manage journey
     * @param int $ownerId
     */
    private function canManageJourney(int $ownerId): void
    {
        $isOwner = session()->user_id === $ownerId;
        $isAdmin = in_array(session()->user_role, [2, 3], true);

        if (!$isOwner && !$isAdmin) {
            throw new \DomainException('Vous n\'avez pas la permission nécessaire pour modifier ce trajet.');
        }
    }
}
