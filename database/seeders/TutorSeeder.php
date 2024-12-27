<?php

namespace Database\Seeders;

use App\Models\Tutor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tutors = [
            [
                'name' => '*SIN ESPECIFICAR'
            ]
        ];

        foreach ($tutors as $tutor) {
            Tutor::create($tutor);
        }
    }
}
