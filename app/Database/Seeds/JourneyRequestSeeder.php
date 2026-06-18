<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JourneyRequestSeeder extends Seeder
{
    public function run()
    {
        $this->db->disableForeignKeyChecks();

        /**
         * 1. JOURNEY REQUESTS
         */
        $journeys = [
            [
                'id_journey_request' => 1,
                'description'        => 'Trajet Vannes → Lorient soir',
                'range_of_time'      => '17:00 - 18:30',
                'start'              => 1, // Greta Vannes
                'end'                => 2, // Gare de Lorient
                'id_creator'         => 1,
            ],
            [
                'id_journey_request' => 2,
                'description'        => 'Auray → Vannes quotidien',
                'range_of_time'      => '07:30 - 08:30',
                'start'              => 3, // Auray
                'end'                => 1, // Greta Vannes
                'id_creator'         => 2,
            ],
            [
                'id_journey_request' => 3,
                'description'        => 'Carnac → Ploërmel retour weekend',
                'range_of_time'      => '18:00 - 20:00',
                'start'              => 4, // Carnac
                'end'                => 5, // Ploërmel
                'id_creator'         => 5,
            ],
        ];

        $this->db->table('JourneyRequest')->insertBatch($journeys);

        /**
         * 2. REQUEST MEMBERS
         * Users joining journeys
         */
        $members = [
            [
                'id_request_member'  => 1,
                'seat_taken'         => 1,
                'request_date'       => '2026-06-20',
                'id_journey_request' => 1,
                'id_user'            => 8,
                'is_validated'       => 1,
            ],
            [
                'id_request_member'  => 2,
                'seat_taken'         => 2,
                'request_date'       => '2026-06-21',
                'id_journey_request' => 1,
                'id_user'            => 9,
                'is_validated'       => 0,
            ],
            [
                'id_request_member'  => 3,
                'seat_taken'         => 1,
                'request_date'       => '2026-06-20',
                'id_journey_request' => 1,
                'id_user'            => 1,
                'is_validated'       => 1,
            ],
            [
                'id_request_member'  => 4,
                'seat_taken'         => 1,
                'request_date'       => '2026-06-22',
                'id_journey_request' => 2,
                'id_user'            => 13,
                'is_validated'       => 1,
            ],
            [
                'id_request_member'  => 5,
                'seat_taken'         => 1,
                'request_date'       => '2026-06-22',
                'id_journey_request' => 2,
                'id_user'            => 2,
                'is_validated'       => 1,
            ],
            [
                'id_request_member'  => 6,
                'seat_taken'         => 1,
                'request_date'       => '2026-06-23',
                'id_journey_request' => 3,
                'id_user'            => 15,
                'is_validated'       => 1,
            ],
            [
                'id_request_member'  => 7,
                'seat_taken'         => 1,
                'request_date'       => '2026-06-23',
                'id_journey_request' => 3,
                'id_user'            => 5,
                'is_validated'       => 1,
            ],
        ];

        $this->db->table('RequestMember')->insertBatch($members);

        $this->db->enableForeignKeyChecks();
    }
}
