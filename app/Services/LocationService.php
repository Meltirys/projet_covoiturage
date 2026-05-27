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
        $this->cityModel     = new CityModel();
        $this->locationModel = new LocationModel();
    }

    /**
     * Retrieves or creates a complete location from address data.
     * Can be called with or without coordinates.
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
        if (!$latitude || !$longitude) {
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
