<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DbSeeder extends Seeder
{
    public function run()
    {
        $this->call('ArticulosSeeder');
        $this->call('UsuariosSeeder');
    }
}
