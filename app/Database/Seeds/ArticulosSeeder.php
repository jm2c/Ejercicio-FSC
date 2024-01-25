<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ArticulosSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $data = [];

        for($i = 0; $i < 20; $i++)
        {
            $min = $faker->randomNumber() % 6; // [0 - 5]
            $max = $min + $faker->randomNumber() % 4 + 1; // $min + [1 - 4]

            $data[] = [
                'titulo' => $faker->sentence(),
                'palabras_clave' => $faker->words(4, true),
                'edad_minima' => $min,
                'edad_maxima' => $max,
                'imagen_portada' => $faker->imageUrl(800, 100),
                'imagen_previa' => $faker->imageUrl(150,150),
                'sintesis' => $faker->text(80),
                'contenido' => $faker->text(900)
            ];
        }

        $db = \Config\Database::connect();
        $builder = $db->table('articulos');
        $builder->insertBatch($data);
    }
}
