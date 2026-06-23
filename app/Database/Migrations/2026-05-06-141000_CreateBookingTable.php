<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_booking'          => [
                'type'              => 'INT',
                'unsigned'          => true,
                'null'              => false,
                'auto_increment'    => true,
            ],
            'booking_date'        => ['type' => 'DATE', 'null' => false],
            'seat_taken'          => ['type' => 'TINYINT', 'unsigned' => true, 'null' => false],
            'is_validated'        => ['type' => 'BOOLEAN', 'null' => false, 'default' => false],
            'deletion_date'       => ['type' => 'DATE', 'null' => true],
            'id_user'             => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'id_journey_drive'    => ['type' => 'INT', 'unsigned' => true, 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id_booking');
        $this->forge->addForeignKey('id_user', 'Users', 'id_user', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('id_journey_drive', 'JourneyDrive', 'id_journey_drive', 'CASCADE', 'NO ACTION');
        $this->forge->createTable('Booking');
    }

    public function down()
    {
        $this->forge->dropTable('Booking');
    }
}
