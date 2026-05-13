<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChosenOptionDriveTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_journey_drive'  => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'id_option'         => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addPrimaryKey(['id_journey_drive', 'id_option']);
        $this->forge->addForeignKey('id_journey_drive', 'JourneyDrive', 'id_journey_drive', 'RESTRICT', 'NO ACTION');
        $this->forge->addForeignKey('id_option', 'Option', 'id_option', 'RESTRICT', 'NO ACTION');
        $this->forge->createTable('OptionDrive');
    }

    public function down()
    {
        $this->forge->dropTable('OptionDrive');
    }
}
