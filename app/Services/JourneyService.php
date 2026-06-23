<?php

namespace App\Services;

use App\Models\BookingModel;
use App\Models\CarModel;
use App\Models\JourneyDriveModel;
use App\Models\JourneyRequestModel;
use App\Models\RequestMemberModel;
use App\Models\StagesModel;
use App\Models\TrackModel;
use CodeIgniter\Database\BaseConnection;

class JourneyService
{
    protected BaseConnection $db;

    private JourneyDriveModel $journeyDriveModel;
    private JourneyRequestModel $journeyRequestModel;

    private RequestMemberModel $requestMemberModel;

    private StagesModel $stagesModel;

    private LocationService $locationService;

    public function __construct()
    {
        helper('geo');

        $this->db = db_connect();
        $this->journeyDriveModel   = model(JourneyDriveModel::class);
        $this->journeyRequestModel = model(JourneyRequestModel::class);
        $this->requestMemberModel  = model(RequestMemberModel::class);
        $this->stagesModel         = model(StagesModel::class);
        $this->locationService     = service('locationService');
    }

    /**
     * Attempts to create every element of the journey drive
     * @param array $input The user's inputs
     * @param int $userId The user's ID
     * @return int The JourneyDrive ID
     */
    public function createJourneyDrive(array $input, int $userId, ?int $idTrack = null): int
    {
        $this->db->transBegin();

        // Removes all the empty stops and makes a new array with new indexes
        $input['stops'] = $this->sanitizeStops($input['stops'] ?? []);

        $departureTime = $this->getDeparture($input);

        try {
            // 1. Verify car ownership and seat amount
            $this->validateCar(
                (int)$input['car'],
                (int)$userId,
                (int)$input['seats']
            );

            // 2. Cities + Locations
            $locationIds = $this->createStartEndLocations($input);

            // Checking if there duplicate journey
            $existingJ = $this->journeyDriveModel
                ->where('driver', $userId)
                ->where('start', $locationIds['start'])
                ->where('end', $locationIds['end'])
                ->where('departure', $departureTime)
                ->where('deletion_date IS NULL')
                ->first();
            if ($existingJ) {
                throw new \DomainException('Vous avez déjà proposé un trajet identique');
            }

            // 3. Generating the track
            $idTrack = $idTrack ?? $this->buildTrack($input);
            if (!$idTrack) {
                throw new \RuntimeException('Impossible de créer le tracé du trajet');
            }

            // 4. Journey

            // Calculating the estimated_arrival
            $estimatedArrival = $this->estimateJourneyArrival($idTrack, $departureTime);

            // Formatting the data
            $journeyData = [
                'number_of_place'   => (int) $input['seats'],
                'departure'         => $departureTime,
                'estimated_arrival' => $estimatedArrival,
                'id_car'            => $input['car'],
                'start'             => $locationIds['start'],
                'end'               => $locationIds['end'],
                'driver'            => $userId,
                'id_track'          => $idTrack
            ];

            $journeyId = $this->journeyDriveModel->insert($journeyData, true);

            if (! $journeyId) {
                throw new \RuntimeException('Impossible de créer le trajet');
            }

            // 5. Stages (optional)
            if ($input['stops']) {
                $this->saveStages($journeyId, $input['stops']);
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

    public function createRecurringJourneyDrive(array $input, int $userId, array $days): array
    {
        $createIds = [];
        $referenceDate = new \DateTime($input['start-date']);
        $refDayNum = (int)$referenceDate->format('N'); // 1=lun, 7=dim

        $dayNumbers = [
            'monday'    => 1,
            'tuesday'   => 2,
            'wednesday' => 3,
            'thursday'  => 4,
            'friday'    => 5,
            'saturday'  => 6,
            'sunday'    => 7,
        ];

        $idTrack = $this->buildTrack($input);
        foreach ($days as $day) {
            $targetDayNum = $dayNumbers[$day] ?? null;
            if ($targetDayNum === null) continue;

            $diff = ($targetDayNum - $refDayNum + 7) % 7;
            $date = clone $referenceDate;
            if ($diff > 0) {
                $date->modify('+' . $diff . ' days');
            }

            $input['start-date'] = $date->format('Y-m-d');
            $createIds[] = $this->createJourneyDrive($input, $userId, $idTrack);
        }

        return $createIds;
    }
    /**
     * Updates an existing itinerary
     * @param array $original The original journey data
     * @param array $input The updated journey data
     * @param int $userId
     */
    public function updateJourneyDrive(array $original, array $input, int $userId): void
    {
        $stageModel = $this->stagesModel;

        $this->db->transBegin();

        // Removes all the empty stops and makes a new array with new indexes
        $input['stops'] = $this->sanitizeStops($input['stops'] ?? []);

        try {
            // 1. Verify car ownership and seat amount
            $this->validateCar(
                (int)$input['car'],
                (int)$userId,
                (int)$input['seats']
            );

            // 2. Cities + Locations
            $locationIds = $this->createStartEndLocations($input);

            // 3. Track
            $routeChanged = $this->detectRouteChange($original, $input);

            $idTrack = $original['id_track'];

            if ($routeChanged) {
                $isShared = $this->journeyDriveModel->where('id_track', $idTrack)->countAllResults() > 1;
                $idTrack = $this->buildTrack($input, $isShared ? null : $idTrack);
            }

            // 4. Journey
            // Calculating the estimated_arrival
            $departureTime = $this->getDeparture($input);
            $estimatedArrival = $this->estimateJourneyArrival($idTrack, $departureTime);

            // Formatting the data
            $journeyData = [
                'number_of_place'   => (int) $input['seats'],
                'departure'         => $departureTime,
                'estimated_arrival' => $estimatedArrival,
                'id_car'            => $input['car'],
                'start'             => $locationIds['start'],
                'end'               => $locationIds['end'],
                'driver'            => $userId,
                'id_track'          => $idTrack
            ];

            $journeyId = $original['id_journey_drive'];

            $updateStatus = $this->journeyDriveModel->update($journeyId, $journeyData);

            if ($updateStatus === false) {
                throw new \RuntimeException('Impossible de modifier le trajet');
            }

            // 5. Stages (optional)
            if ($routeChanged) {
                // Deletes old itinerary's stages
                $stageModel->where('id_journey_drive', $journeyId)->delete();

                if (!empty($input['stops'])) {
                    // Saves new stages if existing
                    $this->saveStages($journeyId, $input['stops']);
                }
            }

            // 6. Transaction safety
            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('Transaction échouée');
            }

            $this->db->transCommit();
        } catch (\Throwable $e) {
            $this->db->transRollback();
            throw $e;
        }
    }

    /**
     * Deletes a journey drive
     * @param int $id The journey ID
     * @return void
     */
    public function deleteJourneyDrive(int $id): void
    {
        $bookingModel = model(BookingModel::class);
        $stageModel = $this->stagesModel;
        $trackModel = model(TrackModel::class);

        $this->db->transBegin();

        $journey = $this->journeyDriveModel->find($id);

        if (!$journey) {
            throw new \DomainException('Le trajet n\'existe pas');
        }

        $journeyId = $journey['id_journey_drive'];
        $trackId = $journey['id_track'];

        try {
            // Suppression des réservations
            $bookingModel->where('id_journey_drive', $journeyId)->delete();

            // Suppression des étapes
            $stageModel->where('id_journey_drive', $journeyId)->delete();

            // Suppression du trajet
            $this->journeyDriveModel->delete($journeyId);

            // Suppression du tracking (après le trajet pour respecter la contrainte FK)
            $trackModel->delete($trackId);


            // Transaction safety
            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('Transaction échouée');
            }

            $this->db->transCommit();
        } catch (\Throwable $e) {
            $this->db->transRollback();
            throw $e;
        }
    }


    /**
     * Gets a list of journeys matching the user's request
     * @param array $input The user's inputs
     * @return array $journeys The matching journeys
     */
    public function searchJourneyDrive(array $input): array
    {
        // searchJourneyDrive()
        // ├── resolve departure location
        // ├── resolve arrival location
        // ├── retrieve candidate journeys by date
        // ├── filter by geographical proximity
        // ├── filter by seats
        // └── return results

        // 1. Setting up the variables
        $startDate = !empty($input['date']) ? $input['date'] : date('Y-m-d');
        $endDay = date('Y-m-d H:i:s', strtotime($startDate . ' +1 day'));
        $requestedSeats = $input['free-seats'] ?? 1;
        $departurePoint = [$input['start']['lon'], $input['start']['lat']];
        $endPoint = $input['end']['lon'] && $input['end']['lat'] ?
            [$input['end']['lon'], $input['end']['lat']] :
            null; //Setting up the end point, if none is provided, sets it to null

        // 2. Retrieves all the journeys that are within the good date range
        $journeys = $this->journeyDriveModel->getJourneyInfosByDates($startDate, $endDay);

        if (empty($journeys)) return []; //Stop the execution if no results

        // 3. Filters the journeys with the available seats
        $journeys = $this->filterAvailableSeats($journeys, $requestedSeats);

        if (empty($journeys)) return []; //Stop the execution if no results


        // 4. Filtering the journeys to keep only the one that are on the journey entered by the user
        $journeys = $this->matchJourneys($journeys, $departurePoint, $endPoint);

        return $journeys;
    }


    /**
     * Returns a set number of available journey
     * @param string $type Whether it's for 'drive' or 'request' journeys
     * @param int $numberOfJourneys Optional : The amount of journeys to return. By default returns all the journeys available
     * @return array An array that contains all the values needed for the display
     */
    public function getNextAvailableJourneys(string $type, int $numberOfJourneys = -1): array
    {
        switch ($type) {
            case 'drive':
                $allJouneys = $this->journeyDriveModel->getJourneyInfosByDates(date('Y-m-d H:i:s'), null, $numberOfJourneys); // We retrieve the journey that start after the current day
                break;
            case 'request':
                $allJouneys = $this->journeyRequestModel->getJourneyInfosByDates(date('Y-m-d H:i:s'), null, $numberOfJourneys);
                break;
            default:
                return [];
        }

        return $this->filterAvailableSeats($allJouneys, 1);
    }



    /**
     * Attempts to create every element of the requester's journey
     * @param array $input The user's inputs
     * @param int $userId The user's ID
     * @return int The JourneyRequest ID
     */
    public function createJourneyRequest(array $input, int $userId): int
    {
        $this->db->transBegin();

        try {
            // 1. Cities + Locations
            $locationIds = $this->createStartEndLocations($input);

            // 2. Journey
            if ($input['range-start'] >= $input['range-end']) {
                throw new \DomainException('L\'heure de début de disponibilité doit être avant la fin');
            }

            $journeyRequestId = $this->journeyRequestModel->insert([
                'description'        => $input['description'],
                'earliest_departure' => $input['range-start'],
                'latest_departure'   => $input['range-end'],
                'start'              => $locationIds['start'],
                'end'                => $locationIds['end'],
                'id_creator'         => $userId
            ], true);

            if (! $journeyRequestId) {
                throw new \RuntimeException('Impossible de créer le trajet');
            }

            // 3. Request Member insertion
            $status = $this->requestMemberModel->insert([
                'seat_taken'         => 1,
                'request_date'       => $input['date'],
                'id_journey_request' => $journeyRequestId,
                'id_user'            => $userId
            ]);

            if (!$status) {
                throw new \RuntimeException('Impossible de créer la participation');
            }

            // 4. Transaction safety
            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('Transaction échouée');
            }

            $this->db->transCommit();

            return $journeyRequestId;
        } catch (\Throwable $e) {
            $this->db->transRollback();
            throw $e;
        }
    }

