<?php

namespace App\Controllers\Journey;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\JourneyDriveModel;
use App\Services\JourneyService;
use App\Validators\JourneyDrive\CreateJourneyDriveValidator;
use App\Validators\JourneyDrive\EditJourneyDriveValidator;
use App\Validators\JourneyDrive\SearchJourneyDriveValidator;
use CodeIgniter\HTTP\RedirectResponse;

class DriveController extends BaseController
{
    private JourneyDriveModel $journeyDriveModel;
    private JourneyService $journeyService;

    public function __construct()
    {
        $this->journeyDriveModel = model(JourneyDriveModel::class);
        $this->journeyService = service('journeyService');
    }

    /**
     * Manages journey search page
     */
    public function search(): string|RedirectResponse
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
            $validator = new SearchJourneyDriveValidator;

            if (! $validator->validate($getData)) {
                log_message('debug', 'Validation failed. Errors: ' . json_encode($validator->getErrors()));
                return redirect()->back()
                    ->with('errors', $validator->getErrors())
                    ->withInput();
            }

            // Logic
            try {
                // === Ajouter options quand possible !
                $getData['journeys'] = $this->journeyService->searchJourneyDrive($getData);
            } catch (\Throwable $e) {
                // system error
                log_message('error', $e->getMessage());

                return redirect()->back()
                    ->with('error', 'Une erreur s\'est produite')
                    ->withInput();
            }
        }


        return view('itinerary/search/SearchView', $getData);
    }

    /**
     * Displays the page for a specific trip
     * @param ?string $slug défaut : null | itinerary id
     * @return string|RedirectResponse
     */
    public function show(?string $slug = null): string|RedirectResponse
    {
        if ($slug === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        helper('form');
        helper('french');

        $connectedUser = session()->user_id;
        $userModel = model('UserModel');
        $carModel = model('CarModel');
        $bookingModel = model('BookingModel');

        $data['journey'] = $this->journeyDriveModel->getAllJourneyInfos($slug); //Retrieving the information of the journey

        //Checking if the journey exist. If there are no driver, do not display the page.
        if (!$data['journey'] || !$data['journey']['driver']) {
            throw new PageNotFoundException('Impossible de trouver l\'itinéraire : ' . $slug);
        }

        $seatPicked = (int) model('BookingModel')
            ->selectSum('seat_taken')
            ->where('id_journey_drive', $slug)
            ->where('deletion_date IS NULL')
            ->get()->getRow()->seat_taken;

        $data['journey']['available_seats'] = $data['journey']['number_of_place'] - $seatPicked;

        //Reformating the dates
        $data['journey']['departure'] = format_date_fr($data['journey']['departure']);
        $data['journey']['estimated_arrival'] = format_date_fr($data['journey']['estimated_arrival']);

        $data['journey']['waypoints'] = [];

        //Checking there are stages on the journey
        if ($data['journey']['stages']) {
            //Adding each city to the waypoints
            foreach ($data['journey']['stages'] as $stage) {
                array_push($data['journey']['waypoints'], $stage['city_name']);
            }
        }

        array_push($data['journey']['waypoints'], $data['journey']['arrival_city']); //Adding the final city to the way point

        $data['driver_name'] = $userModel->getUserName($data['journey']['driver']);; // Retrieving the driver name
        $data['car'] = $carModel->find($data['journey']['id_car']); //Retrieving the car information
        $data['journey']['is_driver'] = $data['journey']['driver'] == $connectedUser; //Checking if the user is the driver

        //Checking if the user already booked the journey
        $data['journey']['has_booked'] = $bookingModel->where('id_user', $connectedUser)
            ->where('id_journey_drive', $slug)
            ->first();

        $data['geojson'] = model('TrackModel')->find($data['journey']['id_track'])['geojson'] ?? null;
        return view('/itinerary/show/DriverJourneyView', $data);
    }

    /**
     * Saves an itinerary
     */
    public function save(): string|RedirectResponse
    {
        helper('form');

        /* Inputs :
         * start = ['address, 'label', 'city', 'postcode', 'lat', 'lon']
         * end = [...]
         * stops = [0 = [...], 1 = [...],]
         * id_car, number_of_place
         * departure['date', 'time'], estimated_arrival['date', 'time']
         * 
         * TODO :
         * - Check geocoding validity of address inputs
         * - Options ?
         */

        $data = $this->request->getPost('drive');

        // Validation
        $validator = new CreateJourneyDriveValidator;

        if (! $validator->validate($data)) {
            log_message('debug', 'Validation failed. Errors: ' . json_encode($validator->getErrors()));
            return redirect()->back()
                ->with('drive_errors', $validator->getErrors())
                ->with('failed_form', 'drive')
                ->withInput();
        }

        log_message('debug', 'Validation passed. Creating journey...');

        // Logic
        try {
            $days = $data['recurrence'] ?? [];

            if (!empty($days)) {
                $this->journeyService->createRecurringJourneyDrive($data, session()->get('user_id'), $days);
            } else {
                $this->journeyService->createJourneyDrive($data, session()->get('user_id'));
            }

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
     * @param int $id The journey's id
     * @return string|RedirectResponse
     */
    public function update(?int $id = null): string|RedirectResponse
    {
        /*
         * Inputs :
         * start-location,end-location, stages, departure datetime, estimated arrival datetime, id-car, number of seats
         */
        if ($id === null) {
            log_message('debug', 'Journey ID not found');
            throw PageNotFoundException::forPageNotFound();
        }

        $data = $this->request->getPost('drive');


        // Validation
        $validator = new EditJourneyDriveValidator;

        if (! $validator->validate($data)) {
            log_message('debug', 'Validation failed. Errors: ' . json_encode($validator->getErrors()));
            return redirect()->back()
                ->with('errors', $validator->getErrors())
                ->with('failed_form', 'drive')
                ->withInput();
        }

        log_message('debug', 'Validation passed. Editing journey...');

        try {
            // Acquiring the original journey's data
            $originalJourney = $this->journeyDriveModel->getAllJourneyInfos($id);

            if ($originalJourney === null) {
                log_message('debug', 'Existing journey not found');
                throw new \DomainException('Le trajet n\'existe pas');
            }

            $this->canManageJourney($originalJourney['driver']); // authorization check

            // Logic
            // === Ajouter options quand possible !
            $this->journeyService->updateJourneyDrive(
                $originalJourney,
                $data,
                session()->get('user_id')
            );

            log_message('debug', 'Journey modified successfully.');
            return redirect()->to('drive/show/' . $id)
                ->with('status', 'Itinéraire modifié avec succès');
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
     * Deletes an existing itinerary
     * @param int $id The journey's id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        try {
            $journey = $this->journeyDriveModel->find($id);

            if (!$journey) {
                throw new \DomainException('Ce trajet n\'existe pas');
            }

            $ownerId = $journey['driver'];

            $this->canManageJourney($ownerId); // authorization check

            log_message('debug', 'Deleting journey...');

            $this->journeyService->deleteJourneyDrive($id);

            log_message('debug', 'Journey deleted successfully.');

            return redirect()->to('profil')
                ->with('status', 'Trajet supprimé avec succès');
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
     * Throws new DomainException if user is not authorized to manage this journey
     * @param int $ownerId
     * @return void
     */
    private function canManageJourney(int $ownerId): void
    {
        if (!session()->user_id === $ownerId) {
            throw new \DomainException('Vous n\'avez pas la permission nécessaire pour modifier ce trajet.');
        }
    }
}
