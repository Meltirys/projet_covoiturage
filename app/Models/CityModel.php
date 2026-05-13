<?php

namespace App\Models;

use CodeIgniter\Model;

class CityModel extends Model
{
    protected $table            = 'City';
    protected $primaryKey       = 'id_city';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'postcode'];

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
     * Gets the ID of the city provided. If it doesn't exist, insert as a new city
     * 
     * @param string $cityName The name of the city
     *
     * @param string $postCode The city's postcode
     * 
     * @return int The city's ID
     */
    public function getOrCreate(string $cityName, string $postCode): int
    {
        $city = $this->where(['name' => $cityName, 'postcode' => $postCode])->first();

        if ($city) {
            return $city['id_city'];
        }

        return $this->insert([
            'city_name' => $cityName,
            'postcode' => $postCode
        ]);
    }
}
