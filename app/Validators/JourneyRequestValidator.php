<?php

namespace App\Validators;

use App\Validation\CustomRules;

class JourneyRequestValidator extends BaseValidator
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
        $lonRules = [
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
            // ===== OTHER

            'start-datetime' => $datetimeRules,
            'end-datetime'   => $datetimeRules,
            'range-start' => [
                'rules' => 'required|regex_match[/^([01]\d|2[0-3]):([0-5]\d)$/]',
                'errors' => [
                    'required' => 'L\'heure de début de disponibilité est obligatoire',
                    'regex_match' => 'L\'heure doit être dans le format HH:MM',
                ]
            ],
            'range-end' => [
                'rules' => 'required|regex_match[/^([01]\d|2[0-3]):([0-5]\d)$/]',
                'errors' => [
                    'required' => 'L\'heure de fin de disponibilité est obligatoire',
                    'regex_match' => 'L\'heure doit être dans le format HH:MM',
                ]
            ],
            'options'   => [
                'rules' => 'permit_empty',
                'errors' => [],
            ]
        ];
    }
}
