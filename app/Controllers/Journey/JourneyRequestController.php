<?php

namespace App\Controllers\Journey;

use App\Controllers\BaseController;
use App\Models\JourneyRequestModel;
use App\Models\LocationModel;
use App\Models\UserModel;
use App\Services\JourneyService;
use App\Validators\JourneyRequest\CreateJourneyRequestValidator;
use App\Validators\JourneyRequest\SearchJourneyRequestValidator;
use App\Validators\JourneyRequest\UpdateJourneyRequestValidator;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use Config\School;

class JourneyRequestController extends BaseController
{
    private JourneyRequestModel $journeyRequestModel;
    private JourneyService $journeyService;

    public function __construct()
    {
        $this->journeyRequestModel = model(JourneyRequestModel::class);
        $this->journeyService = service('journeyService');
    }

    /**
     * Displays the page for a specific trip
     * @param int $id Journey ID
     */
    public function show(int $id)
    {
        helper('form');

        $locationModel = model(LocationModel::class);
        $userModel     = model(UserModel::class);

        $request = $this->journeyRequestModel->find($id);

        if (! $request) {
            return redirect()->to('requetes')
                ->with('error', 'Demande introuvable');
        }

        $request['start_address'] = $locationModel->getFormattedAddress($request['start']);
        $request['end_address']   = $locationModel->getFormattedAddress($request['end']);
        $author = $userModel->find($request['id_creator']);

        $ownRequest = $request['id_creator'] == session('user_id');

        $requestMemberModel = model('RequestMemberModel');
        $hasJoined = $requestMemberModel
            ->where('id_journey_request', $id)
            ->where('id_user', session('user_id'))
            ->where('deletion_date', null)
            ->first() !== null;

        return view('itinerary/show/RequestShowView', [
            'request' => $request,
            'author' => $author,
            'ownRequest' => $ownRequest,
            'hasJoined' => $hasJoined,
        ]);
    }

    /**
     * Called when someone wants to join an existing request
     * @param int $id The id of the request to join
     */
    public function join(int $id)
    {
        $request = $this->journeyRequestModel->find($id);

        if (!$request) {
            return redirect()->back()->with('error', 'Demande introuvable');
        }

        $requestMemberModel = model('RequestMemberModel');

        $alreadyJoined = $requestMemberModel
            ->where('id_journey_request', $id)
            ->where('id_user', session('user_id'))
            ->where('deletion_date', null)
            ->first();

        if ($alreadyJoined) {
            return redirect()->back()->with('error', 'Vous avez déjà rejoint cette demande');
        }

        $requestMemberModel->insert([
            'seat_taken'         => 1,
            'request_date'       => date('Y-m-d'),
            'id_journey_request' => $id,
            'id_user'            => session('user_id'),
        ]);

        return redirect()->to('request/show/' . $id)
            ->with('success', 'Vous avez rejoint cette demande');
    }


    /**
     * Displays the creation page for a new itineraryse
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
        helper('french');
        $allRequest = $this->journeyRequestModel->getJourneyInfosByDates();

        foreach ($allRequest as &$request) {
            $request['start_address'] = $request['departure_address'] . ', ' . $request['departure_postcode'] . ' ' . $request['departure_city'];
            $request['end_address'] = $request['arrival_address'] . ', ' . $request['arrival_postcode'] . ' ' . $request['arrival_city'];
            if (!empty($request['request_date'])) {
                $request['request_date'] = format_date_fr($request['request_date']);
            }
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

        //Checking if the datas should be auto-completed with the school informations
        if (isset($data['start-formation']) && isset($data['end-formation'])) {
            return redirect()->back()
                ->with('error', 'Impossible de choisir l\'adresse de la formation comme départ et comme arrivé')
                ->with('failed_form', 'drive')
                ->withInput();
        } else if (isset($data['start-formation'])) { //Adding the school info to the start
            $school = config(School::class);
            $data['start']['label'] = $school->address;
            $data['start']['city'] = $school->city;
            $data['start']['postcode'] = $school->postcode;
            $data['start']['lat'] = $school->latitude;
            $data['start']['lon'] = $school->longitude;
        } else if (isset($data['end-formation'])) { //Adding the school info to the end
            $school = config(School::class);
            $data['end']['label'] = $school->address;
            $data['end']['city'] = $school->city;
            $data['end']['postcode'] = $school->postcode;
            $data['end']['lat'] = $school->latitude;
            $data['end']['lon'] = $school->longitude;
        }

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
                ->with('tab', 'request')
                ->with('error', $e->getMessage())
                ->withInput();
        } catch (\Throwable $e) {
            // system error
            log_message('error', 'Error in save(): ' . $e->getMessage());
            log_message('error', 'Stack: ' . $e->getTraceAsString());
            return redirect()->back()
                ->with('tab', 'request')
                ->with('error', 'Une erreur s\'est produite, veuillez réessayer plus tard.')
                ->withInput();
        }
    }

    /**
     * Shows edition page for an itinerary
     * @param int $id
     */
    public function edit(int $id)
    {
        helper('form');

        $request = $this->journeyRequestModel->find($id);

        if (! $request || $request['id_creator'] != session('user_id')) {
            return redirect()->to('requetes')
                ->with('error', 'Demande introuvable');
        }

        return view('itinerary/edit/EditRequestView', ['request' => $request]);
    }

    /**
     * Updates an existing itinerary
     * @param int $id
     */
    public function update(?int $id = null)
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
            $original = $this->journeyRequestModel->find($id);

            if (!$original) {
                throw new \DomainException('Le trajet n\'existe pas');
            }

            if ((int) $original['id_creator'] !== (int) session('user_id')) {
                throw new \DomainException('Vous n\'avez pas la permission de modifier cette demande');
            }

            $this->journeyService->updateJourneyRequest($original, $data, session('user_id'));

            return redirect()->to('request/show/' . $id)
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
                ->with('error', 'Une erreur s\'est produite, veuillez réessayer plus tard.')
                ->withInput();
        }
    }

    /**
     * Deletes an existing itinerary
     * @param int $id
     */
    public function delete(int $id)
    {
        try {
            $request = $this->journeyRequestModel->find($id);

            if (!$request) {
                throw new \DomainException('Ce trajet n\'existe pas');
            }

            if ((int) $request['id_creator'] !== (int) session('user_id')) {
                throw new \DomainException('Vous n\'avez pas la permission de supprimer cette demande');
            }

            $this->journeyService->deleteJourneyRequest($id);

            return redirect()->to('requetes')
                ->with('success', 'Suppression réussite');
        } catch (\DomainException $e) {
            log_message('debug', 'Domain error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            log_message('error', 'Error in delete(): ' . $e->getMessage());
            log_message('error', 'Stack: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Une erreur s\'est produite, veuillez réessayer plus tard.');
        }
    }

}
