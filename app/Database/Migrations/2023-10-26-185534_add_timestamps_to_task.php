<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampsToTask extends Migration
{
    public function up()
    {
        $columns = [
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null
            ],
        ];

        $this->forge->addColumn('task', $columns);
    }

    public function down()
    {
        $this->forge->dropColumn('task', 'created_at');
        $this->forge->dropColumn('task', 'updated_at');
    }
}
