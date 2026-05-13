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
            'description'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'range_of_time'      => ['type' => 'VARCHAR', 'constraint' => 50],
            'start'              => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'end'                => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'deletion_date'      => ['type' => 'DATE'],

        ]);
        $this->forge->addPrimaryKey('id_journey_request');
        $this->forge->addForeignKey('start', 'Location', 'id_location', 'RESTRICT', 'NO ACTION');
        $this->forge->addForeignKey('end', 'Location', 'id_location', 'RESTRICT', 'NO ACTION');
        $this->forge->createTable('JourneyRequest');
    }

    public function down()
    {
        $this->forge->dropTable('JourneyRequest');
    }
}
