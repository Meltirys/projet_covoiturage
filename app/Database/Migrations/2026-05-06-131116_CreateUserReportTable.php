<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUserReportTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_report'   => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'date'        => ['type' => 'DATETIME', 'null' => false, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'comment'     => ['type' => 'TEXT'],
            'is_resolved' => ['type' => 'BOOLEAN', 'null' => false, 'default' => false],
            'reporter'    => ['type' => 'INT', 'null' => true, 'unsigned' => true],
            'reported'    => ['type' => 'INT', 'null' => true, 'unsigned' => true],
        ]);
        $this->forge->addPrimaryKey('id_report');
        $this->forge->addForeignKey('reporter', 'Users', 'id_user', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('reported', 'Users', 'id_user', 'CASCADE', 'SET NULL');
        $this->forge->createTable('Report');
    }

    public function down()
    {
        $this->forge->dropTable('Report');
    }
}
