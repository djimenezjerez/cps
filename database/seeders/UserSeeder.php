<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate([
            'username' => 'admin',
        ], [
            'password' => 'admin',
            'name' => 'Super Administrador'
        ]);

        User::firstOrCreate([
            'username' => 'smendez',
        ], [
            'password' => '123456',
            'name' => 'Sebastián Mendez'
        ]);

        User::firstOrCreate([
            'username' => 'djimenez',
        ], [
            'password' => '123456',
            'name' => 'Daniel Jiménez'
        ]);
    }
}
