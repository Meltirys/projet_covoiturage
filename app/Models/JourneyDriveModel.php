<?php

namespace App\Models;

use CodeIgniter\Model;

class JourneyDriveModel extends Model
{
    protected $table            = 'JourneyDrive';
    protected $primaryKey       = 'id_journey_drive';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['number_of_place', 'departure', 'estimated_arrival', 'start', 'end', 'id_car', 'driver', 'id_track'];

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


    /**
     * Retrieves all of a given journey's data
     * @param int $idJourney
     * @return array
     */
    public function getAllJourneyInfos(int $idJourney): ?array
    {
        $journey = $this->select('
                JourneyDrive.*,
                CONCAT(Users.first_name, " ", LEFT(Users.last_name, 1), ".") AS driver_name,
                Users.avatar_filename,
                departure_location.address                                    AS departure_address,
                departure_location.latitude                                   AS departure_lat,
                departure_location.longitude                                  AS departure_lon,
                departure_city.postcode                                       AS departure_postcode,
                departure_city.name                                           AS departure_city,
                arrival_location.address                                      AS arrival_address,
                arrival_location.latitude                                     AS arrival_lat,
                arrival_location.longitude                                    AS arrival_lon,
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
                            Location.latitude AS lat,
                            Location.longitude AS lon,
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

    public function futureJourneyByCar(int $idCar): array
    {
        return $this
            ->where('id_car', $idCar)
            ->where('departure < ', date('Y-m-d H:i:s'))
            ->findAll();
    }

    /**
     * Returns all the journey infos where the date is in the given range. It returns all the informations needed for the view to display a research card
     * @param string $startDay The starting day requested by the user
     * @param ?string $endDay Optionnal : Defines the range of research. If not setted, will returns all the journeys after the start day
     * @param int $numberOfJourney Optionnal : Defines the number of journey that are returned. By default, returns all the journeys found
     * 
     * @return array All the journeys that are in the given range of time
     */
    public function getJourneyInfosByDates(string $startDay, ?string $endDay = null, int $numberOfJourney = -1): array
    {
        $query = $this->select('JourneyDrive.*, 
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
            ->where('JourneyDrive.departure >=', $startDay);

        //Adding the end day to the query if it is setted
        if ($endDay) {
            $query->where('JourneyDrive.departure <', $endDay);
        }

        if($numberOfJourney > 0){
            $query->limit($numberOfJourney);
        }


        return $query->findAll();
    }
}
