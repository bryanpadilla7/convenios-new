<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sector;

class SectorSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sector::insert([
            [
                'id' => 1,
                'sector_name' => 'Patrimonio Material',
            ],
            [
                'id' =>2,
                'sector_name' => 'Artes Escénicas y Espectáculos Artísticos',
            ],
            [
                'id' => 3,
                'sector_name' => 'Artes Visuales',
            ],
            [
                'id' => 4,
                'sector_name' => 'Música',
            ],
            [
                'id' => 5,
                'sector_name' => 'Audio Visual y Radio',
            ],
            [
                'id' => 6,
                'sector_name' => 'Libros y Publicaciones',
            ],
            [
                'id' => 7,
                'sector_name' => 'Educación Cultural',
            ],
            [
                'id' => 8,
                'sector_name' => 'Diseño',
            ],
            [
                'id' => 9,
                'sector_name' => 'Patrimonio Inmaterial',
            ],
            [
                'id' => 10,
                'sector_name' => 'Creación-derechos de autor',
            ],
        ]);
    }
}
