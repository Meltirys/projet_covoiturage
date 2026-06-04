<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GlobalSeeder extends Seeder
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

        //Launching the other seeders
        $this->call('UserSeeder');
        $this->call('JourneySeeder');
        $this->call('ReportSeeder');
    }
}
