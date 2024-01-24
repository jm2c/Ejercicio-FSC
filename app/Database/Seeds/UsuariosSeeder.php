<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        /**
         * Datos solo para hacer la prueba, en un sistema real se crearía un modelo Usuario
         * y se encriptaría cada contraseña
         */
        $user = [
            'nickname' => 'juan',
            'password' => '1234'
        ];

        $this->db->table('usuarios')->insert($user);
    }
}
