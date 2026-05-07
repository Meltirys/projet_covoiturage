<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model 
{
    protected $table = "user";
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'birth_date',
        'gender',
        'avatar_filename',
    ];

    protected $useTimestamps = true;
}

?>