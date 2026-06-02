<?php

namespace App\Validators;

use App\Validation\CustomRules;

class ReportValidator extends BaseValidator
{
    /**
     * List all the rules that needs to be followed in order to be valid
     * @return array The array with all the rules
     */
    protected function rules(): array
    {
        return [
            'reporter' => [
                'rules' => 'required|integer',
            ],
            'reported' => [
                'rules'  => 'required|integer|is_not_unique[Users.id_user]',
                'errors' => [
                    'required'   => 'Un utilisateur doit être spécifié',
                    'integer' => 'L\'utilisateur reporté doit être un nombre',
                    'is_not_unique' => 'L\'utilisateur reporté doit exister'

                ]
            ],
            'comment' => [
                'rules'  => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required'   => 'Un utilisateur doit être spécifié',
                    'min_length' => 'Le commentaire doit contenir au moins 3 caractères',
                    'max_length' => 'Le commentaire doit contenir au plus 255 caractères'

                ]
            ],

        ];
    }
}