    /**
     * Updates a request
     */
    public function updateJourneyRequest(array $original, array $input, int $userId)
    {
        $journeyId = $original['id_journey_request'];

        if ($input['range-start'] >= $input['range-end']) {
            throw new \DomainException('L\'heure de début de disponibilité doit être avant la fin');
        }

        $updateStatus = $this->journeyRequestModel->update($journeyId, [
            'description'        => $input['description'],
            'earliest_departure' => $input['range-start'],
            'latest_departure'   => $input['range-end'],
        ]);

        if ($updateStatus === false) {
            throw new \RuntimeException('Impossible de modifier la demande');
        }
    }

    /**
     * Deletes a journey request
     * @param int $id The journey ID
     */
    public function deleteJourneyRequest(int $id): void
    {
        $this->db->transBegin();

        $journey = $this->journeyRequestModel->find($id);

        if (!$journey) {
            throw new \DomainException('Le trajet n\'existe pas');
        }

        $journeyId = $journey['id_journey_drive'];

        try {
            // Suppression du trajet
            $this->journeyRequestModel->delete($journeyId);

            // Transaction safety
            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('Transaction échouée');
            }

            $this->db->transCommit();
        } catch (\Throwable $e) {
            $this->db->transRollback();
            throw $e;
        }
    }

    /**
     * 
     */
    public function searchJourneyRequest()
    {
        // TODO
    }

    /**
     * Gets the start and end location IDs from journey data
     * @param array $input Journey data
     * @return array [$startLocationId, $endLocationId];
     */
    private function createStartEndLocations(array $input): array
    {
        $startLocationId = $this->locationService->getOrCreate(
            $input['start']['label'],
            $input['start']['city'],
            $input['start']['postcode'],
            $input['start']['lat'] ?? null,
            $input['start']['lon'] ?? null
        );

        $endLocationId = $this->locationService->getOrCreate(
            $input['end']['label'],
            $input['end']['city'],
            $input['end']['postcode'],
            $input['end']['lat'] ?? null,
            $input['end']['lon'] ?? null
        );

        if ($startLocationId === $endLocationId) {
            throw new \DomainException('Le point de départ et d\'arrivée ne peuvent pas être identiques');
        }

        $locationIds = ['start' => $startLocationId, 'end' => $endLocationId];

        return $locationIds;
    }

    /**
     * Saves a new series of stages
     * @param int $id Journey ID
     * @param array $stops
     * @return void
     */
    private function saveStages(int $id, array $stops): void
    {
        $order = 1;

        foreach ($stops as $stop) {

            $locationId = $this->locationService->getOrCreate(
                $stop['label'],
                $stop['city'],
                $stop['postcode'],
                $stop['lat'],
                $stop['lon']
            );

            $status = $this->stagesModel->insert([
                'id_journey_drive' => $id,
                'id_location'      => $locationId,
                'order'            => $order++,
            ]);

            if ($status === false) {
                throw new \RuntimeException('Erreur lors de la création des étapes');
            }
        }
    }

    /**
     * Function to filter journeys which don't have enough free seats
     * @param array $journeys Journeys matching in location and date
     * @param int $requestedSeats Amount of requested seats
     * @return array $newJourneys The filtered journeys with enough free seats
     */
    private function filterAvailableSeats(array $journeys, int $requestedSeats): array
    {
        if (empty($journeys)) {
            return [];
        }

        $bookingModel = model(BookingModel::class);

        $journeyIds = array_column($journeys, 'id_journey_drive');

        // Get total booked seats per journey
        $bookedSeats = $bookingModel
            ->select('id_journey_drive, SUM(seat_taken) as booked') // Stores a "booked" value with the sum of all seats taken for a given journey
            ->whereIn('id_journey_drive', $journeyIds)
            ->where('is_validated', true)
            ->where('deletion_date', null)
            ->groupBy('id_journey_drive')
            ->findAll();

        // Re-index by journey id
        $bookedByJourney = [];

        foreach ($bookedSeats as $booking) {
            $bookedByJourney[$booking['id_journey_drive']] = (int) $booking['booked'];
        }

        $filteredJourneys = [];

        foreach ($journeys as $journey) {
            $booked = $bookedByJourney[$journey['id_journey_drive']] ?? 0;
            $remainingSeats = (int) $journey['number_of_place'] - $booked;

            if ($remainingSeats >= $requestedSeats) {
                $journey['available_seats'] = $remainingSeats;
                $filteredJourneys[] = $journey;
            }
        }

        return $filteredJourneys;
    }

    /**
     * Sorts an itinerary by its route order
     * @param array $journey An itinerary containing a 'start' location id, 'departure_lat', 'departure_lon', and an 'end' location id, 'arrival_lat' and 'arrival_lon'
     * @param array $stages The corresponding itinerary's stages each containing 'id_location', 'latitude' and 'longitude'
     * @return array The route sorted in order of passage
     */
    private function buildJourneyRoute(array $journey, array $stages): array
    {
        $route = [];

        $route[] = [
            'id_location' => $journey['start'],
            'latitude'    => $journey['departure_lat'],
            'longitude'   => $journey['departure_lon']
        ];

        foreach ($stages as $stage) {
            $route[] = [
                'id_location' => $stage['id_location'],
                'latitude'    => $stage['latitude'],
                'longitude'   => $stage['longitude']
            ];
        }

        $route[] = [
            'id_location' => $journey['end'],
            'latitude'    => $journey['arrival_lat'],
            'longitude'   => $journey['arrival_lon']
        ];

        return $route;
    }

    /**
     * Trouve les journeys qui correspondent géographiquement à la requête de l'utilisateur
     * @param array $journeys Liste de journeys
     * @param array $departurePoint Lieu de départ donné par l'utilisateur (longitude en premier et latitude en deuxième, pas de clé nécessaire)
     * @param array|null $endPoint Lieu d'arrivé donné par l'utilisateur (longitude en premier et latitude en deuxième, pas de clé nécessaire).
     * @param int $maxDistance Option: La distance maximale (en mètre) autorisé pour la recherche. La valeur par défaut est 2500m
     * @return array Tableau contenant les journeys
     */
    private function matchJourneys(array $journeys, array $departurePoint, ?array $endPoint, int $maxDistance = 2500): array
    {
        $matches = [];
        $trackService = service('TrackService');

        foreach ($journeys as $journey) {
            if ($trackService->isOnTrack($departurePoint, $endPoint, $journey['id_track'], $maxDistance))
                $matches[] = $journey; //Adds the journey to the array if there is a match

        }

        return $matches;
    }

    /**
     * Removes all the empty stops and makes a new array with new indexes
     * @param array $stops
     * @return array
     */
    private function sanitizeStops(array $stops): array
    {
        $sanitizedStops = array_values(array_filter($stops, function ($item) {
            return !empty($item['lat']) && !empty($item['lon']);
        }));

        return $sanitizedStops;
    }

    /**
     * From data containing an original journey and a new journey, checks if the route is different
     * @param array $original The original journey data
     * @param array $input The updated journey data
     * @return bool
     */
    private function detectRouteChange(array $original, array $input): bool
    {
        // Normalizing data for checking if itinerary has changed
        $oldStart = ['lat' => $original['departure_lat'], 'lon' => $original['departure_lon']];
        $newStart = ['lat' => $input['start']['lat'], 'lon' => $input['start']['lon']];
        $oldEnd = ['lat' => $original['arrival_lat'], 'lon' => $original['arrival_lon']];
        $newEnd = ['lat' => $input['end']['lat'], 'lon' => $input['end']['lon']];

        $oldStops = '';
        $newStops = '';

        $isDrive = (isset($original['stages']));
        if ($isDrive) {
            $normalizeStop = function ($stop) {
                return ($stop['lat'] ?? '') . '|' . ($stop['lon'] ?? '');
            };

            $oldStops = array_map($normalizeStop, $original['stages'] ?? []);
            $newStops = array_map($normalizeStop, $input['stops'] ?? []);
        }

        // Has itinerary changed ?
        $routeChanged =
            $oldStart != $newStart ||
            $oldEnd != $newEnd ||
            (!$isDrive || $oldStops != $newStops);

        return $routeChanged;
    }

    /**
     * Builds a journey's track
     * @param array $input
     * @return int The track id
     */
    private function buildTrack(array $input, ?int $idTrack = null): int
    {
        $trackService = service('TrackService');
        $stops = $input['stops'];
        $start = [$input['start']['lon'], $input['start']['lat']];
        $end = [$input['end']['lon'], $input['end']['lat']];

        // Checking if there are stops in the journey
        $trackStop = array_map(function ($row) {
            return [
                $row['lon'],
                $row['lat']
            ];
        }, $stops); // Rebuilding each stop into a new array and saving only the lat on lon values

        $idTrack = $trackService->saveTrack($start, $end, $trackStop, $idTrack ?? null); //  Generation and saving of the tracking

        return $idTrack;
    }

    /**
     * Checks validity of departure time and returns a valid dateTime string for departure
     * @param array $input
     * @return string Departure time (Y-m-d H:i:s)
     */
    private function getDeparture(array $input): string
    {
        $departure = (new \DateTime(
            $input['start-date'] . ' ' . $input['start-time']
        ));
        $now = new \DateTime();

        if ($departure <= $now) {
            throw new \DomainException('La date de départ doit être dans le futur');
        }

        $departureTime = $departure->format('Y-m-d H:i:s');

        return $departureTime;
    }

    /**
     * Estimates the arrival time of the journey
     * @param int $idTrack
     * @param string $departureTime
     * @return string Estimated arrival (Y-m-d H:i:s)
     */
    private function estimateJourneyArrival(int $idTrack, string $departureTime): string
    {
        $trackModel = model(TrackModel::class);
        $track = $trackModel->find($idTrack);

        if (!$track) {
            throw new \RuntimeException('Track introuvable');
        }

        $duration = (int)$track['duration']; // Retrieving the duration of the track as an integer
        $date = new \DateTime($departureTime); // Converting departure time into a DateTime object
        $date->modify('+' . $duration . ' seconds'); // Applying duration (must be integer) modification to the date
        $estimatedArrival = $date->format('Y-m-d H:i:s'); // Storing the formatted new date as the estimated arrival

        return $estimatedArrival;
    }

    /**
     *  Checks car and seats validity, returns car data
     * @param int $carId
     * @param int $userId
     * @param int $requestedSeats
     * @return array Car data
     */
    private function validateCar(int $carId, int $userId, int $requestedSeats): array
    {
        $carModel = model(CarModel::class);

        $car = $carModel
            ->where('id_car', $carId)
            ->where('id_user', $userId)
            ->first();

        if (! $car) {
            throw new \DomainException('Voiture invalide');
        }

        if ($requestedSeats > $car['number_of_seat']) {
            throw new \DomainException('Pas assez de places dans cette voiture');
        }

        return $car;
    }
}
