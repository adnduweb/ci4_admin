<?php

namespace Adnduweb\Admin\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_drop_column_auth_groups extends Migration
{
    public function up()
    {
        $fields = [
            'login_destination' => ['type' => 'VARCHAR', 'constraint' => 255, 'after' => 'description'],
            'is_hide'           => ['type' => 'INT', 'constraint' => 11, 'default' => 0, 'after' => 'login_destination'],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
        ];
        $this->forge->addColumn('auth_groups', $fields);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('auth_groups', 'login_destination');
        $this->forge->dropColumn('auth_groups', 'is_hide');
        $this->forge->dropColumn('auth_groups', 'created_at');
        $this->forge->dropColumn('auth_groups', 'updated_at');
        $this->forge->dropColumn('auth_groups', 'deleted_at');
    }
}
