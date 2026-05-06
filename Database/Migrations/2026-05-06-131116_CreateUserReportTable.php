<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserReportTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_report' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'date'        => ['type' => 'DATE', 'null' => false],
            'comment'     => ['type' => 'TEXT'],
            'is_resolved' => ['type' => 'BOOLEAN', 'null' => false, 'default' => false],
            'id_user'     => ['type' => 'INT', 'null' => false, 'unsigned' => true],
            'id_user_1'   => ['type' => 'INT', 'null' => false, 'unsigned' => true],
        ]);
        $this->forge->addPrimaryKey('id_report');
        $this->forge->addForeignKey('id_user', 'Users', 'id_user', 'RESTRICT', 'NO ACTION');
        $this->forge->addForeignKey('id_user_1', 'Users', 'id_user', 'RESTRICT', 'NO ACTION');
        $this->forge->createTable('Report');
        
    }

    public function down()
    {
        $this->forge->dropTable('Report');
    }
}
