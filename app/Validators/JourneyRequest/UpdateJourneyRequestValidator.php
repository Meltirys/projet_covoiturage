<?php

namespace App\Validators\JourneyRequest;

use App\Validation\CustomRules;
use App\Validators\BaseValidator;

class UpdateJourneyRequestValidator extends BaseValidator
{
    /**
     * List of rules that needs to be followed for validation
     * @return array Array containing the rules
     */
    public function rules(): array
    {
        /*
         * /!\ Reminder to add options once implemented /!\
         */

        $cityRules = [
            'rules' => 'permit_empty|min_length[2]|max_length[50]',
            'errors' => [
                'min_length' => 'Le nom de la ville est trop court',
                'max_length' => 'Le nom de la ville est trop long',
            ]
        ];
        $postcodeRules = [
            'rules' => 'permit_empty|min_length[5]|max_length[10]',
            'errors' => [
                'min_length' => 'Le code postal est trop court',
                'max_length' => 'Le code postal est trop long',
            ]
        ];
        $latRules = [
            'rules' => 'permit_empty|greater_than_equal_to[-90]|less_than_equal_to[90]',
            'errors' => [
                'greater_than_equal_to' => 'La latitude doit être supérieure ou égale à -90.',
                'less_than_equal_to' => 'La latitude doit être inférieure ou égale à 90.',
            ],
        ];
        $lonRules = [
            'rules' =>  'permit_empty|greater_than_equal_to[-180]|less_than_equal_to[180]',
            'errors' => [
                'greater_than_equal_to' => 'La longitude doit être supérieure ou égale à -180.',
                'less_than_equal_to' => 'La longitude doit être inférieure ou égale à 180.',
            ]
        ];
        $dateRules = [
            'rules' => 'required|valid_date',
            'errors' => [
                'required' => 'La date est obligatoire.',
                'valid_date' => 'La date est invalide.',
            ]
        ];

        return [

            // ===== START
            'start.label' => [
                'rules' => 'permit_empty|min_length[2]|max_length[100]',
                'errors' => [
                    'min_length' => 'L\'adresse de départ doit faire plus de 2 caractères',
                    'max_length' => 'L\'adresse de départ doit faire moins de 100 caractères',
                ]
            ],
            'start.lat' => $latRules,
            'start.lon' => $lonRules,
            'start.city' => $cityRules,
            'start.postcode' => $postcodeRules,

            // ===== END
            'end.label' => [
                'rules' => 'permit_empty|min_length[2]|max_length[100]',
                'errors' => [
                    'min_length' => 'L\'adresse d\'arrivée doit faire plus de 2 caractères',
                    'max_length' => 'L\'adresse d\'arrivée doit faire moins de 100 caractères',
                ]
            ],
            'end.lat' => $latRules,
            'end.lon' => $lonRules,
            'end.city' => $cityRules,
            'end.postcode' => $postcodeRules,

            // ===== OTHER
            'date' => [
                'rules' => 'permit_empty|valid_date',
                'errors' => [
                    'valid_date' => 'La date est invalide.',
                ]
            ],
            'range-start' => [
                'rules' => 'permit_empty|regex_match[/^([01]\d|2[0-3]):([0-5]\d)$/]|before_date[range-end]|equal_or_after_now',
                'errors' => [
                    'regex_match' => 'L\'heure doit être dans le format HH:MM',
                    'before_date' => 'L\'heure de départ doit être avant l\'heure d\'arrivée',
                    'equal_or_after_now' => 'L\'heure de départ ne peut pas être dans le passé'
                ]
            ],
            'range-end' => [
                'rules' => 'permit_empty|regex_match[/^([01]\d|2[0-3]):([0-5]\d)$/]',
                'errors' => [
                    'regex_match' => 'L\'heure doit être dans le format HH:MM',
                ]
            ],
            'description' => [
                'rules' => 'permit_empty|max_length[500]',
                'errors' => [
                    'max_length' => 'La description ne doit pas dépasser 500 caractères.'
                ]
            ],
            'options'   => [
                'rules' => 'permit_empty',
                'errors' => [],
            ]
        ];
    }
}
