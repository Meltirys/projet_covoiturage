<?php

if (!function_exists('haversine_distance')) {
    /**
     * Calculates distance between two points using the haversine formula
     * @param float $lat1 The latitude of the first location
     * @param float $lon1 The longitude of the first location
     * @param float $lat2 The latitude of the second location
     * @param float $lon2 The longitude of the second location     
     * 
     * @return float The distance between the two given points
     */
    function haversine_distance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {
        $earthRadius = 6371000;

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo   = deg2rad($lat2);
        $lonTo   = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) ** 2 +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) ** 2;

        $c = 2 * asin(min(1, sqrt($a)));

        return $earthRadius * $c;
    }
}
