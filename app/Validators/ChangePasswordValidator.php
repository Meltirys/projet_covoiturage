<?php

namespace App\Validators;

use App\Validation\CustomRules;

class ChangePasswordValidator extends BaseValidator
{

    /**
     * List all the rules that needs to be followed in order to be valid
     * @return array The array with all the rules
     */
    protected function rules(): array
    {
        return [
            'old_password' => [
                'rules' => 'is_old_password',
                'errors' => [
                    'is_old_password' => 'Le mot de passe entré n\'est pas le bon'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[8]|max_length[60]|differs[old_password]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]).+$/]',
                'errors' => [
                    'required'   => 'Le mot de passe est obligatoire.',
                    'min_length' => 'Le mot de passe doit contenir au moins 8 caractères.',
                    'max_length' => 'Le mot de passene doit pas dépasser 60 caractères.',
                    'differs' => 'Le nouveau mot de passe ne doit pas être le même que l\'ancien',
                    'regex_match' => 'Le mot de passe doit contenir au moins une majuscule, minuscule, un nombre et un caractère spécial',

                ]
            ],

            'password_conf' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'La confirmation est obligatoire.',
                    'matches'  => 'Les mots de passe ne correspondent pas.',
                ]
            ],
        ];
    }
}
