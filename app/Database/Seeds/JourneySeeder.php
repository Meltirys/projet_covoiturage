<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JourneyDriveSeeder extends Seeder
{
    public function run()
    {
        // 1. Désactiver temporairement les vérifications de clés étrangères
        $this->db->disableForeignKeyChecks();

        // 2. Création de lieux (Locations) dans un rayon de 50km maximum
        $locations = [
            // Ton adresse de référence à Vannes
            ['id_location' => 1, 'address' => '20 Rue Winston Churchill, 56000 Vannes', 'latitude' => 47.6462, 'longitude' => -2.7719],
            
            // Destinations/Départs dans le rayon de 50km
            ['id_location' => 2, 'address' => 'Gare de Lorient, 56100 Lorient', 'latitude' => 47.7533, 'longitude' => -3.3666],
            ['id_location' => 3, 'address' => 'Place de la République, 56400 Auray', 'latitude' => 47.6661, 'longitude' => -2.9845],
            ['id_location' => 4, 'address' => 'Grande Plage, 56340 Carnac', 'latitude' => 47.5702, 'longitude' => -3.0762],
            ['id_location' => 5, 'address' => 'Centre-Ville, 56800 Ploërmel', 'latitude' => 47.9312, 'longitude' => -2.3977],
            ['id_location' => 6, 'address' => 'Gare de Redon, 35600 Redon', 'latitude' => 47.6515, 'longitude' => -2.0881],
        ];
        $this->db->table('location')->ignore(true)->insertBatch($locations);

        // 3. Création des Traces (Tracks) simulées
        $tracks = [
            [
                'id_track' => 1, // Vannes <-> Lorient (~55 km par la route, 40-45 min)
                'geojson' => '{"type":"LineString","coordinates":[[-2.7719,47.6462],[-3.3666,47.7533]]}',
                'distance' => 55.4,
                'duration' => 42
            ],
            [
                'id_track' => 2, // Vannes <-> Auray (~20 km par la route, 20 min)
                'geojson' => '{"type":"LineString","coordinates":[[-2.7719,47.6462],[-2.9845,47.6661]]}',
                'distance' => 19.8,
                'duration' => 18
            ],
            [
                'id_track' => 3, // Vannes <-> Carnac (~32 km par la route, 30 min)
                'geojson' => '{"type":"LineString","coordinates":[[-2.7719,47.6462],[-3.0762,47.5702]]}',
                'distance' => 32.1,
                'duration' => 28
            ],
            [
                'id_track' => 4, // Vannes <-> Ploërmel (~48 km par la route, 35 min)
                'geojson' => '{"type":"LineString","coordinates":[[-2.7719,47.6462],[-2.3977,47.9312]]}',
                'distance' => 47.5,
                'duration' => 35
            ],
            [
                'id_track' => 5, // Vannes <-> Redon (~52 km par la route, 45 min)
                'geojson' => '{"type":"LineString","coordinates":[[-2.7719,47.6462],[-2.0881,47.6515]]}',
                'distance' => 51.2,
                'duration' => 46
            ],
        ];
        $this->db->table('track')->ignore(true)->insertBatch($tracks);

        // 4. Génération de 10 trajets (JOURNEY_DRIVE)
        // Tous ont soit l'ID 1 (Winston Churchill) en départ, soit en arrivée.
        $journeys = [
            // Aller / Retour : Lorient
            [
                'number_of_place'   => 3,
                'departure'         => date('Y-m-d H:i:s', strtotime('+1 day 07:45:00')),
                'estimated_arrival' => date('Y-m-d H:i:s', strtotime('+1 day 08:27:00')),
                'id_location_start' => 1, // Vannes
                'id_location_end'   => 2, // Lorient
                'id_track'          => 1,
                'id_car'            => 1
            ],
            [
                'number_of_place'   => 3,
                'departure'         => date('Y-m-d H:i:s', strtotime('+1 day 17:30:00')),
                'estimated_arrival' => date('Y-m-d H:i:s', strtotime('+1 day 18:12:00')),
                'id_location_start' => 2, // Lorient
                'id_location_end'   => 1, // Vannes
                'id_track'          => 1,
                'id_car'            => 1
            ],
            // Aller / Retour : Auray
            [
                'number_of_place'   => 2,
                'departure'         => date('Y-m-d H:i:s', strtotime('+2 days 08:15:00')),
                'estimated_arrival' => date('Y-m-d H:i:s', strtotime('+2 days 08:33:00')),
                'id_location_start' => 1, // Vannes
                'id_location_end'   => 3, // Auray
                'id_track'          => 2,
                'id_car'            => 2
            ],
            [
                'number_of_place'   => 4,
                'departure'         => date('Y-m-d H:i:s', strtotime('+2 days 12:00:00')),
                'estimated_arrival' => date('Y-m-d H:i:s', strtotime('+2 days 12:18:00')),
                'id_location_start' => 3, // Auray
                'id_location_end'   => 1, // Vannes
                'id_track'          => 2,
                'id_car'            => 2
            ],
            // Aller / Retour : Carnac (Plage le week-end)
            [
                'number_of_place'   => 4,
                'departure'         => date('Y-m-d H:i:s', strtotime('+3 days 14:00:00')),
                'estimated_arrival' => date('Y-m-d H:i:s', strtotime('+3 days 14:28:00')),
                'id_location_start' => 1, // Vannes
                'id_location_end'   => 4, // Carnac
                'id_track'          => 3,
                'id_car'            => 1
            ],
            [
                'number_of_place'   => 1,
                'departure'         => date('Y-m-d H:i:s', strtotime('+3 days 19:00:00')),
                'estimated_arrival' => date('Y-m-d H:i:s', strtotime('+3 days 19:28:00')),
                'id_location_start' => 4, // Carnac
                'id_location_end'   => 1, // Vannes
                'id_track'          => 3,
                'id_car'            => 1
            ],
            // Aller / Retour : Ploërmel
            [
                'number_of_place'   => 3,
                'departure'         => date('Y-m-d H:i:s', strtotime('+4 days 07:30:00')),
                'estimated_arrival' => date('Y-m-d H:i:s', strtotime('+4 days 08:05:00')),
                'id_location_start' => 1, // Vannes
                'id_location_end'   => 5, // Ploërmel
                'id_track'          => 4,
                'id_car'            => 3
            ],
            [
                'number_of_place'   => 2,
                'departure'         => date('Y-m-d H:i:s', strtotime('+4 days 16:45:00')),
                'estimated_arrival' => date('Y-m-d H:i:s', strtotime('+4 days 17:20:00')),
                'id_location_start' => 5, // Ploërmel
                'id_location_end'   => 1, // Vannes
                'id_track'          => 4,
                'id_car'            => 3
            ],
            // Aller / Retour : Redon
            [
                'number_of_place'   => 3,
                'departure'         => date('Y-m-d H:i:s', strtotime('+5 days 08:00:00')),
                'estimated_arrival' => date('Y-m-d H:i:s', strtotime('+5 days 08:46:00')),
                'id_location_start' => 6, // Redon
                'id_location_end'   => 1, // Vannes
                'id_track'          => 5,
                'id_car'            => 2
            ],
            [
                'number_of_place'   => 3,
                'departure'         => date('Y-m-d H:i:s', strtotime('+5 days 18:00:00')),
                'estimated_arrival' => date('Y-m-d H:i:s', strtotime('+5 days 18:46:00')),
                'id_location_start' => 1, // Vannes
                'id_location_end'   => 6, // Redon
                'id_track'          => 5,
                'id_car'            => 2
            ],
        ];

        // Insertion des trajets
        $this->db->table('journey_drive')->insertBatch($journeys);

        // Réactiver les vérifications de clés étrangères
        $this->db->enableForeignKeyChecks();

        echo "Seeder JourneyDrive (Zone Vannes 50km) exécuté avec succès !\n";
    }
}