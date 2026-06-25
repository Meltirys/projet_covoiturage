<?php

namespace App\Validators;

use App\Validation\CustomRules;

class UpdateUserInfos extends BaseValidator
{

    /**
     * List all the rules that needs to be followed in order to be valid
     * @return array The array with all the rules
     */
    protected function rules(): array
    {
        return [
            'id_user' => [
                'rules'  => 'required|integer', //This rule is needed in order for the validator to work
            ],
            'first_name' => [
                'rules'  => 'required|min_length[3]|max_length[50]|regex_match[/^[\p{L}\s\-]+$/u]',
                'errors' => [
                    'required'   => 'Le prénom est obligatoire.',
                    'min_length' => 'Le prénom doit contenir au moins 3 caractères.',
                    'max_length' => 'Le prénom ne peut pas dépasser 50 caractères.',
                    'regex_match' => 'Veuillez ne pas utiliser de caractères spéciaux pour le prénom (seul le tiret et l\espace sont autorisés)'
                ]
            ],

            'last_name' => [
                'rules'  => 'required|min_length[3]|max_length[50]|regex_match[/^[\p{L}\s\-]+$/u]',
                'errors' => [
                    'required'   => 'Le nom est obligatoire.',
                    'min_length' => 'Le nom doit contenir au moins 3 caractères.',
                    'max_length' => 'Le nom ne peut pas dépasser 50 caractères.',
                    'regex_match' => 'Veuillez ne pas utiliser de caractères spéciaux pour le nom (seul le tiret et l\'espace sont autorisés)'

                ]
            ],

            'gender' => [
                'rules' => 'required|in_list[male,female,none]',
                'errors' => [
                    'required' => 'Genre requis',
                    'in_list'  => 'Genre invalide',
                ]
            ],

            'email' => [
                'rules'  => 'required|valid_email|is_unique[Users.email,id_user,{id_user}]|max_length[255]',
                'errors' => [
                    'required'    => 'L\'email est obligatoire.',
                    'valid_email' => 'Format d\'email invalide.',
                    'is_unique'   => 'Cet email est déjà utilisé.',
                    'max_length'  => 'L\'adresse mail ne doit pas dépasser 255 caractères'
                ]
            ],

            //Regex found at https://regexpattern.com/phone-number/
            'mobile' => [
                'rules'  => 'permit_empty|regex_match[/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/]',
                'errors' => [
                    'regex_match'   => 'Veuillez entrer un n° de téléphone français valide',
                ]
            ],

            'address' => [
                'rules'  => 'required|min_length[3]|max_length[100]|regex_match[/^[\p{L}\s\d\-\',\.]+$/u]',
                'errors' => [
                    'required'   => 'L\'adresse est obligatoire.',
                    'min_length' => 'L\'adresse doit contenir au moins 3 caractères.',
                    'max_length' => 'L\'adresse ne peut pas dépasser 100 caractères.',
                    'regex_match' => 'Veuillez ne pas utiliser de caractères spéciaux pour l\'adresse (seul le tiret et l\'espace sont autorisés)'

                ]
            ],

            'birth_date' => [
                'rules'  => 'required|valid_date[Y-m-d]|is_adult|greater_than_equal_to[1901]',
                'errors' => [
                    'required'   => 'L\'adresse est obligatoire.',
                    'valid_date' => 'Veuillez entrer une date au bon format',
                    'is_adult' => 'Vous devez être majeur pour vous inscrire',
                    'greater_than_equal_to' => 'Veuillez entrer une date de naissance après 1901.'
                ]
            ],


            'city' => [
                'rules'  => 'required|min_length[3]|max_length[50]|regex_match[/^[\p{L}\s\-]+$/u]',
                'errors' => [
                    'required'   => 'Le nom de la ville est obligatoire.',
                    'min_length' => 'Le nom de la ville doit contenir au moins 3 caractères.',
                    'max_length' => 'Le nom de la ville ne peut pas dépasser 50 caractères.',
                    'regex_match' => 'Veuillez ne pas utiliser de caractères spéciaux pour le nom de la ville (seul le tiret et l\'espace sont autorisés)'

                ]
            ],

            //Regex found at https://regexpattern.com/france-postal-codes/
            'postcode' => [
                'rules'  => 'required|regex_match[/^(F-)?((2[A|B])|[0-9]{2})[0-9]{3}$/]',
                'errors' => [
                    'required'    => 'Le code postal est obligatoire.',
                    'regex_match' => 'Le format du code postal n\'est pas valide'
                ]
            ],
        ];
    }
}
