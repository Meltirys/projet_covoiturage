<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'Users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['first_name', 'last_name', 'email', 'password', 'mobile', 'birth_date', 'gender', 'avatar_filename', 'id_user_permission'];

    protected bool $allowEmptyInserts = false;
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
    protected $validationRules      = [];
    protected $validationMessages   = [];
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
     * Automatic "beforeInsert" function. Converts the user's password into a secure hash.
     * 
     * @param array $data An array containing user data for insertion
     * 
     * @return array $data The user's data, now with a securely hashed password
     */
    protected function hashPassword(array $data)
    {
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }

    /**
     * @param int $idUser The user id of whom we want the name
     * 
     * @return string|null The name in format first_name." ".last_name or null if the user is not found
     */
    public function getUserName(int $idUser): ?string
    {
        $user = $this->select('first_name, last_name')
            ->where($this->primaryKey, $idUser)
            ->first();

        if (!$user) return null;

        return $user['first_name'] . " " . $user['last_name'];
    }

    public function getUserCars(int $id) : array{
        $cars = $this->select()
                    ->where()
    }
}
