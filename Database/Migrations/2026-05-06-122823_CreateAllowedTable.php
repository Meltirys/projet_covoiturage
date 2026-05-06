<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAllowedTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type'      => 'INT',
                'unsigned'  => true,
                'null'      => false,
            ],
            'id_user_permission' => [
                'type'      => 'INT',
                'unsigned'  => true,
                'null'      => false,
            ],
        ]);
        $this->forge->addForeignKey('id_user', 'Users', 'id_user', 'RESTRICT', 'NO ACTION');
        $this->forge->addForeignKey('id_user_permission', 'UserPermission', 'id_user_permission', 'RESTRICT', 'NO ACTION');
        $this->forge->createTable('Allowed');
    }

    public function down()
    {
        $this->forge->dropTable('Allowed');
    }
}
