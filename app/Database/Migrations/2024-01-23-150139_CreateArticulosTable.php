<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateArticulosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'encabezado' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'cuerpo' => [
                'type' => 'TEXT'
            ],
            'imagen' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'fecha' => [
                'type' => 'TIMESTAMP'
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('articulos');
    }

    public function down()
    {
        $this->forge->dropTable('articulos', true);
    }
}
