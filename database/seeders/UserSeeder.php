<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Jose Manuel',
                'surname' => 'Rufo Delgado',
                'email' => 'jmrufo@ideadosformacion.com',
                'password' => Hash::make('Ideados#2024#')
            ]
        ];

        foreach ($users as $user) {
            $newuser = User::create($user);
            $newuser->assignRole('super_admin');
        }
    }
}
