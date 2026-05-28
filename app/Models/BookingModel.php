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
    protected $allowedFields    = ['booking_date', 'seat_taken', 'is_validated', 'is_driver', 'deletion_date', 'id_user', 'id_journey_drive'];

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
}
