<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table            = 'Booking';
    protected $primaryKey       = 'id_booking';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['booking_date', 'seat_taken', 'meeting_point', 'is_validated', 'is_driver', 'deletion_date', 'id_user', 'id_journey_drive'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'is_validated' => 'boolean',
        'is_driver'    => 'boolean',
    ];
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

    public function getPastJourney(int $idUser, bool $accepted = true)
    {
        return $this->join('JourneyDrive', 'JourneyDrive.id_journey_drive = Booking.id_journey_drive')
            ->where('Booking.id_user', $idUser)
            ->where('is_validated', $accepted)
            ->where('JourneyDrive.estimated_arrival <', date('Y-m-d H:i:s'))
            ->countAllResults();
    }

    public function getDetailedBookingsByUserId(int $idUser)
    {
        return $this->select('
                JourneyDrive.driver                                           AS id_user,
                CONCAT(Users.first_name, " ", LEFT(Users.last_name, 1), ".")  AS name,
                departure_city.postcode                                       AS departure_postcode,
                departure_city.name                                           AS departure_city,
                arrival_city.postcode                                         AS arrival_postcode,
                arrival_city.name                                             AS arrival_city,

            ')
            ->join('JourneyDrive', "JourneyDrive.id_journey_drive = Booking.id_journey_drive")
            ->join('Users',    'Users.id_user = JourneyDrive.driver')
            ->join('Location as departure_location', 'departure_location.id_location = JourneyDrive.start')
            ->join('City AS departure_city',         'departure_city.id_city = departure_location.id_city')
            ->join('Location AS arrival_location',   'arrival_location.id_location = JourneyDrive.end')
            ->join('City AS arrival_city',           'arrival_city.id_city = arrival_location.id_city')
            ->where('Booking.id_user', $idUser)
            ->where('JourneyDrive.deletion_date IS NULL')
            ->where('JourneyDrive.departure >', date('Y-m-d H:i:s'))
            ->where('Booking.is_validated', true)
            ->findAll();
    }
}
