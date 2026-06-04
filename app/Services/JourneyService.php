<?php

namespace App\Services;

use App\Models\BookingModel;
use App\Models\CarModel;
use App\Models\JourneyDriveModel;
use App\Models\JourneyRequestModel;
use App\Models\StagesModel;
use App\Models\TrackModel;
use CodeIgniter\Database\BaseConnection;
use DateTime;

class JourneyService
{
    private JourneyDriveModel $journeyDriveModel;
    private JourneyRequestModel $journeyRequestModel;

    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = db_connect();
        $this->journeyDriveModel = model(JourneyDriveModel::class);
        $this->journeyRequestModel = model(JourneyRequestModel::class);
    }

    /**
     * Attempts to create every element of the journey drive
     * @param array $input The user's inputs
     * @param int $userId The user's ID
     * @return int The JourneyDrive ID
     */
    public function createJourneyDrive(array $input, int $userId): int
    {
        $carModel       = model(CarModel::class);
        $locationService = service('locationService');
        $stageModel     = model(StagesModel::class);
        $trackModel = model('TrackModel');

        $input['start-datetime'] = (new DateTime(
            $input['start-date'] . ' ' . $input['start-time']
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

            //Calculating the estimated_arrival
            $duration = (int) $trackModel->find($idTrack)['duration']; //Retrieving the duration of the track
            $date = new \DateTime($input['start-datetime']);
            $date->modify('+' . $duration . ' seconds');
            $estimatedArrival = $date->format('Y-m-d H:i:s');

            $journeyData = [
                'number_of_place'   => (int) $input['seats'],
                'departure'         => $input['start-datetime'],
                'estimated_arrival' => $estimatedArrival,
                'id_car'            => $input['car'],
                'start'             => $startLocationId,
                'end'               => $endLocationId,
                'driver'            => $userId,
                'id_track'          => $idTrack
            ];

            $journeyId = $this->journeyDriveModel->insert($journeyData, true);

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
     * Deletes a journey drive
     * @param int $id The journey ID
     * @return void
     */
    public function deleteJourneyDrive(int $id): void
    {
        $bookingModel = model(BookingModel::class);
        $stageModel = model(StagesModel::class);
        $trackModel = model(TrackModel::class);

        $this->db->transBegin();

        $journey = $this->journeyDriveModel->find($id);

        if (!$journey) {
            throw new \DomainException('Le trajet n\'existe pas');
        }

        $journeyId = $journey['id'];

        try {
            // Suppression des réservations
            $bookingModel->where('id_journey_drive', $journeyId)->delete();

            // Suppression des étapes
            $stageModel->where('id_journey_drive', $journeyId)->delete();

            // Suppression du tracking
            $trackId = $journey['id_track'];
            $trackModel->delete($trackId);

            // Suppression du trajet
            $this->journeyDriveModel->delete($journeyId);

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
        $locationService = service('locationService');
        $stageModel = model(StagesModel::class);

        // searchJourneyDrive()
        // ├── resolve departure location
        // ├── resolve arrival location
        // ├── retrieve candidate journeys by date
        // ├── filter by geographical proximity
        // ├── filter by seats
        // └── return results

        // 1. Lieux de départ et arrivée
        $departureAddress = $input['start']['label'] ?? $input['start.address'] ?? '';
        $departureCity = $input['start']['city'] ?? $input['start.city'] ?? '';
        $departurePostcode = $input['start']['postcode'] ?? $input['start.postcode'] ?? '';

        $arrivalAddress = $input['end']['label'] ?? $input['end.address'] ?? '';
        $arrivalCity = $input['end']['city'] ?? $input['end.city'] ?? '';
        $arrivalPostcode = $input['end']['postcode'] ?? $input['end.postcode'] ?? '';

        $departureLocation = $locationService->findLocationByAddress(
            $departureAddress,
            $departureCity,
            $departurePostcode
        );
        $arrivalLocation = $locationService->findLocationByAddress(
            $arrivalAddress,
            $arrivalCity,
            $arrivalPostcode
        );

        $searchDate = $input['date'] ?? '';
        $requestedSeats = (int) ($input['free-seats'] ?? 1);

        if (empty($departureLocation) || empty($arrivalLocation) || empty($searchDate)) {
            return [];
        }

        // 2. Recherche des journeys correspondants par date
        $startDay = $searchDate . ' 00:00:00';
        $endDay = date('Y-m-d H:i:s', strtotime($startDay . ' +1 day'));

        $journeys = $this->journeyDriveModel
            ->select('JourneyDrive.*, 
                    departure_location.address AS departure_address,
                    departure_location.latitude AS departure_lat,
                    departure_location.longitude AS departure_lon,
                    departure_city.postcode AS departure_postcode,
                    departure_city.name AS departure_city,
                    arrival_location.address AS arrival_address,
                    arrival_location.latitude AS arrival_lat,
                    arrival_location.longitude AS arrival_lon,
                    arrival_city.postcode AS arrival_postcode,
                    arrival_city.name AS arrival_city,
                    Car.brand AS car_brand,
                    Car.model AS car_model,
                    Users.first_name AS driver_first_name,
                    Users.last_name AS driver_last_name,
                    Track.distance AS distance,
                    Track.duration AS duration')
            ->join('Location AS departure_location', 'departure_location.id_location = JourneyDrive.start')
            ->join('City AS departure_city', 'departure_city.id_city = departure_location.id_city')
            ->join('Location AS arrival_location', 'arrival_location.id_location = JourneyDrive.end')
            ->join('City AS arrival_city', 'arrival_city.id_city = arrival_location.id_city')
            ->join('Users', 'Users.id_user = JourneyDrive.driver')
            ->join('Car', 'Car.id_car = JourneyDrive.id_car')
            ->join('Track', 'Track.id_track = JourneyDrive.id_track')
            ->where('JourneyDrive.departure >=', $startDay)
            ->where('JourneyDrive.departure <', $endDay)
            ->findAll();

        if (empty($journeys)) {
            return [];
        }

        $journeyIds = array_column($journeys, 'id_journey_drive');

        $stages = $stageModel
            ->select('Stages.*, Location.latitude, Location.longitude')
            ->join('Location', 'Location.id_location = Stages.id_location')
            ->whereIn('id_journey_drive', $journeyIds)
            ->orderBy('id_journey_drive')
            ->orderBy('order')
            ->findAll();

        $stagesByJourney = [];

        foreach ($stages as $stage) {
            $stagesByJourney[$stage['id_journey_drive']][] = $stage;
        }

        // 3. Acquisition des journeys correspondants par itinéraire
        $matches = $this->matchJourneys($journeys, $stagesByJourney, $departureLocation, $arrivalLocation);

        // 4. Filtre par disponibilité des places
        $journeys = $this->filterAvailableSeats($matches, $requestedSeats);

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
        $locationService = service('locationService');

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

            $journeyId = $this->journeyRequestModel->insert($journeyData, true);

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

        $journeyId = $journey['id'];

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
    public function searchJourneyRequest() {}

    /**
     * Function to filter journeys which don't have enough free seats
     * 
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
            'latitude' => $journey['departure_lat'],
            'longitude' => $journey['departure_lon']
        ];

        foreach ($stages as $stage) {
            $route[] = [
                'id_location' => $stage['id_location'],
                'latitude' => $stage['latitude'],
                'longitude' => $stage['longitude']
            ];
        }

        $route[] = [
            'id_location' => $journey['end'],
            'latitude' => $journey['arrival_lat'],
            'longitude' => $journey['arrival_lon']
        ];

        return $route;
    }

    /**
     * Compare un lieu donné aux lieux appartenant à un itinéraire et retourne 
     * @param array $location
     * @param array $route
     * @param int $maxDistance défaut : 1000
     * @return array format : ['route_position' => index route, 'distance' => distance, 'id_location' => id du lieu] | vide [] si aucune correspondance
     */
    private function matchUserPointToRoute(array $location, array $route, int $maxDistance = 1000): array
    {
        $bestDistance = PHP_INT_MAX; // var to find shortest distance
        $bestIndex = null;
        $bestLocation = null;

        // Pour chaque lieu sur l'itinéraire
        foreach ($route as $order => $routeLocation) {
            // Obtiens la distance entre le lieu utilisateur et le lieu de l'itinéraire
            $distance = haversine_distance(
                $location['latitude'],
                $location['longitude'],
                $routeLocation['latitude'],
                $routeLocation['longitude']
            );

            if ($distance < $maxDistance && $distance < $bestDistance) {
                $bestDistance = $distance; // remplace la meilleure distance par la nouvelle meilleure distance
                $bestIndex = $order;
                $bestLocation = $routeLocation;
            }
        }

        if ($bestIndex === null) {
            return [];
        }

        return ['route_position' => $bestIndex, 'distance' => $bestDistance, 'id_location' => $bestLocation];
    }

    /**
     * Trouve les journeys qui correspondent géographiquement à la requête de l'utilisateur
     * @param array $journeys Liste de journeys
     * @param array $stagesByJourney Liste des stages des journeys
     * @param array $departureLocation Lieu de départ donné par l'utilisateur
     * @param array $arrivalLocation Lieu d'arrivée donné par l'utilisateur
     * @return array Tableau contenant les journeys
     */
    private function matchJourneys(array $journeys, array $stagesByJourney, array $departureLocation, array $arrivalLocation): array
    {
        $matches = [];

        foreach ($journeys as $journey) {
            // $stages = [chaque stage dans stageByJourney qui a l'id_journey_drive du journey actuel]
            $stages = $stagesByJourney[$journey['id_journey_drive']] ?? [];

            // Range l'itinéraire par l'ordre de passage
            $route = $this->buildJourneyRoute($journey, $stages);

            // Compare le début et la fin du trajet de l'utilisateur aux lieux appartenant à la route du trajet actuel
            $departureMatch = null;
            $arrivalMatch = null;

            $departureMatch = $this->matchUserPointToRoute($departureLocation, $route);
            $arrivalMatch = $this->matchUserPointToRoute($arrivalLocation, $route);

            if (
                empty($departureMatch)
                && empty($arrivalMatch)
                && $departureMatch['route_position'] < $arrivalMatch['route_position']
            ) {
                // ajout des données du calcul de distance ()
                $journey['departure_match'] = $departureMatch;
                $journey['arrival_match'] = $arrivalMatch;
                $matches[] = $journey;
            }
        }

        return $matches;
    }
}
