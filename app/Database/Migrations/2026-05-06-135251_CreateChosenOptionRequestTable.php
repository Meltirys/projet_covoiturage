<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChosenOptionRequestTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_option'          => [
                'type'            => 'INT',
                'unsigned'        => true,
            ],
            'id_journey_request' => [
                'type'            => 'INT',
                'unsigned'        => true,
            ],
        ]);
        $this->forge->addPrimaryKey(['id_option', 'id_journey_request']);
        $this->forge->addForeignKey('id_option', 'Option', 'id_option', 'RESTRICT', 'NO ACTION');
        $this->forge->addForeignKey('id_journey_request', 'JourneyRequest', 'id_journey_request', 'RESTRICT', 'NO ACTION');
        $this->forge->createTable('OptionRequest');
    }

    public function down()
    {
        $this->forge->dropTable('OptionRequest');
    }
}
