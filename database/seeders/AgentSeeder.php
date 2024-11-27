<?php

namespace Database\Seeders;

use App\Models\Agent;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agents = [
            [
                'name' => '*IDEADOS'
            ],
            [
                'name' => 'ANA ISABEL CALVO'
            ],
            [
                'name' => 'VANESA SÁNCHEZ'
            ],
            [
                'name' => 'LUIS GARRIDO'
            ],
            [
                'name' => 'NATIVIDAD DELGADO'
            ],
        ];

        foreach ($agents as $agent) {
            Agent::create($agent);
        }
    }
}
