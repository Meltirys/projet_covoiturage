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
            'id_car'        => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Le choix du véhicule est obligatoire',
                    'integer' => 'Veuillez choisir un véhicule valide',
                ]
            ],
            'start_city' => [
                'rules' => 'required|min_length[2]|max_length[50]',
                'errors' => [
                    'required' => 'La ville de départ est obligatoire',
                    'min_length' => 'Le nom de la ville est trop court',
                    'max_length' => 'Le nom de la ville est trop long',
                ]
            ],
            'seats'      => [
                'rules' => 'required|integer|max_length[2]',
                'errors' => [
                    'required' => 'Le nombre de places disponsibles est obligatoire',
                    'integer' => 'Le nombre de place doit être un nombre',
                ]
            ],
            'start-time' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Le temps de départ est obligatoire',
                ]
            ],
            'end-time'   => [
                'rules' => 'required',
                'errors' => ['required' => 'Le temps d\'arrivée est obligatoire',]
            ],
            'start'      => [
                'rules' => 'required|string',
                'errors' => [
                    'required' => 'L\'adresse de départ est obligatoire',
                    'string' => 'L\'adresse de départ est invalide',
                ]
            ],

            'end'        => [
                'rules' => 'required|string',
                'errors' => [
                    'required' => 'L\'adresse d\'arrivée est obligatoire',
                    'string' => 'L\adresse d\'arrivée est invalide'
                ]
            ],
        ];
    }
}
