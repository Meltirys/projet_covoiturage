<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCityTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_city'   => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'postcode'  => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id_city');
        $this->forge->addUniqueKey(['city_name', 'postcode']);
        $this->forge->createTable('City');
    }

    public function down()
    {
        $this->forge->dropTable('City');
    }
}
