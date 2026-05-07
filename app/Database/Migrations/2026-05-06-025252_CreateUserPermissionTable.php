<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserPermissionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user_permission' => [
                'type'              => 'INT', 
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'user_permission_label' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id_user_permission');
        $this->forge->createTable('UserPermission');
    }

    public function down()
    {
        $this->forge->dropTable('UserPermission');
    }
}
