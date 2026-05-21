<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationModel extends Model
{
    protected $table            = 'Location';
    protected $primaryKey       = 'id_location';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['address', 'latitude', 'longitude', 'id_city'];

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
     * Gets the ID of the provided location. If it doesn't exist, insert as new location
     * 
     * @param string $address
     *
     * @param int $cityID The ID of the city
     * 
     * @param float $latitude
     * 
     * @param float $longitude
     * 
     * @return int The location ID
     */
    public function getOrCreate(string $address, int $cityID, float $latitude, float $longitude): int
    {
        $location = $this->where(['address' => $address, 'id_city' => $cityID])->first();

        if ($location) {
            return $location['id_location'];
        }

        return $this->insert([
            'address' => $address,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'id_city' => $cityID
        ]);
    }

    public function getFormattedAddress(int $idLocation) : ?string{
        $formattedAddress = $this->select("CONCAT(Location.address,', ', City.postcode, ' ', City.name) AS completeAddress")
            ->join('City', 'Location.id_city = City.id_city')
            ->where($this->primaryKey, $idLocation)
            ->first();

        if(!$formattedAddress) return null;

        return $formattedAddress['completeAddress'];
    }
}
