<?php

namespace Database\Seeders;

use App\Models\Coordinator;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoordinatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coordinators = [
            [
                'name' => '*SIN ESPECIFICAR'
            ]
        ];

        foreach ($coordinators as $coordinator) {
            Coordinator::create($coordinator);
        }
    }
}
