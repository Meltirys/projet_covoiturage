<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOptionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_option' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'option' => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);
        $this->forge->addPrimaryKey('id_option');
        $this->forge->createTable('Option');
    }

    public function down()
    {
        $this->forge->dropTable('Option');
    }
}
