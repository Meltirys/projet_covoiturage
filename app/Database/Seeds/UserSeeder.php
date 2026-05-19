<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('UserPermission')->insertBatch([
            ['id_user_permission' => 1, 'user_permission_label' => 'user'],
            ['id_user_permission' => 2, 'user_permission_label' => 'admin'],
            ['id_user_permission' => 3, 'user_permission_label' => 'super-admin'],
        ]);

        $data = [
            [
                'first_name'         => 'Andrzej',
                'last_name'          => 'Sapkowski',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'andr.sapk@test.com',
                'mobile'             => '0610928752',
                'birth_date'         => '1948-06-21',
                'gender'             => 'male',
                'id_user_permission' => 1,
            ],
        ];

        $car = [
            [
                'brand' => 'FSO',
                'model' => 'Warszawa',
                'color' => 'Rouge',
                'year' => 1958,
                'number_of_seat' => 5,
                'id_user' => 1
            ]
        ];

        $this->db->table('Users')->insertBatch($data);
        $this->db->table('Car')->insertBatch($car);
    }
}
