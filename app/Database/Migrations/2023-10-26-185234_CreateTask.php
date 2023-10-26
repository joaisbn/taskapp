<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTask extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');

        $this->forge->createTable('task');
    }

    public function down()
    {
        $this->forge->dropTable('task');
    }
}
