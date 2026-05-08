<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Validation\CustomRules;

class UserModel extends Model
{
    protected $table            = 'Users';
    /*protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;*/
    protected $allowedFields    = ['first_name', 'last_name', 'email', 'password', 'mobile', 'birth_date', 'gender', 'avatar_filename', 'id_user_permission'];

    /*protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'register' => [
            'first_name' => 'required|min_length[2]|max_length(100)',
            'last_name' => 'required|min_length[2]|max_length(100)',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[255]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]).+$/]',
            'mobile' => 'permit_empty|regex_match[/^(?:(?:\+33|0)[67])(?:[\s.-]?\d{2}){4}$/]',
            'birth_date' => 'required|valid_date[Y-m-d]|adultCheck',
            'gender' => 'required|in_list[homme,femme,autre]',
        ]
    ];

    protected $validationMessages   = [
        'first_name' => [
            'required' => 'Prénom requis',
            'min_length' => 'Le prénom doit faire plus de 2 caractères',
            'max_length' => 'Le prénom doit faire moins de 100 caractères',
        ],
        'last_name' => [
            'required' => 'Nom de famille requis',
            'min_length' => 'Le nom de famille doit faire plus de 2 caractères',
            'max_length' => 'Le nom de famille doit faire moins de 100 caractères',
        ],
        'email' => [
            'required' => "Adresse email requise",
            'valid_email' => "Adresse email invalide",
            'is_unique' => "Cette adresse est déjà utilisée",
        ],
        'password' => [
            'required'   => 'Un mot de passe est requis',
            'min_length' => 'Le mot de passe doit faire 8 caractères minimum',
            'max_length' => 'Le mot de passe ne doit pas dépasser 255 caractères',
            'regex_match' => 'Le mot de passe doit contenir au moins une majuscule, minuscule, un nombre et un caractère spécial',
        ],
        'mobile' => [
            'regex_match' => 'Numéro de téléphone invalide',
        ],
        'birth_date' => [
            'required' => 'Date de naissance requise',
            'valid_date' => 'Date de naissance invalide (doit être format Y-m-d)',

        ],
        'gender' => [
            'required' => 'Genre requis',
            'in_list' => 'Genre invalide',
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Converts the user's password into a secure hash
     */
    protected function hashPassword(array $data)
    {
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }
}
