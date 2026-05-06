<?php

namespace App\Validation;

use DateTime;

class CustomRules
{
    /**
     * Checks if the person whom the birthdate provided belongs to is an adult
     * Parameter : Birthdate (format Y-m-d)
     * Result : true if 18 or over, false if under 18
     */
    public function adultCheck(string $date): bool
    {
        $birthDate = new DateTime($date);
        $today = new DateTime();

        return $today->diff($birthDate)->y >= 18;
    }
}
