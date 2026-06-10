<?php

namespace App\Controllers\Journey;

use App\Controllers\BaseController;
use App\Models\JourneyRequestModel;
use App\Services\JourneyService;
use App\Validators\JourneyRequest\CreateJourneyRequestValidator;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use Throwable;

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
        return view('itinerary/search/SearchView');
    }

    /**
     * Displays the page for a specific trip
     * 
     * @param int $id Journey ID
     */
    public function show(int $id): string|RedirectResponse
    {
        helper('form');

        $locationModel = model('LocationModel');
        $userModel     = model('UserModel');

        $request = $$this->journeyRequestModel->find($id);

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
     * 
     * parameter : itinerary id
     */
    public function edit($id)
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
     * 
     * parameter : itinerary id
     */
    public function update(int $id)
    {
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

        $request = $this->journeyRequestModel->find($id);

        if (!$request) {
            throw new \DomainException('Ce trajet n\'existe pas');
        }

        $this->canManageJourney($request('id_user'));

        $rangeStart = $data['range-start'] ?? '';
        $rangeEnd = $data['range-end'] ?? '';

        if (empty($rangeStart) || empty($rangeEnd) || $rangeEnd <= $rangeStart) {
            return redirect()->back()
                ->with('error', 'Les heures sont invalides')
                ->withInput();
        }

        $rangeOfTime = $rangeStart . ' - ' . $rangeEnd;
        try {
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

    /**
     * Checks the user's authorization to manage journey
     * @param int $ownerId
     */
    private function canManageJourney(int $ownerId): void
    {
        $isOwner = session()->user_id === $ownerId;
        $isAdmin = in_array(session()->user_role, [2, 3], true);

        if (!$isOwner && !$isAdmin) {
            log_message('debug', 'Original journey doesn\'t belong to current user');
            throw PageNotFoundException::forPageNotFound();
        }
    }
}
