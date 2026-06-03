<?php

namespace App\Services;

use App\Models\CityModel;
use App\Models\LocationModel;

class LocationService
{
    private CityModel     $cityModel;
    private LocationModel $locationModel;

    public function __construct()
    {
        $this->cityModel     = model(CityModel::class);
        $this->locationModel = model(LocationModel::class);
    }

    /**
     * Finds location ID matching given data
     * @param string $address
     * @param string $city
     * @param string $postcode
     * @return array $locationData Location data if found, otherwise empty array
     */
    public function findLocationByAddress(
        string $address,
        string $city,
        string $postcode,
    ): array {
        // 1. Retrieve the city
        $cityData = $this->cityModel
            ->where([
                'name'     => $city,
                'postcode' => $postcode
            ])->first();

        if (! $cityData) {
            return [];
        }

        // 3. Retrieve the location
        $locationData = $this->locationModel
            ->where([
                'address'   => $address,
                'id_city'   => $cityData['id_city']
            ])
            ->first();

        return $locationData;
    }

    /**
     * Retrieves or creates a complete location from address data.
     * Can be called with or without coordinates.
     * @param string $address
     * @param string $city
     * @param string $postcode 
     * @param ?float $latitude 
     * @param ?float $longitude 
     * @return int The location's primary row ID
     */
    public function getOrCreate(
        string $address,
        string $city,
        string $postcode,
        ?float $latitude  = null,
        ?float $longitude = null
    ): int {
        // 1. Retrieve or create the city
        $cityData = $this->cityModel->getOrCreate($city, $postcode);

        // 2. If no coordinates provided, fetch them via the API
        if ($latitude === null || $longitude === null) {
            $coords    = $this->getCoordinates($address, $city, $postcode);
            $latitude  = $coords['latitude'];
            $longitude = $coords['longitude'];
        }

        // 3. Retrieve or create the location
        return $this->locationModel->getOrCreate(
            $address,
            $cityData,
            $latitude,
            $longitude
        );
    }

    /**
     * Fetches coordinates from the French government geocoding API
     * Returns null values if the address cannot be found
     * @param string $address
     * @param string $city
     * @param string $postcode
     * @return array Array containing latitude and longitude, both null of address not found
     */
    private function getCoordinates(string $address, string $city, string $postcode): array
    {
        $fullAddress = $address . ' ' . $postcode . ' ' . $city;
        $url         = 'https://data.geopf.fr/geocodage/search/?q=' . urlencode($fullAddress) . '&limit=1';
        $response    = file_get_contents($url);
        $data        = json_decode($response, true);

        if (empty($data['features'])) {
            return ['latitude' => null, 'longitude' => null];
        }

        return [
            'latitude'  => $data['features'][0]['geometry']['coordinates'][1],
            'longitude' => $data['features'][0]['geometry']['coordinates'][0],
        ];
    }
}
