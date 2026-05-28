<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJourneyDriveTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_journey_drive'   => [
                'type'            => 'INT',
                'null'            => false,
                'unsigned'        => true,
                'auto_increment'  => true,
            ],
            'number_of_place'    => ['type' => 'INT', 'null' => false, 'unsigned' => true],
            'departure'          => ['type' => 'DATETIME', 'null' => false],
            'estimated_arrival'  => ['type' => 'DATETIME', 'null' => false],
            'deletion_date'      => ['type' => 'DATE', 'null' => true],
            'id_track'           => ['type' => 'INT', 'null' => true, 'unsigned' => true],
            'start'              => ['type' => 'INT', 'null' => false, 'unsigned' => true],
            'end'                => ['type' => 'INT', 'null' => false, 'unsigned' => true],
            'id_car'             => ['type' => 'INT', 'null' => false, 'unsigned' => true],
            'driver'             => ['type' => 'INT', 'null' => false, 'unsigned' => true]
        ]);

        $this->forge->addPrimaryKey('id_journey_drive');
        $this->forge->addForeignKey('id_track', 'Track', 'id_track', 'CASCADE', 'NO ACTION');
        $this->forge->addForeignKey('start', 'Location', 'id_location', 'RESTRICT', 'NO ACTION');
        $this->forge->addForeignKey('end', 'Location', 'id_location', 'RESTRICT', 'NO ACTION');
        $this->forge->addForeignKey('id_car', 'Car', 'id_car', 'RESTRICT', 'NO ACTION');
        $this->forge->addForeignKey('driver', 'Users', 'id_user', 'RESTRICT', 'NO ACTION');
        $this->forge->createTable('JourneyDrive');
    }

    public function down()
    {
        $this->forge->dropTable('JourneyDrive');
    }
}
