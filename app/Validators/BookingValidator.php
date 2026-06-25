<?php

namespace App\Validators;

class BookingValidator extends BaseValidator
{
    protected function rules(): array
    {
        return [
            'booking_date' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required' => 'La date de réservation est obligatoire.',
                ],
            ],
            'seat_taken' => [
                'rules'  => 'required|integer|greater_than[0]',
                'errors' => [
                    'greater_than' => 'Le nombre de places doit être supérieur à 0.',
                ],
            ],
            'id_user' => [
                'rules'  => 'required|integer|greater_than[0]',
                'errors' => [
                    'required' => 'Utilisateur non authentifié.',
                ],
            ],
            'id_journey_drive' => [
                'rules'  => 'required|integer|greater_than[0]',
                'errors' => [
                    'required' => 'Trajet inconnu.',
                ],
            ],
        ];
    }
}
