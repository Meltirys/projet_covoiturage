<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJourneyRequestTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_journey_request' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'description'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'earliest_departure' => ['type' => 'VARCHAR', 'constraint' => 10],
            'latest_departure'   => ['type' => 'VARCHAR', 'constraint' => 10],
            'start'              => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'end'                => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'deletion_date'      => ['type' => 'DATE', 'null' => true],
            'id_creator'            => ['type' => 'INT', 'unsigned' => true, 'null' => true],

        ]);
        $this->forge->addPrimaryKey('id_journey_request');
        $this->forge->addForeignKey('start', 'Location', 'id_location', 'RESTRICT', 'NO ACTION');
        $this->forge->addForeignKey('end', 'Location', 'id_location', 'RESTRICT', 'NO ACTION');
        $this->forge->addForeignKey('id_creator', 'Users', 'id_user', 'CASCADE', 'SET NULL');
        $this->forge->createTable('JourneyRequest');
    }

    public function down()
    {
        $this->forge->dropTable('JourneyRequest');
    }
}
