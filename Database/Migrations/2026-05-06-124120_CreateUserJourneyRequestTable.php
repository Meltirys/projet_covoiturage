<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserJourneyRequestTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_journey_request' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'description'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'range_of_time'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'id_itinerary_point'    => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'id_itinerary_point_1'  => ['type' => 'INT', 'unsigned' => true, 'null' => false],

        ]);
        $this->forge->addPrimaryKey('id_journey_request');
        $this->forge->addForeignKey('id_itinerary_point', 'ItineraryPoint', 'id_itinerary_point', 'RESTRICT', 'NO ACTION');
        $this->forge->addForeignKey('id_itinerary_point_1', 'ItineraryPoint', 'id_itinerary_point', 'RESTRICT', 'NO ACTION');
        $this->forge->createTable('JourneyRequest');
    }

    public function down()
    {
        $this->forge->dropTable('JourneyRequest');
    }
}
