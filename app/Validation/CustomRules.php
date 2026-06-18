<?php

namespace App\Validation;

use App\Models\JourneyDriveModel;
use DateTime;

class CustomRules
{
    /**
     * Checks if the person whom the provided birthdate belongs to is an adult
     * @param string $date Birthdate (format Y-m-d)
     * @return bool
     */
    public function is_adult(string $date): bool
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
    public function valid_date(string $value): bool
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
    public function valid_time(string $value): bool
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
    public function valid_datetime(string $value): bool
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
    public function valid_stops(array $value): bool
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
    public function is_old_password(string $old_password): bool
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
    public function location_different_from(mixed $value, string $params, array $data): bool
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
    public function before_date(string $value, string $otherField, array $data): bool
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
    public function equal_or_after_now(string $value): bool
    {
        if (empty($value)) {
            return true;
        }

        $now = new DateTime();

        return new DateTime($value) >= $now;
    }

    /**
     * Checks if the new amount of seats conflicts with the amount of seats allocated in a journey this car is used in
     * @param string $value
     * @param ?int $carId
     * @return bool
     */
    public function no_journey_conflict(string $value, ?string $carId = null): bool
    {
        if (!$value || $carId === null) {
            return true;
        }

        $journeyDriveModel = model(JourneyDriveModel::class);
        $journeys = $journeyDriveModel->select('number_of_place')->where('id_car', (int) $carId)->findAll();

        $places = array_column($journeys, 'number_of_place');

        return empty($places) || max($places) <= (int) $value;
    }

    /**
     * Checks if the connected user owns a given car
     * @param mixed $value The id of the car
     * 
     * @return bool True if he owns the car, false otherwise
     */
    public function is_car_owner(mixed $value): bool
    {
        if (!$value) return true; //If the id is not given, then returns true

        $carModel = model('CarModel');
        return $carModel->getCarByUser(session('user_id'), $value) ? true : false;
    }

}
