<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            [
                'name' => '*SIN ESPECIFICAR',
                'color' => '',
                'description' => ''
            ],
            [
                'name' => 'CAE',
                'color' => '#0ee2f7',
                'description' => 'https://campus.ideadosformacion.com/'
            ],
            [
                'name' => 'CAE IDIOMAS',
                'color' => '#470fe6',
                'description' => 'https://campusidiomas.ideadosformacion.com/'
            ],
            [
                'name' => 'VÉRTICE',
                'color' => '#f05a5a',
                'description' => 'https://ideadosformacion.campusvertice.com/'
            ],
        ];

        foreach ($platforms as $pt) {
            Platform::create($pt);
        }
    }
}
