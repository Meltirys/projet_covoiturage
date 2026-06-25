<?php

namespace App\Models;

use CodeIgniter\Model;

class JourneyRequestModel extends Model
{
    protected $table            = 'JourneyRequest';
    protected $primaryKey       = 'id_journey_request';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['description', 'earliest_departure', 'latest_departure', 'start', 'end', 'id_creator'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deletion_date';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Returns all journey infos where the date is in the given range. It returns all informations needed for the view to display a research card
     * @param ?string $startDay The starting day requested by the user
     * @param ?string $endDay Optionnal : Defines the range of research. If not set, will returns all journeys after the start day
     * @param int $resultAmount Optionnal : Defines the amount of journeys returned. By default, returns all journeys found
     * 
     * @return array All the journeys that are in the given range of time
     */
    public function getJourneyInfosByDates(?string $startDay = null, ?string $endDay = null, int $resultAmount = -1): array
    {
        $query = $this->select('JourneyRequest.*, 
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

                    Users.first_name AS creator_first_name,
                    Users.last_name AS creator_last_name,

                    COUNT(RequestMember.id_request_member) AS member_count,
                    MIN(RequestMember.request_date) AS request_date')
            ->join('Location AS departure_location', 'departure_location.id_location = JourneyRequest.start')
            ->join('City AS departure_city', 'departure_city.id_city = departure_location.id_city')

            ->join('Location AS arrival_location', 'arrival_location.id_location = JourneyRequest.end')
            ->join('City AS arrival_city', 'arrival_city.id_city = arrival_location.id_city')

            ->join('Users', 'Users.id_user = JourneyRequest.id_creator')
            ->join('RequestMember', 'RequestMember.id_journey_request = JourneyRequest.id_journey_request', 'left')

            ->where('JourneyRequest.deletion_date IS NULL')
            ->groupBy('JourneyRequest.id_journey_request');

        // Only apply filters if user entered them
        if ($startDay !== null) {
            $query->where('JourneyRequest.earliest_departure >=', $startDay);
        }

        if ($endDay !== null) {
            $query->where('JourneyRequest.latest_departure <=', $endDay);
        }

        if ($resultAmount > 0) {
            $query->limit($resultAmount);
        }

        $query->orderBy('JourneyRequest.earliest_departure', 'ASC');

        return $query->findAll();
    }
}
