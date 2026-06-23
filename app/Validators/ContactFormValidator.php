<?php

namespace App\Validators;

class ContactFormValidator extends BaseValidator
{

    protected function rules(): array
    {
        return [
            'first_name' => [
                'rules' => 'min_length[3]|max_length[50]',
                'errors' => [
                    'min_length' => 'Votre nom doit contenir au moins 3 caractères',
                    'max_length' => 'Votre nom doit contenir au maximum 50 caractères',

                ]
            ],
            'last_name' => [
                'rules' => 'min_length[3]|max_length[50]',
                'errors' => [
                    'min_length' => 'Votre prénom doit contenir au moins 3 caractères',
                    'max_length' => 'Votre prénom doit contenir au maximum 50 caractères',

                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|max_length[255]',
                'errors' => [
                    'required'    => 'L\'email est obligatoire.',
                    'valid_email' => 'Format d\'email invalide.',
                    'max_length'  => 'L\'adresse mail ne doit pas dépasser 255 caractères'
                ]
            ],
            'motif' => [
                'rules'  => 'in_list[information,problem,account,traject,other]',
                'errors' => [
                    'in_list'    => 'Le motif sélectionné n\'est pas disponible.',
                ]
            ],
            'message' => [
                'rules' => 'min_length[3]|max_length[1000]',
                'errors' => [
                    'min_length' => 'Votre message doit contenir au moins 3 caractères',
                    'max_length' => 'Votre message doit contenir au maximum 1000 caractères',

                ]
            ],


        ];
    }
}
