<?php

namespace App\Validators;

use App\Validation\CustomRules;

class CarValidator extends BaseValidator
{
    private ?int $carId;

    public function __construct(?int $carId = null)
    {
        parent::__construct();
        $this->carId = $carId ?? null;
    }

    protected function rules(): array
    {
        return [
            'brand' => [
                'rules'  => 'required|min_length[2]|max_length[50]',
                'errors' => [
                    'required'   => 'La marque est obligatoire.',
                    'min_length' => 'La marque doit contenir au moins 2 caractères.',
                    'max_length' => 'La marque ne peut pas dépasser 50 caractères.',
                ]
            ],
            'model' => [
                'rules'  => 'required|min_length[2]|max_length[50]',
                'errors' => [
                    'required'   => 'Le modèle est obligatoire.',
                    'min_length' => 'Le modèle doit contenir au moins 2 caractères.',
                    'max_length' => 'Le modèle ne peut pas dépasser 50 caractères.',
                ]
            ],
            'color' => [
                'rules'  => 'required|min_length[2]|max_length[50]',
                'errors' => [
                    'required'   => 'La couleur est obligatoire.',
                    'min_length' => 'La couleur doit contenir au moins 2 caractères.',
                    'max_length' => 'La couleur ne peut pas dépasser 50 caractères.',
                ]
            ],
            'year' => [
                'rules'  => 'required|integer|greater_than_equal_to[1950]|less_than_equal_to[' . date('Y') . ']',
                'errors' => [
                    'required'              => 'L\'année est obligatoire.',
                    'integer'               => 'L\'année doit être un nombre entier.',
                    'greater_than_equal_to' => 'L\'année ne peut pas être antérieure à 1950.',
                    'less_than_equal_to'    => 'L\'année ne peut pas dépasser ' . date('Y') . '.',
                ]
            ],
            'number_of_seat' => [
                'rules'  => 'required|integer|greater_than[0]|less_than_equal_to[8]', //no_journey_conflict[''] to add 
                'errors' => [
                    'required'            => 'Le nombre de places est obligatoire.',
                    'integer'             => 'Le nombre de places doit être un nombre entier.',
                    'greater_than'        => 'Le nombre de places doit être supérieur à 0.',
                    'less_than_equal_to'  => 'Le nombre de places ne peut pas dépasser 8.',
                    'no_journey_conflict' => 'Le nombre de places est en conflit avec un de vos trajets. Veuillez modifier le trajet avant de modifier le nombre de places.'
                ]
            ],
        ];
    }
}
