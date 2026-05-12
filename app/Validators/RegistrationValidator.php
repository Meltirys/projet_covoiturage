<?php

namespace App\Validators;

use App\Validation\CustomRules;

class RegistrationValidator extends BaseValidator
{

    /**
     * List all the rules that needs to be followed in order to be valid
     * @return array The array with all the rules
     */
    protected function rules(): array
    {
        return [
            'first_name' => [
                'rules'  => 'required|min_length[3]|max_length[50]|regex_match[/^([a-zA-Z\-]*)$/]',
                'errors' => [
                    'required'   => 'Le prénom est obligatoire.',
                    'min_length' => 'Le prénom doit contenir au moins 3 caractères.',
                    'max_length' => 'Le prénom ne peut pas dépasser 50 caractères.',
                    'regex_match' => 'Veuillez ne pas utiliser de caractères spéciaux pour le prénom (seul le tiret est autorisé)'
                ]
            ],

            'last_name' => [
                'rules'  => 'required|min_length[3]|max_length[50]|regex_match[/^([a-zA-Z\-\s]*)$/]',
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
                'rules'  => 'required|valid_email|is_unique[Users.email]|max_length[255]',
                'errors' => [
                    'required'    => 'L\'email est obligatoire.',
                    'valid_email' => 'Format d\'email invalide.',
                    'is_unique'   => 'Cet email est déjà utilisé.',
                    'max_length'  => 'L\'adresse mail ne doit pas dépasser 255 caractères'
                ]
            ],

            //Regex found at https://regexpattern.com/phone-number/
            'phone' => [
                'rules'  => 'regex_match[/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/]',
                'errors' => [
                    'regex_match'   => 'Veuillez entrer un n° de téléphone français valide',
                ]
            ],

            'password' => [
                'rules'  => 'required|min_length[8]|max_length[60]',
                'errors' => [
                    'required'   => 'Le mot de passe est obligatoire.',
                    'min_length' => 'Le mot de passe doit contenir au moins 8 caractères.',
                    'max_length' => 'Le mot de passene doit pas dépasser 60 caractères.',

                ]
            ],

            'passwordconf' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'La confirmation est obligatoire.',
                    'matches'  => 'Les mots de passe ne correspondent pas.',
                ]
            ],

            'address' => [
                'rules'  => 'required|min_length[3]|max_length[100]|regex_match[/^([a-zA-Z\-\s]*)$/]',
                'errors' => [
                    'required'   => 'L\'adresse est obligatoire.',
                    'min_length' => 'L\'adresse doit contenir au moins 3 caractères.',
                    'max_length' => 'L\'adresse ne peut pas dépasser 100 caractères.',
                    'regex_match' => 'Veuillez ne pas utiliser de caractères spéciaux pour l\'adresse (seul le tiret et l\'espace sont autorisés)'

                ]
            ],

            'birth_date' => [
                'rules'  => 'required|valid_date[Y-m-d]|adultCheck',
                'errors' => [
                    'required'   => 'L\'adresse est obligatoire.',
                    'valid_date' => 'Veuillez entrer une date au bon format',
                    'adultCheck' => 'Vous devez être majeur pour vous inscrire'
                ]
            ],


            'city' => [
                'rules'  => 'required|min_length[3]|max_length[50]|regex_match[/^([a-zA-Z\-\s]*)$/]',
                'errors' => [
                    'required'   => 'Le nom de la ville est obligatoire.',
                    'min_length' => 'Le nom de la ville doit contenir au moins 3 caractères.',
                    'max_length' => 'Le nom de la ville ne peut pas dépasser 50 caractères.',
                    'regex_match' => 'Veuillez ne pas utiliser de caractères spéciaux pour le nom de la ville (seul le tiret et l\'espace sont autorisés)'

                ]
            ],

            //Regex found at https://regexpattern.com/france-postal-codes/
            'post_code' => [
                'rules'  => 'required|regex_match[/^(F-)?((2[A|B])|[0-9]{2})[0-9]{3}$/]',
                'errors' => [
                    'required'    => 'Le code postal est obligatoire.',
                    'regex_match' => 'Le format du code postal n\'est valide'
                ]
            ],
        ];
    }
}
