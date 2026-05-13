<?php

namespace App\Validation;

use DateTime;

class CustomRules
{
    /**
     * Checks if the person whom the birthdate provided belongs to is an adult
     * 
     * @param string $date Birthdate (format Y-m-d)
     * 
     * @return bool
     */
    public function adultCheck(string $date): bool
    {
        $birthDate = new DateTime($date);
        $today = new DateTime();

        return $today->diff($birthDate)->y >= 18;
    }

    /**
     * Verifies if the datetime value is realistic
     * 
     * @param string $value The datetime
     * 
     * @return bool
     */
    public function validateDatetime(string $value): bool
    {
        $dt = \DateTime::createFromFormat('Y-m-d H:i:s', $value);

        return $dt && $dt->format('Y-m-d H:i:s') === $value;
    }

    /**
     * Verification rule to check the validity of each stop in the array
     * 
     * @param array $value Array containing the stops
     * 
     * @return bool
     */
    public function validStops(array $value): bool
    {
        if (empty($value)) {
            return false;
        }

        // city name
        foreach ($value as $stop) {
            if (
                empty($stop['city_name']) ||
                strlen($stop['city_name']) < 2 ||
                strlen($stop['city_name']) > 50
            ) {
                return false;
            }
        }

        // postcode
        if (
            empty($stop['city_postcode']) ||
            ! preg_match('/^[A-Za-z0-9 ]{1,10}$/', $stop['city_postcode'])
        ) {
            return false;
        }

        // address
        if (empty($stop['address']) || strlen($stop['address']) < 2 || strlen($stop['address']) > 100) {
            return false;
        }

        // latitude
        if (
            ! isset($stop['latitude']) ||
            ! is_numeric($stop['latitude']) ||
            $stop['latitude'] < -90 ||
            $stop['latitude'] > 90
        ) {
            return false;
        }

        // longitude
        if (
            ! isset($stop['longitude']) ||
            ! is_numeric($stop['longitude']) ||
            $stop['longitude'] < -180 ||
            $stop['longitude'] > 180
        ) {
            return false;
        }

        return true;
    }
}
