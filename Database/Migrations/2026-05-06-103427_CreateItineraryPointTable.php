<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateItineraryPointTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_itinerary_point' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'adress'        => ['type' => 'VARCHAR', 'constraint' => 100], 
            'latitude'      => ['type' => 'DECIMAL', 'constraint' => '10,8', 'null' => false],
            'longitude'     => ['type' => 'DECIMAL', 'constraint' => '10,8', 'null' => false],
            'id_city'       => ['type' => 'INT', 'unsigned' => true, 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id_itinerary_point');
        $this->forge->addForeignKey('id_city', 'City', 'id_city', 'RESTRICT', 'NO ACTION');
        $this->forge->createTable('ItineraryPoint');
    }

    public function down()
    {
        $this->forge->dropTable('ItineraryPoint');
    }
}
