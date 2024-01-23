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
            'titulo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'palabras_clave' => [
                'type'       => 'TEXT',
                'constraint' => 200,
                'null'       => true
            ],
            'edad_minima' => [
                'type'       => 'INT',
                'constraint' => 1,
                'unsigned'   => true,
                'null'       => true
            ],
            'edad_maxima' => [
                'type'       => 'INT',
                'constraint' => 1,
                'unsigned'   => true,
                'null'       => true
            ],
            'imagen_portada' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'imagen_previa' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'sintesis' => [
                'type'       => 'VARCHAR',
                'constraint' => 200
            ],
            'contenido' => [
                'type' => 'TEXT'
            ],
            'fecha_de_creacion TIMESTAMP DEFAULT NOW()',
            'fecha_de_modificacion TIMESTAMP DEFAULT NOW() ON UPDATE NOW()'
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('articulos');
    }

    public function down()
    {
        $this->forge->dropTable('articulos', true);
    }
}
