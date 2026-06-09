<?php

namespace App\Validators\JourneyDrive;

use App\Validation\CustomRules;
use App\Validators\BaseValidator;

class SearchJourneyDriveValidator extends BaseValidator
{
    protected function rules(): array
    {
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
        $lonRules = [
            'rules' =>  'required|greater_than_equal_to[-180]|less_than_equal_to[180]',
            'errors' => [
                'required' => 'La longitude est obligatoire.',
                'greater_than_equal_to' => 'La longitude doit être supérieure ou égale à -180.',
                'less_than_equal_to' => 'La longitude doit être inférieure ou égale à 180.',
            ]
        ];
        $dateRules = [
            'rules' => 'required|validateDate',
            'errors' => [
                'required' => 'La date est obligatoire.',
                'validateDate' => 'La date est invalide.',
            ]
        ];
        $timeRules = [
            'rules' => 'required|validateTime',
            'errors' => [
                'required' => 'Le temps est obligatoire.',
                'validateTime' => 'Le temps est invalide.',
            ]
        ];

        return [
            // ===== START

            'start.label' => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'L\'adresse de départ est obligatoire',
                    'min_length' => 'L\'adresse de départ doit faire plus de 2 caractères',
                    'max_length' => 'L\'adresse de départ doit faire moins de 100 caractères',
                ]
            ],
            'start.city' => $cityRules,
            'start.postcode' => $postcodeRules,
            'start.lat' => $latRules,
            'start.lon' => $lonRules,

            // ===== END

            'end.label' => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'L\'adresse d\'arrivée est obligatoire',
                    'min_length' => 'L\'adresse d\'arrivée doit faire plus de 2 caractères',
                    'max_length' => 'L\'adresse d\'arrivée doit faire moins de 100 caractères',
                ]
            ],
            'end.city' => $cityRules,
            'end.postcode' => $postcodeRules,
            'end.lat' => $latRules,
            'end.lon' => $lonRules,

            'end' => [
                'rules' => 'notSame[start]',
                'errors' => [
                    'notSameLocation' => 'L\'adresse d\'arrivée ne doit pas être la même que celle du départ',
                ]
            ],

            // ===== STOPS

            'stops' => [
                'rules' => 'permit_empty|validStops',
                'errors' => [
                    'validStops' => 'Un ou plusieurs arrêts sont invalides',
                ]
            ],

            // ===== OTHER

            'free-seats'      => [
                'rules' => 'required|greater_than_equal_to[1]|less_than_equal_to[8]',
                'errors' => [
                    'required' => 'Le nombre de places disponsibles est obligatoire',
                    'greater_than_equal_to' => 'Le nombre de places choisi ne doit pas être inférieur à 1',
                    'less_than_equal_to' => 'Le nombre de places choisi est trop grand',
                ]
            ],
            'start-date' => $dateRules,
            'start-time' => $timeRules,
            'options'   => [
                'rules' => 'permit_empty',
                'errors' => [],
            ]
        ];
    }
}
