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
    protected $validationRules      = [
        'booking_date'      => 'required|valid_date',
        'seat_taken'        => 'required|integer|greater_than[0]',
        'is_validated'      => 'permit_empty',
        'is_driver'         => 'permit_empty',
        'id_user'           => 'required|integer|greater_than[0]',
        'id_journey_drive'  => 'required|integer|greater_than[0]',
    ];
    protected $validationMessages   = [
        'seat_taken'        => [
            'greater_than' => 'Plus de place disponible'
        ],
        'id_user'           => [
            'required'     => 'Utilisateur non authentifié'
        ],
        'id_journey_drive'  => [
            'required'     => 'Trajet inconnu'
        ],
    ];
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
}
