<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRequestMemberTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_request_member' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'seat_taken'         => ['type' => 'TINYINT', 'unsigned' => true, 'null' => false],
            'request_date'       => ['type' => 'DATE', 'null' => false],
            'id_journey_request' => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'id_user'            => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'is_validated'       => ['type' => 'BOOLEAN', 'null' => false, 'default' => false],
            'deletion_date'      => ['type' => 'DATE', 'null' => true]
        ]);
        $this->forge->addPrimaryKey('id_request_member');
        $this->forge->addForeignKey('id_journey_request', 'JourneyRequest', 'id_journey_request', 'CASCADE', 'NO ACTION');
        $this->forge->addForeignKey('id_user', 'Users', 'id_user', 'RESTRICT', 'NO ACTION');
        $this->forge->createTable('RequestMember');
    }

    public function down()
    {
        $this->forge->dropTable('RequestMember');
    }
}
