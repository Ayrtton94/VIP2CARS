<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $marcas = [
            'Toyota',
            'Honda',
            'Ford',
            'Chevrolet',
            'Nissan',
            'Volkswagen',
            'Hyundai',
            'Kia',
            'BMW',
            'Mercedes-Benz',
        ];

        foreach ($marcas as $marca) {
            Brand::create(['name' => $marca]);
        }
    }
}
