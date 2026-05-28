<?php

namespace App\Models;

use CodeIgniter\Model;
use Override;

class JourneyDriveModel extends Model
{
    protected $table            = 'JourneyDrive';
    protected $primaryKey       = 'id_journey_drive';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    // Add id_track later, and remove nullability of id_track in db
    protected $allowedFields    = ['number_of_place', 'departure', 'estimated_arrival', 'id_track', 'start', 'end', 'id_car', 'driver'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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



    public function getAllJourneyInfos(int $idJourney): ?array
    {
        $journey = $this->select('
                JourneyDrive.*,
                CONCAT(Users.first_name, " ", LEFT(Users.last_name, 1), ".") AS driver_name,
                Users.avatar_filename,
                departure_location.address                                    AS departure_address,
                departure_city.postcode                                       AS departure_postcode,
                departure_city.name                                           AS departure_city,
                arrival_location.address                                      AS arrival_address,
                arrival_city.postcode                                         AS arrival_postcode,
                arrival_city.name                                             AS arrival_city,
                Car.brand                                                     AS car_brand,
                Car.model                                                     AS car_model,
                Car.color                                                     AS car_color,
                Car.year                                                      AS car_year,
                Car.number_of_seat                                            AS car_number_of_seat
            ')
            ->join('Users',    'Users.id_user = JourneyDrive.driver')
            ->join('Car',      'Car.id_car = JourneyDrive.id_car')
            ->join('Location AS departure_location', 'departure_location.id_location = JourneyDrive.start')
            ->join('City AS departure_city',         'departure_city.id_city = departure_location.id_city')
            ->join('Location AS arrival_location',   'arrival_location.id_location = JourneyDrive.end')
            ->join('City AS arrival_city',           'arrival_city.id_city = arrival_location.id_city')
            ->where('JourneyDrive.id_journey_drive', $idJourney)
            ->first();

        if (!$journey) return null;

        $stages = $this->db->table('Stages')
            ->select('
                            Stages.*,
                            Location.address,
                            City.postcode,
                            City.name AS city_name
                        ')
            ->join('Location', 'Location.id_location = Stages.id_location')
            ->join('City',     'City.id_city = Location.id_city')
            ->where('Stages.id_journey_drive', $idJourney)
            ->get()
            ->getResultArray();

        $journey['stages'] = $stages;

        return $journey;
    }
}
