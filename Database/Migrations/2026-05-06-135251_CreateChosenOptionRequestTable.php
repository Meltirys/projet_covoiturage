<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChosenOptionRequestTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_option' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_journey_drive' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
        ]);
        $this->forge->addPrimaryKey(['id_option', 'id_journey_drive']);
        $this->forge->addForeignKeyt('id_option', 'Option', 'id_option', 'RESTRICT', 'NO ACTION');
        $this->forge->createTable('OptionRequest');
    }

    public function down()
    {
        $this->forge->dropTable('OptionRequest');
    }
}
