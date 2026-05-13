<?php

namespace App\Validators;

use App\Validation\CustomRules;

class JourneyDriveValidator extends BaseValidator
{
    /**
     * List all the rules that needs to be followed in order to be valid
     * 
     * @return array Array containing all the rules
     */
    public function rules(): array
    {
        return [
            'seats'      => 'required|integer',
            'car'        => 'required|integer',
            'start-time' => 'required',
            'end-time'   => 'required',
            'start'      => 'required|string',
            'end'        => 'required|string',
        ];
    }
}
