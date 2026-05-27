<?php

namespace App\Services;

use App\Models\CarModel;
use App\Models\CityModel;
use App\Models\LocationModel;
use App\Models\JourneyDriveModel;
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
        $cityModel      = model(CityModel::class);
        $locationModel  = model(LocationModel::class);
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

            // 2. Cities
            $startCityId = $cityModel->getOrCreate(
                $input['start']['city'],
                $input['start']['postcode'],
            );

            $endCityId = $cityModel->getOrCreate(
                $input['end']['city'],
                $input['end']['postcode'],
            );

            // 3. Locations
            $startLocationId = $locationModel->getOrCreate(
                $input['start']['label'],
                $startCityId,
                $input['start']['lat'] ?? null,
                $input['start']['lon'] ?? null
            );

            $endLocationId = $locationModel->getOrCreate(
                $input['end']['label'],
                $endCityId,
                $input['end']['lat'] ?? null,
                $input['end']['lon'] ?? null
            );

            // 4. Journey
            $journeyData = [
                'number_of_place'   => (int) $input['seats'],
                'departure'         => $input['start-datetime'],
                'estimated_arrival' => $input['end-datetime'],
                'id_car'            => $input['car'],
                'start'             => $startLocationId,
                'end'               => $endLocationId,
            ];

            $journeyId = $journeyModel->insert($journeyData, true);

            if (! $journeyId) {
                throw new \RuntimeException('Impossible de créer le trajet');
            }

            // 5. Stages (optional)
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

                $cityId = $cityModel->getOrCreate(
                    $stop['city'],
                    $stop['postcode']
                );

                $locationId = $locationModel->getOrCreate(
                    $stop['label'],
                    $cityId,
                    $stop['lat'],
                    $stop['lon']
                );

                $ok = $stageModel->save([
                    'id_journey_drive' => $journeyId,
                    'id_location'      => $locationId,
                    'order'            => $order++,
                ]);

                if (! $ok) {
                    throw new \RuntimeException('Erreur lors de la création des étapes');
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
     */
    public function searchJourneyDrive()
    {
        // convert date to datetime range
        $startDay = $data['date'] . '00:00:00';
        // $endDay = $data['date'] avancer d'1 jour . '00:00:00';
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
        $cityModel      = model(CityModel::class);
        $locationModel  = model(LocationModel::class);
        $journeyModel   = model(JourneyDriveModel::class);
        $stageModel     = model(StagesModel::class);

        $this->db->transBegin();

        try {
            // 1. Cities
            $startCityId = $cityModel->getOrCreate(
                $input['start']['city'],
                $input['start']['postcode'],
            );

            $endCityId = $cityModel->getOrCreate(
                $input['end']['city'],
                $input['end']['postcode'],
            );

            // 2. Locations
            $startLocationId = $locationModel->getOrCreate(
                $input['start']['label'],
                $startCityId,
                $input['start']['lat'] ?? null,
                $input['start']['lon'] ?? null
            );

            $endLocationId = $locationModel->getOrCreate(
                $input['end']['label'],
                $endCityId,
                $input['end']['lat'] ?? null,
                $input['end']['lon'] ?? null
            );

            // 3. Journey
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

            // 4. Transaction safety
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
