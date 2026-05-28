<?php

namespace App\Services;

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

            // 3. Journey
            $userId = session()->get('user_id');

            $journeyData = [
                'number_of_place'   => (int) $input['seats'],
                'departure'         => $input['start-datetime'],
                'estimated_arrival' => $input['end-datetime'],
                'id_car'            => $input['car'],
                'start'             => $startLocationId,
                'end'               => $endLocationId,
                'driver'            => $userId,
            ];

            $journeyId = $journeyModel->insert($journeyData, true);

            if (! $journeyId) {
                throw new \RuntimeException('Impossible de créer le trajet');
            }

            // 4. Stages (optional)
            $stops = $input['stops'] ?? [];
            $order = 1;

            foreach ($stops as $stop) {

                // Skip stop if empty
                $isEmpty =
                    empty($stop['label']) &&
                    empty($stop['lat']) &&
                    empty($stop['lon']) &&
                    empty($stop['city']) &&
                    empty($stop['postcode']);
                if ($isEmpty) {
                    continue;
                }

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

            // 5. Transaction safety
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
     */
    public function searchJourneyDrive(array $input)
    {
        // convert date to datetime range
        $startDay = $input['date'] . '00:00:00';
        // $endDay = $input['date'] avancer d'1 jour . '00:00:00';
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
            $input['range-of-time'] = $input['range-start'] . ' - ' . $input['range-end'];

            $journeyData = [
                'description'       => $input['description'],
                'departure'         => $input['start-datetime'],
                'estimated_arrival' => $input['end-datetime'],
                'range_of_time'     => $input['range-of-time'],
                'start'             => $startLocationId,
                'end'               => $endLocationId,
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
}
