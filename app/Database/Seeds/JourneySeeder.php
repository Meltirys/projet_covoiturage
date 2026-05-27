<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JourneySeeder extends Seeder
{
    public function run()
    {

        // 1. Récupère la ville et la location créées par UserSeeder
        $startId = $this->db->table('Location')
            ->where('address', 'GRETA de Vannes')->get()->getRow()->id_location;

        // 2. Création et insertion de Auray
        $this->db->table('City')->insert(['name' => 'Auray', 'postcode' => '56400']);
        $aurayId = $this->db->insertID();

        $this->db->table('Location')->insert([
            'address'   => 'Gare SNCF Auray',
            'latitude'  => 47.68026,
            'longitude' => -2.99939,
            'id_city'   => $aurayId,
        ]);
        $endId = $this->db->insertID();

        // 3. Track
        $this->db->table('Track')->insert([
            'geojson'  => '{"type":"LineString","coordinates":[[-2.76,47.658],[-2.981,47.667]]}',
            'distance' => 22.500,
            'duration' => '00:25:00',
        ]);
        $trackId = $this->db->insertID();

        // 4. JourneyDrive
        $this->db->table('JourneyDrive')->insert([
            'number_of_place'   => 3,
            'departure'         => '2026-06-01 16:45:00',
            'estimated_arrival' => '2026-06-01 17:10:00',
            'id_track'          => $trackId,
            'start'             => $startId,
            'end'               => $endId,
            'id_car'            => 1,
            'driver'            => 1,
        ]);
    }
}
