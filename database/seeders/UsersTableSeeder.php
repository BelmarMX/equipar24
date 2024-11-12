<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
                'name'              => 'Belmar Alberto'
            ,   'email'             => 'dispersion.mx@gmail.com'
            ,   'email_verified_at' => now()
            ,   'password'          => Hash::make('secret')
            ,   'created_at'        => now()
        ]);

        User::create([
                'name'              => 'Atención Equi-par'
            ,   'email'             => 'atencionaclientes@equi-par.com'
            ,   'email_verified_at' => now()
            ,   'password'          => Hash::make('f@5#UuBaVUz%')
            ,   'created_at'        => now()
        ]);
    }
}
