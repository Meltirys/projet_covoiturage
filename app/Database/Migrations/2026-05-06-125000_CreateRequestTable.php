<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRequestTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_request' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'seat_taken'         => ['type' => 'INT'],
            'request_date'       => ['type' => 'DATE'],
            'id_journey_request' => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'id_user'            => ['type' => 'INT', 'unsigned' => true, 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id_request');
        $this->forge->addForeignKey('id_journey_request', 'JourneyRequest', 'id_journey_request', 'CASCADE', 'NO ACTION');
        $this->forge->addForeignKey('id_user', 'Users', 'id_user', 'RESTRICT', 'NO ACTION');
        $this->forge->createTable('Request');
    }

    public function down()
    {
        $this->forge->dropTable('Request');
    }
}
