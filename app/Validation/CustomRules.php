<?php

namespace App\Validation;

use DateTime;

class CustomRules
{
    /**
     * Checks if the person whom the provided birthdate belongs to is an adult
     * @param string $date Birthdate (format Y-m-d)
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
     * @param string $value The datetime
     * @return bool
     */
    public function validateDatetime(string $value): bool
    {
        $dt = \DateTime::createFromFormat('Y-m-d H:i:s', $value);

        return $dt && $dt->format('Y-m-d H:i:s') === $value;
    }

    /**
     * Verification rule to check the validity of each stop in the array
     * @param array $value Array containing the stops
     * @return bool
     */
    public function validStops(array $value): bool
    {
        if (empty($value)) {
            return false;
        }

        // address
        if (empty($stop['label']) || strlen($stop['label']) < 2 || strlen($stop['label']) > 100) {
            return false;
        }

        // latitude
        if (
            ! isset($stop['lat']) ||
            ! is_numeric($stop['lat']) ||
            $stop['lat'] < -90 ||
            $stop['lat'] > 90
        ) {
            return false;
        }

        // longitude
        if (
            ! isset($stop['lon']) ||
            ! is_numeric($stop['lon']) ||
            $stop['lon'] < -180 ||
            $stop['lon'] > 180
        ) {
            return false;
        }

        // city name
        foreach ($value as $stop) {
            if (
                empty($stop['city']) ||
                strlen($stop['city']) < 2 ||
                strlen($stop['city']) > 50
            ) {
                return false;
            }
        }

        // postcode
        if (
            empty($stop['postcode']) ||
            ! preg_match('/^[A-Za-z0-9 ]{1,10}$/', $stop['postcode'])
        ) {
            return false;
        }

        return true;
    }


    /**
     * This function compare a given password with the password of the connected user
     * @param string $old_password The old password typed by the user
     * @return bool True if it matches the password in the database, false otherwise
     */
    public function isOldPassword(string $old_password): bool
    {

        $dbUser = model('UserModel');
        $userInfo = $dbUser->find(session()->user_id);

        return password_verify($old_password, $userInfo['password']);
    }

    public function isValidAddress(string $address) : bool {
        
    }
}
