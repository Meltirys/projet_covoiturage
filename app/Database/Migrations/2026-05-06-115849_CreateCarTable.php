<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCarTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_car'         => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'brand'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'model'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'color'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'year'           => ['type' => 'SMALLINT', 'unsigned' => true],
            'number_of_seat' => ['type' => 'TINYINT',  'unsigned' => true],
            'id_user'        => ['type' => 'INT', 'unsigned' => true, 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id_car');
        $this->forge->addForeignKey('id_user', 'Users', 'id_user', 'RESTRICT', 'NO ACTION');
        $this->forge->createTable('Car');
    }

    public function down()
    {
        $this->forge->dropTable('Car');
    }
}
