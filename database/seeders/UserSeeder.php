<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => 'admin',
                'name' => 'Super Administrador',
            ], [
                'username' => 'smendez',
                'password' => '123456',
                'name' => 'Sebastián Mendez',
            ], [
                'username' => 'djimenez',
                'password' => '123456',
                'name' => 'Daniel Jiménez',
            ],
        ];

        foreach ($data as $row) {
            User::firstOrCreate([
                'username' => $row['username'],
            ], [
                'password' => $row['password'],
                'name' => $row['name'],
            ]);
        }
    }
}
