<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'La Paz',
                'code' => 'LP',
                'order' => 1,
            ], [
                'name' => 'Santa Cruz',
                'code' => 'SC',
                'order' => 2,
            ], [
                'name' => 'Cochabamba',
                'code' => 'CB',
                'order' => 3,
            ], [
                'name' => 'Oruro',
                'code' => 'OR',
                'order' => 4,
            ], [
                'name' => 'Potosí',
                'code' => 'PT',
                'order' => 5,
            ], [
                'name' => 'Sucre',
                'code' => 'SC',
                'order' => 6,
            ], [
                'name' => 'Tarija',
                'code' => 'TJ',
                'order' => 7,
            ], [
                'name' => 'Beni',
                'code' => 'BN',
                'order' => 8,
            ], [
                'name' => 'Pando',
                'code' => 'PD',
                'order' => 9,
            ],
        ];

        foreach ($data as $row) {
            City::firstOrCreate([
                'code' => $row['code'],
            ], [
                'name' => $row['name'],
                'order' => $row['order'],
            ]);
        }
    }
}
