<?php

namespace App\Validators;

class AvatarValidator extends BaseValidator
{

    /**
     * List all the rules that needs to be followed in order to be valid
     * @return array The array with all the rules
     */
    protected function rules(): array
    {
        return [
            'avatar' => [
                'rules' => [
                    'is_image[avatar]',      // C'est bien une image
                    'mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]', // Types autorisés
                    'max_size[avatar,2048]', // Taille max en Ko (ici 2Mo)
                    'max_dims[avatar,1920,1080]', // Dimensions max en pixels
                ],
                'errors' => [
                    'is_image'  => 'Le fichier doit être une image',
                    'mime_in'   => 'Format accepté : jpg, jpeg, png, webp',
                    'max_size'  => 'L\'image ne doit pas dépasser 2Mo',
                    'max_dims'  => 'L\'image ne doit pas dépasser 1920x1080 pixels',
                ]
            ]
        ];
    }
}
