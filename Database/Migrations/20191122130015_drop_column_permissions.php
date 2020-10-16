<?php

namespace Adnduweb\Admin\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_drop_column_permissisons extends Migration
{
    public function up()
    {
        $fields = [
            'is_natif'              => ['type' => 'INT', 'constraint' => 11, 'default' => 0, 'after' => 'description']
        ];
        $this->forge->addColumn('auth_permissions', $fields);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('auth_permissions', 'is_natif');
    }
}
