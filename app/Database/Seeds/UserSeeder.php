<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {

        $this->db->query('SET FOREIGN_KEY_CHECKS = 0'); //Temporarly desactivating que the foreign keys

        // We empty the tables before inserting the new values
        $this->db->table('Car')->truncate();
        $this->db->table('Users')->truncate();
        $this->db->table('UserPermission')->truncate();
        $this->db->table('Location')->truncate();
        $this->db->table('City')->truncate();

        $this->db->query('SET FOREIGN_KEY_CHECKS = 1'); //Reactivating the foreign keys

        $this->db->table('City')->insert(['name' => 'Vannes', 'postcode' => '56000']);
        $cityId = $this->db->insertID();
        $this->db->table('Location')->insert([
            'address'   => 'GRETA de Vannes',
            'latitude'  => 47.64829,
            'longitude' => -2.77503,
            'id_city'   => $cityId,
        ]);

        $this->db->table('UserPermission')->insertBatch([
            ['id_user_permission' => 1, 'user_permission_label' => 'user'],
            ['id_user_permission' => 2, 'user_permission_label' => 'admin'],
            ['id_user_permission' => 3, 'user_permission_label' => 'super-admin'],
        ]);

        $data = [
            [
                'id_user'            => 1,
                'first_name'         => 'Andrzej',
                'last_name'          => 'Sapkowski',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'andr.sapk@test.com',
                'mobile'             => '0610928752',
                'birth_date'         => '1948-06-21',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated' => true,
                'id_location' => 1
            ],
            [
                'id_user'            => 2,
                'first_name'         => 'Add',
                'last_name'          => 'Mine',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'add.mine@admin.fr',
                'mobile'             => '',
                'birth_date'         => '1948-06-21',
                'gender'             => 'male',
                'id_user_permission' => 2,
                'is_validated' => true,
                'id_location' => 1
            ],
            [
                'id_user'            => 5,
                'first_name'         => 'SupAdd',
                'last_name'          => 'Mine',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'supadd.mine@admin.fr',
                'mobile'             => '',
                'birth_date'         => '1948-06-21',
                'gender'             => 'male',
                'id_user_permission' => 3,
                'is_validated' => true,
                'id_location' => 1
            ],
            [
                'id_user'            => 3,
                'first_name'         => 'Refused',
                'last_name'          => 'User',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'refused@user.fr',
                'mobile'             => '',
                'birth_date'         => '1948-06-21',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated' => false,
                'id_location' => 1
            ],
            [
                'id_user'            => 6,
                'first_name'         => 'Accepted',
                'last_name'          => 'User',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'accepted@user.fr',
                'mobile'             => '',
                'birth_date'         => '1948-06-21',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated' => true,
                'id_location' => 1
            ],
            [
                'id_user'            => 7,
                'first_name'         => 'ToDelete',
                'last_name'          => 'User',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'deleted@user.fr',
                'mobile'             => '',
                'birth_date'         => '1948-06-21',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated' => true,
                'id_location' => 1
            ],
            [
                'id_user'            => 4,
                'first_name'         => 'Waiting',
                'last_name'          => 'User',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'waiting@user.fr',
                'mobile'             => '',
                'birth_date'         => '1948-06-21',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated'       => null,
                'id_location' => 1
            ],
            [
                'id_user'            => 8,
                'first_name'         => 'Accepted',
                'last_name'          => 'Martin',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'accepted.martin@user.fr',
                'mobile'             => '',
                'birth_date'         => '1990-03-15',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated'       => true,
                'id_location'        => 1
            ],
            [
                'id_user'            => 9,
                'first_name'         => 'Accepted',
                'last_name'          => 'Dupont',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'accepted.dupont@user.fr',
                'mobile'             => '',
                'birth_date'         => '1985-07-22',
                'gender'             => 'female',
                'id_user_permission' => 1,
                'is_validated'       => true,
                'id_location'        => 1
            ],
            [
                'id_user'            => 10,
                'first_name'         => 'Accepted',
                'last_name'          => 'Bernard',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'accepted.bernard@user.fr',
                'mobile'             => '',
                'birth_date'         => '1992-11-08',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated'       => true,
                'id_location'        => 1
            ],
            [
                'id_user'            => 11,
                'first_name'         => 'Accepted',
                'last_name'          => 'Petit',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'accepted.petit@user.fr',
                'mobile'             => '',
                'birth_date'         => '1988-04-30',
                'gender'             => 'female',
                'id_user_permission' => 1,
                'is_validated'       => true,
                'id_location'        => 1
            ],
            [
                'id_user'            => 12,
                'first_name'         => 'Accepted',
                'last_name'          => 'Robert',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'accepted.robert@user.fr',
                'mobile'             => '',
                'birth_date'         => '1995-09-14',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated'       => true,
                'id_location'        => 1
            ],
            [
                'id_user'            => 13,
                'first_name'         => 'Accepted',
                'last_name'          => 'Moreau',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'accepted.moreau@user.fr',
                'mobile'             => '',
                'birth_date'         => '1991-01-25',
                'gender'             => 'female',
                'id_user_permission' => 1,
                'is_validated'       => true,
                'id_location'        => 1
            ],
            [
                'id_user'            => 14,
                'first_name'         => 'Accepted',
                'last_name'          => 'Simon',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'accepted.simon@user.fr',
                'mobile'             => '',
                'birth_date'         => '1987-06-03',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated'       => true,
                'id_location'        => 1
            ],
            [
                'id_user'            => 15,
                'first_name'         => 'Accepted',
                'last_name'          => 'Laurent',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'accepted.laurent@user.fr',
                'mobile'             => '',
                'birth_date'         => '1993-12-17',
                'gender'             => 'female',
                'id_user_permission' => 1,
                'is_validated'       => true,
                'id_location'        => 1
            ],
            [
                'id_user'            => 16,
                'first_name'         => 'Accepted',
                'last_name'          => 'Leroy',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'accepted.leroy@user.fr',
                'mobile'             => '',
                'birth_date'         => '1989-08-09',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated'       => true,
                'id_location'        => 1
            ],
            [
                'id_user'            => 17,
                'first_name'         => 'Accepted',
                'last_name'          => 'Roux',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'accepted.roux@user.fr',
                'mobile'             => '',
                'birth_date'         => '1994-05-21',
                'gender'             => 'female',
                'id_user_permission' => 1,
                'is_validated'       => true,
                'id_location'        => 1
            ],
            [
                'id_user'            => 18,
                'first_name'         => 'Accepted',
                'last_name'          => 'David',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'accepted.david@user.fr',
                'mobile'             => '',
                'birth_date'         => '1986-02-11',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated'       => true,
                'id_location'        => 1
            ],

            // Waiting users (is_validated = null)
            [
                'id_user'            => 19,
                'first_name'         => 'Waiting',
                'last_name'          => 'Garcia',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'waiting.garcia@user.fr',
                'mobile'             => '',
                'birth_date'         => '1990-03-15',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated'       => null,
                'id_location'        => 1
            ],
            [
                'id_user'            => 20,
                'first_name'         => 'Waiting',
                'last_name'          => 'Martinez',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'waiting.martinez@user.fr',
                'mobile'             => '',
                'birth_date'         => '1985-07-22',
                'gender'             => 'female',
                'id_user_permission' => 1,
                'is_validated'       => null,
                'id_location'        => 1
            ],
            [
                'id_user'            => 21,
                'first_name'         => 'Waiting',
                'last_name'          => 'Gonzalez',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'waiting.gonzalez@user.fr',
                'mobile'             => '',
                'birth_date'         => '1992-11-08',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated'       => null,
                'id_location'        => 1
            ],
            [
                'id_user'            => 22,
                'first_name'         => 'Waiting',
                'last_name'          => 'Lopez',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'waiting.lopez@user.fr',
                'mobile'             => '',
                'birth_date'         => '1988-04-30',
                'gender'             => 'female',
                'id_user_permission' => 1,
                'is_validated'       => null,
                'id_location'        => 1
            ],
            [
                'id_user'            => 23,
                'first_name'         => 'Waiting',
                'last_name'          => 'Hernandez',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'waiting.hernandez@user.fr',
                'mobile'             => '',
                'birth_date'         => '1995-09-14',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated'       => null,
                'id_location'        => 1
            ],
            [
                'id_user'            => 24,
                'first_name'         => 'Waiting',
                'last_name'          => 'Wilson',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'waiting.wilson@user.fr',
                'mobile'             => '',
                'birth_date'         => '1991-01-25',
                'gender'             => 'female',
                'id_user_permission' => 1,
                'is_validated'       => null,
                'id_location'        => 1
            ],
            [
                'id_user'            => 25,
                'first_name'         => 'Waiting',
                'last_name'          => 'Anderson',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'waiting.anderson@user.fr',
                'mobile'             => '',
                'birth_date'         => '1987-06-03',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated'       => null,
                'id_location'        => 1
            ],
            [
                'id_user'            => 26,
                'first_name'         => 'Waiting',
                'last_name'          => 'Thomas',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'waiting.thomas@user.fr',
                'mobile'             => '',
                'birth_date'         => '1993-12-17',
                'gender'             => 'female',
                'id_user_permission' => 1,
                'is_validated'       => null,
                'id_location'        => 1
            ],
            [
                'id_user'            => 27,
                'first_name'         => 'Waiting',
                'last_name'          => 'Jackson',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'waiting.jackson@user.fr',
                'mobile'             => '',
                'birth_date'         => '1989-08-09',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated'       => null,
                'id_location'        => 1
            ],
            [
                'id_user'            => 28,
                'first_name'         => 'Waiting',
                'last_name'          => 'White',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'waiting.white@user.fr',
                'mobile'             => '',
                'birth_date'         => '1994-05-21',
                'gender'             => 'female',
                'id_user_permission' => 1,
                'is_validated'       => null,
                'id_location'        => 1
            ],
            [
                'id_user'            => 29,
                'first_name'         => 'Waiting',
                'last_name'          => 'Harris',
                'password'           => password_hash('password', PASSWORD_DEFAULT),
                'email'              => 'waiting.harris@user.fr',
                'mobile'             => '',
                'birth_date'         => '1986-02-11',
                'gender'             => 'male',
                'id_user_permission' => 1,
                'is_validated'       => null,
                'id_location'        => 1
            ]
        ];

        $car = [
            [
                'brand' => 'FSO',
                'model' => 'Warszawa',
                'color' => 'Rouge',
                'year' => 1958,
                'number_of_seat' => 5,
                'id_user' => 1
            ],
            [
                'brand' => 'FSO',
                'model' => 'Warszawa',
                'color' => 'Rouge',
                'year' => 1958,
                'number_of_seat' => 5,
                'id_user' => 2
            ],

        ];

        $this->db->table('Users')->insertBatch($data);
        $this->db->table('Car')->insertBatch($car);
    }
}
