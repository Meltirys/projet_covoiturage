<?php

namespace App\Validators;

class ChangeRoleValidator extends BaseValidator
{
    protected function rules(): array
    {
        return [
            'id_user' => [
                'rules'  => 'required|integer|greater_than[0]|is_not_unique[Users.id_user]',
                'errors' => [
                    'required'       => 'L\'identifiant est obligatoire.',
                    'integer'        => 'L\'identifiant doit être un entier.',
                    'greater_than'   => 'L\'identifiant doit être supérieur à 0.',
                    'is_not_unique'  => 'Cet utilisateur n\'existe pas.',
                ]
            ],
            'new_role' => [
                'rules'  => 'required|integer|greater_than[0]|is_not_unique[UserPermission.id_user_permission]',
                'errors' => [
                    'required'      => 'Le rôle est obligatoire.',
                    'integer'       => 'Le rôle sélectionné est invalide.',
                    'greater_than'  => 'Le rôle sélectionné est invalide.',
                    'is_not_unique' => 'Ce rôle n\'existe pas.',
                ]
            ],
        ];
    }
}
