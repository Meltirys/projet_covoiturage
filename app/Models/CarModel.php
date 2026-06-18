<?php

namespace App\Models;

use CodeIgniter\Model;

class CarModel extends Model
{
    protected $table            = 'Car';
    protected $primaryKey       = 'id_car';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['brand', 'model', 'color', 'year', 'number_of_seat', 'id_user'];

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
     * Retrieves the list of the user's saved cars
     * 
     * @param int $userID The user's ID
     * 
     * @return array The user's saved cars
     */
    public function getCarsByUser(int $userID): array
    {
        $cars = $this->select()
            ->where('id_user', $userID)
            ->findAll();

        if (empty($cars)) return [];

        return $cars;
    }

    /**
     * Return a boolean if the given user owns the given car
     * @param int $idUser The id of the user to test    
     * @param int $idCar The id of the car to test
     * 
     * @return array|null True if the user owns the car, false otherwise
     */
    public function getCarByUser(int $idUser, int $idCar): ?array
    {
        return $this->where('id_car', $idCar)->where('id_user', $idUser)->first();
    }
}
