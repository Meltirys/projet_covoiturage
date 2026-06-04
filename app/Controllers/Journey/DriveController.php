<?php

namespace App\Controllers\Journey;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\JourneyDriveModel;
use App\Models\CarModel;
use App\Validators\CreateJourneyDriveValidator;
use App\Validators\SearchJourneyDriveValidator;
use Exception;
use PDOException;

class DriveController extends BaseController
{

    /**
     * Manages journey search page
     */
    public function search()
    {
        /* Inputs :
        * start = ['label', 'city', 'postcode', 'lat', 'lon']
        * end = [...]
        * date
        * free-seats (default 1)
        * (optional) filters
        */

        helper('form');

        $getData = $this->request->getGet();

        if (isset($getData['start'])) {
            // Validation
            $validator = new SearchJourneyDriveValidator;

            // if (! $validator->validate($getData)) {
            //     $getData['errors'] = $validator->getErrors();

            //     return view('itinerary/search/SearchView', $getData);
            // }

            // Logic
            try {
                $journeyService = service('journeyService');

                // === Ajouter options quand possible !
                $data['journeys'] = $journeyService->searchJourneyDrive($getData);
            } catch (\Throwable $e) {
                // system error
                log_message('error', $e->getMessage());

                $data['error'] = 'Une erreur s\'est produite';

                return view('itinerary/search/SearchView', $data);
            }
        }


        return view('itinerary/search/SearchView');
    }

    /**
     * Displays the page for a specific trip
     * @param ?string $slug défaut : null | itinerary id
     */
    public function show(?string $slug = null)
    {
        helper('form');
        helper('french_helper');

        $connectedUser = session()->user_id;
        $journeyModel = model(JourneyDriveModel::class);
        $userModel = model('UserModel');
        $carModel = model('CarModel');
        $bookingModel = model('BookingModel');

        $data['journey'] = $journeyModel->getAllJourneyInfos($slug); //Retrieving the information of the journey

        //Checking if the journey exist. If there are no driver, do not display the page.
        if (!$data['journey'] || !$data['journey']['driver']) {
            throw new PageNotFoundException('Cannot find the news item: ' . $slug);
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

        return view('/itinerary/show/DriverJourneyView', $data);
    }

    /**
     * Saves an itinerary
     */
    public function save()
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
     * @param int $id The journey's id
     */
    public function update(int $id)
    {
        /*
         * Inputs :
         * 
         */
    }

    /**
     * Deletes an existing itinerary
     * @param int $id The journey's id
     */
    public function delete(int $id)
    {
        $journeyService = service('journeyService');

        log_message('debug', 'Deleting journey...');
        try {

            $journeyService->deleteJourneyDrive($id);

            log_message('debug', 'Journey deleted successfully.');

            return redirect()->to('profil')
                ->with('status', 'Trajet supprimé avec succès');
        } catch (\Throwable $e) {
            log_message('error', 'Error in save(): ' . $e->getMessage());
            log_message('error', 'Stack: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Une erreur s\'est produite');
        }
    }
}
