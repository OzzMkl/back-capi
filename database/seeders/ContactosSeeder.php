<?php

namespace Database\Seeders;

use App\Models\contactos;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ContactosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5000; $i++) {
            // Crea un nuevo contacto
            $contacto = contactos::create([
                'nombre' => $faker->firstName,
                'apellido_paterno' => $faker->lastName,
                'apellido_materno' => $faker->lastName,
                'fecha_nacimiento' => $faker->date('Y-m-d'),
            ]);
             // Agrega entre 0 y 3 teléfonos al contacto
             for ($j = 0; $j < rand(0, 3); $j++) {
                $telefono = $faker->numerify('##########');
                $contacto->telefonos()->create([
                    'telefono' => $telefono,
                ]);
            }
            for ($j = 0; $j < rand(0, 3); $j++) {
                $contacto->emails()->create([
                    'email' => $faker->email,
                ]);
            }
            for ($j = 0; $j < rand(0, 3); $j++) {
                $cp = $faker->numerify('#####');
                $contacto->direcciones()->create([
                    'estado' => $faker->state,
                    'ciudad' => $faker->city,
                    'colonia' => $faker->streetName,
                    'calle' => $faker->streetAddress,
                    'numero' => $faker->buildingNumber,
                    'codigo_postal' => $cp,
                ]);
            }
        }
    }
}
