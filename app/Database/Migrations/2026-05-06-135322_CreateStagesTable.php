<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_journey_drive' => [
                'type'           => 'INT',
                'null'           => false,
                'unsigned'       => true,
            ],
            'id_location' => [
                'type'          => 'INT',
                'null'          => false,
                'unsigned'      => true
            ],

            'order' => ['type' => 'INT'],

        ]);
        $this->forge->addForeignKey('id_journey_drive', 'JourneyDrive', 'id_journey_drive', 'RESTRICT', 'NO ACTION');
        $this->forge->addForeignKey('id_location', 'Location', 'id_location', 'RESTRICT', 'NO ACTION');
        $this->forge->createTable('Stages');
    }

    public function down()
    {
        $this->forge->dropTable('Stages');    }
}
