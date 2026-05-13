<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTrackTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_track'      => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'geojson'       => ['type' => 'JSON', 'null' => false],
            'distance'      => ['type' => 'DECIMAL', 'constraint' => '15,3', 'null' => false],
            'duration'      => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);
        $this->forge->addPrimaryKey('id_track');
        $this->forge->createTable('Track');
    }

    public function down()
    {
        $this->forge->dropTable('Track');
    }
}
