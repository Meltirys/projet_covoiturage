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
        /*
         * /!\ Reminder to add options once implemented /!\
         */

        $cityRules = [
            'rules' => 'required|min_length[2]|max_length[50]',
            'errors' => [
                'required' => 'Choisir une ville est obligatoire',
                'min_length' => 'Le nom de la ville est trop court',
                'max_length' => 'Le nom de la ville est trop long',
            ]
        ];
        $postcodeRules = [
            'rules' => 'required|min_length[5]|max_length[10]',
            'errors' => [
                'required' => 'Le code postal est requis',
                'min_length' => 'Le code postal est trop court',
                'max_length' => 'Le code postal est trop long',
            ]
        ];
        $latRules = [
            'rules' => 'required|greater_than_equal_to[-90]|less_than_equal_to[90]',
            'errors' => [
                'required' => 'La latitude est obligatoire.',
                'greater_than_equal_to' => 'La latitude doit être supérieure ou égale à -90.',
                'less_than_equal_to' => 'La latitude doit être inférieure ou égale à 90.',
            ],
        ];
        $longRules = [
            'rules' =>  'required|greater_than_equal_to[-180]|less_than_equal_to[180]',
            'errors' => [
                'required' => 'La longitude est obligatoire.',
                'greater_than_equal_to' => 'La longitude doit être supérieure ou égale à -180.',
                'less_than_equal_to' => 'La longitude doit être inférieure ou égale à 180.',
            ]
        ];
        $datetimeRules = [
            'rules' => 'required|validateDatetime',
            'errors' => [
                'required' => 'La date et heure sont obligatoires.',
                'validateDatetime' => 'La date et heure sont invalides.',
            ]
        ];

        return [
            'id_car'        => [
                'rules' => 'required|is_natural_no_zero',
                'errors' => [
                    'required' => 'Le choix du véhicule est obligatoire',
                    'is_natural_no_zero' => 'Veuillez choisir un véhicule valide',
                ]
            ],
            'start_city' => $cityRules,
            'start_city_postcode' => $postcodeRules,
            'end_city' => $cityRules,
            'end_city_postcode' => $postcodeRules,
            'seats'      => [
                'rules' => 'required|min_length[1]|max_length[2]',
                'errors' => [
                    'required' => 'Le nombre de places disponsibles est obligatoire',
                    'min_length' => 'Le nombre de places choisi ne doit pas être inférieur à 1',
                    'max_length' => 'Le nombre de places choisi est trop grand',
                ]
            ],
            'start-time' => $datetimeRules,
            'end-time'   => $datetimeRules,
            'start'      => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'L\'adresse de départ est obligatoire',
                    'min_length' => 'L\'adresse de départ doit faire plus de 2 caractères',
                    'max_length' => 'L\'adresse de départ doit faire moins de 100 caractères',
                ]
            ],
            'start_lat' => $latRules,
            'start_long' => $longRules,
            'end'        => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'L\'adresse d\'arrivée est obligatoire',
                    'min_length' => 'L\'adresse d\'arrivée doit faire plus de 2 caractères',
                    'max_length' => 'L\'adresse d\'arrivée doit faire moins de 100 caractères',
                ]
            ],
            'end_lat' => $latRules,
            'end_long' => $longRules,
            'stops' => [
                'rules' => 'required|validStops',
                'errors' => [
                    'required' => 'Les arrêts sont obligatoires',
                    'validStops' => 'Un ou plusieurs arrêts sont invalides',
                ]
            ]
        ];
    }
}
