<?php

namespace App\Services;

use App\Models\CarModel;
use App\Models\CityModel;
use App\Models\LocationModel;
use App\Models\JourneyDriveModel;
use App\Models\StagesModel;
use CodeIgniter\Database\BaseConnection;

class JourneyService
{
    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    /**
     * Attempts to create every element of the driver's journey
     * 
     * @param array $input The user's inputs
     * 
     * @param int $userId The user's ID
     * 
     * @return int The journey's ID
     */
    public function createJourneyDrive(array $input, int $userId): int
    {
        $carModel       = model(CarModel::class);
        $cityModel      = model(CityModel::class);
        $locationModel  = model(LocationModel::class);
        $journeyModel   = model(JourneyDriveModel::class);
        $stageModel     = model(StagesModel::class);

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
                $input['start_city'],
                $input['start_postcode']
            );

            $endCityId = $cityModel->getOrCreate(
                $input['end_city'],
                $input['end_postcode']
            );

            // 3. Locations
            $startLocationId = $locationModel->getOrCreate(
                $input['start_label'],
                $startCityId,
                $input['start_lat'] ?? null,
                $input['start_lon'] ?? null
            );

            $endLocationId = $locationModel->getOrCreate(
                $input['end_label'],
                $endCityId,
                $input['end_lat'] ?? null,
                $input['end_lon'] ?? null
            );

            // 4. Journey
            $journeyData = [
                'number_of_place'   => (int) $input['seats'],
                'departure'         => $input['start-time'],
                'estimated_arrival' => $input['end-time'],
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

            foreach ($stops as $index => $stop) {

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
                    'order'            => $index + 1,
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
}
