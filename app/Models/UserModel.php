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
    protected $allowedFields    = ['first_name', 'last_name', 'email', 'password', 'mobile', 'birth_date', 'gender', 'avatar_filename', 'id_user_permission', 'is_validated'];

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

    /**
     * @return array|null Returns all the user whom the validation state is not decided yet.
     */
    public function getNonValidatedUsers(): ?array
    {

        $nonValideted = $this->select('id_user, first_name, last_name, email')
            ->where('is_validated IS NULL')
            ->findAll();

        if (!$nonValideted) return null;

        return $nonValideted;
    }

    /**
     * @param int $idUser The user we want to know the status
     * 
     * @return bool|null Can be true or false, but also can be null if the status of the user has not been decided by the admin
     */
    public function getValidationStatusForUser(int $idUser): ?bool
    {
        $validationStatus = $this->select('is_validated')
            ->find($idUser);


        return $validationStatus['is_validated'] === null
            ? null
            : (bool) $validationStatus['is_validated'];
    }

    /**
     * Search in the database all the user that matches the given query. It only returns the allowed user and the user that have less permissions than the requierer.
     * @param string $query The user we search for
     * @param int $userLevel The user permission of the requierer. 
     * @param bool $getPermissions Optionnal, false by default. When setted to true, also return the permission leel of the user.
     * 
     * @return array An array that contains all the users that matches with the query. If no user matches, returns an empty array
     */
    public function searchForUserByName(string $query, int $userLevel, bool $getPermissions = false): array
    {
        //preparing the select beforehand because we it doesn't work inside the select.
        $select = "CONCAT(first_name, ' ', last_name) as name, email, id_user";

        if ($getPermissions) {
            $select .= ", id_user_permission as level";
        }

        $userList = $this->select($select)
            ->like("CONCAT(first_name, ' ', last_name)", $query)
            ->where("is_validated != 0 AND id_user_permission < " . $userLevel)
            ->findAll();

        return $userList;
    }
}
