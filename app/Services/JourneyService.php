<?php

namespace App\Services;

use App\Models\BookingModel;
use App\Models\CarModel;
use App\Models\JourneyDriveModel;
use App\Models\JourneyRequestModel;
use App\Models\StagesModel;
use CodeIgniter\Database\BaseConnection;
use DateTime;

class JourneyService
{
    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    /**
     * Attempts to create every element of the driver's journey
     * @param array $input The user's inputs
     * @param int $userId The user's ID
     * @return int The JourneyDrive ID
     */
    public function createJourneyDrive(array $input, int $userId): int
    {
        $carModel       = model(CarModel::class);
        $locationService = service('locationService');
        $journeyModel   = model(JourneyDriveModel::class);
        $stageModel     = model(StagesModel::class);

        $input['start-datetime'] = (new DateTime(
            $input['start-date'] . ' ' . $input['start-time']
        ))->format('Y-m-d H:i:s');

        $input['end-datetime'] = (new DateTime(
            $input['end-date'] . ' ' . $input['end-time']
        ))->format('Y-m-d H:i:s');

        $this->db->transBegin();

        //Creating the stops
        $stops = $input['stops'] ?? [];

        //Removing all the empty stops and making a new array with new indexes
        $stops = array_values(array_filter($stops, function ($item) {
            return !empty(array_filter($item));
        }));

        try {

            // 1. Verify car ownership and seat amount
            $car = $carModel
                ->where('id_car', $input['car'])
                ->where('id_user', $userId)
                ->first();

            if (! $car) {
                throw new \DomainException('Voiture invalide');
            }

            if ($input['seats'] > $car['number_of_seat']) {
                throw new \DomainException('Pas assez de places dans cette voiture');
            }

            // 2. Cities + Locations
            $startLocationId = $locationService->getOrCreate(
                $input['start']['label'],
                $input['start']['city'],
                $input['start']['postcode'],
                $input['start']['lat'] ?? null,
                $input['start']['lon'] ?? null
            );

            $endLocationId = $locationService->getOrCreate(
                $input['end']['label'],
                $input['end']['city'],
                $input['end']['postcode'],
                $input['end']['lat'] ?? null,
                $input['end']['lon'] ?? null
            );

            // 3. Generating the track
            $trackService = service('TrackService');
            $start = [$input['start']['lon'], $input['start']['lat']];
            $end = [$input['end']['lon'], $input['end']['lat']];
            $idTrack = null;


            //Checking if there are stops in the journey
            if ($stops) {
                $trackStop = array_map(function ($row) {
                    return [
                        $row['lon'],
                        $row['lat']
                    ];
                }, $stops); //Rebuilbing each stops into a new array and saving only the lat on lon values

                $idTrack = $trackService->saveTrack($start, $end, $trackStop); //Creating the track in the database
            } else {
                $idTrack = $trackService->saveTrack($start, $end); //Creating the track in the database
            }

            if (!$idTrack) {
                throw new \RuntimeException('Impossible de créer le tracé du trajet');
            }
            // 4. Journey
            $userId = session()->get('user_id');

            $journeyData = [
                'number_of_place'   => (int) $input['seats'],
                'departure'         => $input['start-datetime'],
                'estimated_arrival' => $input['end-datetime'],
                'id_car'            => $input['car'],
                'start'             => $startLocationId,
                'end'               => $endLocationId,
                'driver'            => $userId,
                'id_track'          => $idTrack
            ];

            $journeyId = $journeyModel->insert($journeyData, true);

            if (! $journeyId) {
                throw new \RuntimeException('Impossible de créer le trajet');
            }

            // 5. Stages (optional)
            if ($stops) {
                $order = 1;

                foreach ($stops as $stop) {

                    $locationId = $locationService->getOrCreate(
                        $stop['label'],
                        $stop['city'],
                        $stop['postcode'],
                        $stop['lat'],
                        $stop['lon']
                    );

                    $ok = $stageModel->insert([
                        'id_journey_drive' => $journeyId,
                        'id_location'      => $locationId,
                        'order'            => $order++,
                    ]);

                    if ($ok === false) {
                        throw new \RuntimeException('Erreur lors de la création des étapes');
                    }
                }
            }



            // 6. Transaction safety
            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('Transaction échouée');
            }

            $this->db->transCommit();

            return $journeyId;
        } catch (\Throwable $e) {
            $this->db->transRollback();
            throw $e;
        }
    }

    /**
     * 
     */
    public function updateJourneyDrive() {}

    /**
     * 
     */
    public function deleteJourneyDrive() {}

    /**
     * 
     * @param array $input The user's inputs
     * @return array $journeys The matching journeys
     */
    public function searchJourneyDrive(array $input): array
    {
        $locationService = service('locationService');
        $journeyDriveModel = model(JourneyDriveModel::class);
        $stageModel = model(StagesModel::class);
        $bookingsModel = model(BookingModel::class);

        // searchJourneyDrive()
        // ├── resolve departure location
        // ├── resolve arrival location
        // ├── retrieve candidate journeys
        // ├── filter by date
        // ├── filter by seats
        // ├── sort
        // └── return results

        // 1. cities + location
        $departureLocation = $locationService->findLocationByAddress($input['start.address'], $input['start.city'], $input['start.postcode']);
        $arrivalLocation = $locationService->findLocationByAddress($input['end.address'], $input['end.city'], $input['end.postcode']);

        if (empty($departureLocation) || empty($arrivalLocation)) {
            return [];
        }
        // 2. date 
        // Intervale de temps pour l'horaire/date de début des trajets qui seront affichés
        // convert date to datetime range
        $startDay = $input['date'] . '00:00:00'; // début
        $endDay = date('Y-m-d H:i:s', strtotime($startDay . ' +1 day')); // fin

        // 3. Journeys
        $journeys = $journeyDriveModel
            ->where('start', $departureLocation['id_location'])
            ->where('end', $arrivalLocation['id_location'])
            ->where('departure >=', $startDay)
            ->where('departure <', $endDay)
            ->findAll();

        // 4. Filter seat availability
        $journeys = $this->filterAvailableSeats(
            $journeys,
            $input['free-seats']
        );

        return $journeys;
    }

    /**
     * Attempts to create every element of the requester's journey
     * @param array $input The user's inputs
     * @param int $userId The user's ID
     * @return int The JourneyRequest ID
     */
    public function createJourneyRequest(array $input, int $userId): int
    {
        $carModel       = model(CarModel::class);
        $locationService = service('locationService');
        $journeyModel   = model(JourneyRequestModel::class);
        $stageModel     = model(StagesModel::class);

        $this->db->transBegin();

        try {
            // 1. Cities + Locations
            $startLocationId = $locationService->getOrCreate(
                $input['start']['label'],
                $input['start']['city'],
                $input['start']['postcode'],
                $input['start']['lat'] ?? null,
                $input['start']['lon'] ?? null
            );

            $endLocationId = $locationService->getOrCreate(
                $input['end']['label'],
                $input['end']['city'],
                $input['end']['postcode'],
                $input['end']['lat'] ?? null,
                $input['end']['lon'] ?? null
            );

            // 2. Journey

            if ($startLocationId === $endLocationId) {
                throw new \DomainException('Le point de départ et d\'arrivée ne peuvent pas être identiques');
            }

            if ($input['range-start'] >= $input['range-end']) {
                throw new \DomainException('L\'heure de début de disponibilité doit être avant la fin');
            }

            $input['range-of-time'] = $input['range-start'] . ' - ' . $input['range-end'];

            $journeyData = [
                'description'   => $input['description'],
                'range_of_time' => $input['range-of-time'],
                'id_user'       => $userId,
                'start'         => $startLocationId,
                'end'           => $endLocationId,
            ];


            $journeyId = $journeyModel->insert($journeyData, true);

            if (! $journeyId) {
                throw new \RuntimeException('Impossible de créer le trajet');
            }

            // 3. Transaction safety
            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('Transaction échouée');
            }

            $this->db->transCommit();

            return $journeyId;
        } catch (\Throwable $e) {
            $this->db->transRollback();
            throw $e;
        }
    }

    /**
     * 
     */
    public function updateJourneyRequest() {}

    /**
     * 
     */
    public function deleteJourneyRequest() {}

    /**
     * 
     */
    public function searchJourneyRequest() {}

    /**
     * Function to filter through journeys which don't have enough seats available
     * @param array $journeys Journeys matching in location and date
     * @param string $input Amount of available seats requested
     * @return array $newJourneys The filtered journeys with enough free seats
     */
    public function filterAvailableSeats(array $journeys, string $input): array
    {
        $newJourneys = [];

        return $newJourneys;
    }
}
