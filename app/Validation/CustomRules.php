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
        if (empty($date)) {
            return true;
        }

        $birthDate = new DateTime($date);
        $today = new DateTime();

        return $today->diff($birthDate)->y >= 18;
    }

    /**
     * Validates a date in Y-m-d format
     * @param string $value The date
     * @return bool
     */
    public function validateDate(string $value): bool
    {
        if (empty($value)) {
            return true;
        }

        $dt = \DateTime::createFromFormat('Y-m-d', $value);

        return $dt && $dt->format('Y-m-d') === $value;
    }

    /**
     * Validates a time in H:i format (24h)
     * @param string $value The time
     * @return bool
     */
    public function validateTime(string $value): bool
    {
        if (empty($value)) {
            return true;
        }

        $dt = \DateTime::createFromFormat('H:i', $value);

        return $dt && $dt->format('H:i') === $value;
    }

    /**
     * Validates a datetime value in Y-m-d H:i:s format
     * @param string $value The datetime
     * @return bool
     */
    public function validateDatetime(string $value): bool
    {
        if (empty($value)) {
            return true;
        }

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
            return true;
        }

        foreach ($value as $stop) {

            // If all the fields in this stop are empty, skip validation for this stop
            $isEmpty =
                empty($stop['label']) &&
                empty($stop['lat']) &&
                empty($stop['lon']) &&
                empty($stop['city']) &&
                empty($stop['postcode']);
            if ($isEmpty) {
                continue;
            }

            // label
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

            // city
            if (
                empty($stop['city']) ||
                strlen($stop['city']) < 2 ||
                strlen($stop['city']) > 50
            ) {
                return false;
            }

            // postcode
            if (
                empty($stop['postcode']) ||
                ! preg_match('/^[A-Za-z0-9 ]{1,10}$/', $stop['postcode'])
            ) {
                return false;
            }
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
        if (empty($old_password)) {
            return true;
        }

        $dbUser = model('UserModel');
        $userInfo = $dbUser->find(session()->user_id);

        return password_verify($old_password, $userInfo['password']);
    }

    /**
     * Compare if two values are the same.
     * @param mixed $value The value to test   
     * @param string $params The parameter name we want to compare 
     * @param array $data All the tested datas of the validator
     * 
     * @return bool true if the values are the same, false otherwise
     */
    public function notSame(mixed $value, string $params, array $data): bool
    {
        if (empty($value) || !isset($data[$params])) {
            return true;
        }

        return $data[$params] !== $value;
    }

    /**
     * Checks if a date occurs before another
     * @param string $value
     * @param string $otherField
     * @param array $data
     * @return bool
     */
    public function beforeDate(string $value, string $otherField, array $data): bool
    {
        if (empty($value) || !isset($data[$otherField])) {
            // this function isn't responsible for checking existence of values so return true in that case
            return true;
        }

        return new DateTime($value) <= new DateTime($data[$otherField]);
    }

    /**
     * Checks if a date occurs exactly now or later
     * @param string $value
     * @return bool
     */
    public function equalOrAfterNow(string $value): bool
    {
        if (empty($value)) {
            return true;
        }

        $now = new DateTime();

        return new DateTime($value) >= $now;
    }
}
