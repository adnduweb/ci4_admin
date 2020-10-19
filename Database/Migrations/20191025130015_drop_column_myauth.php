<?php

namespace Adnduweb\Ci4Admin\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_drop_column_myauth extends Migration
{
    public function up()
    {
        $fields = [
            'uuid'         => ['type' => 'BINARY', 'constraint' => 16, 'unique' => true, 'after' => 'id'],
            'company_id'   => ['type' => 'INT', 'constraint' => 16, 'default' => 1, 'after' => 'uuid'],
            'lang'         => ['type' => 'VARCHAR',  'constraint' => 255, 'default' => 1,  'after' => 'company_id'],
            'id_country'   => ['type' => 'INT',  'constraint' => 11, 'default' => 1,  'after' => 'lang'],
            'lastname'     => ['type' => 'VARCHAR',  'constraint' => 255,  'after' => 'id_country'],
            'firstname'    => ['type' => 'VARCHAR',  'constraint' => 255,  'after' => 'lastname'],
            'fonction'     => ['type' => 'VARCHAR',  'constraint' => 255,  'after' => 'firstname'],
            'phone'        => ['type' => 'VARCHAR',  'constraint' => 255,  'after' => 'force_pass_reset'],
            'phone_mobile' => ['type' => 'VARCHAR',  'constraint' => 255,  'after' => 'phone'],
            'is_principal' => ['type' => 'INT', 'constraint' => 11,  'default' => 0,  'after' => 'phone_mobile']
        ];
        $this->forge->addColumn('users', $fields);
        //$this->forge->addForeignKey('company_id', 'companies', 'id', false, 'CASCADE');
        $fields = [
            'agent'              => ['type' => 'VARCHAR',  'constraint' => 255,  'after' => 'ip_address']
        ];
        $this->forge->addColumn('auth_logins', $fields);
        //$this->forge->addForeignKey('company_id', 'companies', 'id', false, 'CASCADE');
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('users', 'uuid');
        $this->forge->dropColumn('users', 'company_id');
        $this->forge->dropColumn('users', 'lang');
        $this->forge->dropColumn('users', 'id_country');
        $this->forge->dropColumn('users', 'lastname');
        $this->forge->dropColumn('users', 'firstname');
        $this->forge->dropColumn('users', 'fonction');
        $this->forge->dropColumn('users', 'phone');
        $this->forge->dropColumn('users', 'phone_mobile');
        $this->forge->dropColumn('users', 'is_principal');

        $this->forge->dropColumn('auth_logins', 'agent');
    }
}
