<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type'            => 'INT',
                'unsigned'        => true,
                'null'            => false,
                'auto_increment'  => true,
            ],
            'first_name'      => ['type' => 'VARCHAR', 'null' => false, 'constraint' => 50], 
            'last_name'       => ['type' => 'VARCHAR', 'null' => false, 'constraint' => 50],
            'password'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'email'           => ['type' => 'VARCHAR', 'null' => false, 'constraint' => 255, 'unique' => true],
            'mobile'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'birth_date'      => ['type' => 'DATE', 'null' => false],
            'gender'          => ['type' => 'VARCHAR', 'null' => false, 'constraint' => 50],
            'avatar_filename' => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
        ]);
        $this->forge->addPrimaryKey('id_user');
        $this->forge->createTable('Users');
    }

    public function down()
    {
        $this->forge->dropTable('Users');
    }
}


