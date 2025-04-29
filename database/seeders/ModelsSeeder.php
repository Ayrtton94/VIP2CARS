<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Models;
use App\Models\Brand;

class ModelsSeeder extends Seeder
{
    public function run()
    {
        $modelosPorMarca = [
            'Toyota' => ['Corolla', 'Camry', 'Hilux', 'RAV4'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Fit'],
            'Ford' => ['Focus', 'Fiesta', 'Mustang', 'Explorer'],
            'Chevrolet' => ['Aveo', 'Cruze', 'Silverado', 'Tahoe'],
            'Nissan' => ['Versa', 'Sentra', 'Altima', 'Frontier'],
            'Volkswagen' => ['Jetta', 'Golf', 'Tiguan', 'Passat'],
            'Hyundai' => ['Elantra', 'Tucson', 'Santa Fe', 'Accent'],
            'Kia' => ['Rio', 'Sportage', 'Sorento', 'Forte'],
            'BMW' => ['Serie 3', 'Serie 5', 'X1', 'X5'],
            'Mercedes-Benz' => ['Clase A', 'Clase C', 'Clase E', 'GLC'],
        ];

        foreach ($modelosPorMarca as $nombreMarca => $modelos) {
            $marca = Brand::where('name', $nombreMarca)->first();
            if ($marca) {
                foreach ($modelos as $modelo) {
                    Models::create([
                        'name' => $modelo,
                        'brand_id' => $marca->id,
                    ]);
                }
            }
        }
    }
}
