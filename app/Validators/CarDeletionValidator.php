<?php

namespace App\Validators;

class CarDeletionValidator extends BaseValidator
{

    protected function rules(): array
    {
        return [
            'idCar' => [
                'rules' => 'is_car_owner',
                'errors' => [
                    'is_car_owner' => 'Vous devez être propriétaire de la voiture que vous voulez supprimer',
                ]
            ]
        ];
    }
}
