<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => '*IDEADOS'
            ], 
            [
                'name' => 'HÁBILON'
            ],
            [
                'name' => 'ADAMS'
            ],
            [
                'name' => 'VÉRTICE'
            ],
            [
                'name' => 'CAE'
            ],

        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
