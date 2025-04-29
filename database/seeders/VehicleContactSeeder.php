<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicles;
use App\Models\Contact;

class VehicleContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creamos 20 vehículos
        for ($i = 0; $i < 20; $i++) {
            $vehiculo = Vehicles::create([
                'plate' => strtoupper('ABC' . rand(100, 999)),
                'brand' => fake()->randomElement(['Toyota', 'Ford', 'Honda', 'BMW', 'Chevrolet']),
                'model' => fake()->word(),
                'manufacturing_year' => fake()->year(),
            ]);

            // Creamos su contacto relacionado
            $vehiculo->contacts()->create([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'document_number' => fake()->numerify('########'),
                'email' => fake()->unique()->safeEmail(),
                'phone' => fake()->phoneNumber(),
            ]);
        }
    }
}
