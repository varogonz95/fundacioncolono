<?php

use Illuminate\Database\Seeder;

class AyudasSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $faker = Faker\Factory::create();
        // $first_day = $faker->numberBetween(1, 15);
        // // Compute reasonable offset for second day of payment
        // $second_day = $first_day >= 7 && $first_day <= 15? 30 : $faker->numberBetween($first_day + 7, 30);

        DB::table('ayudas')->insert([
            [
                'descripcion' => 'Alimentación',
                'primer_dia_entrega' => $faker->numberBetween(1, 15),
                'segundo_dia_entrega' => $faker->numberBetween(16, 30),
            ],

            [
                'descripcion' => 'Construcción',
                'primer_dia_entrega' => $faker->numberBetween(1, 15),
                'segundo_dia_entrega' => $faker->numberBetween(16, 30),
            ],

            [
                'descripcion' => 'Medicamentos',
                'primer_dia_entrega' => $faker->numberBetween(1, 15),
                'segundo_dia_entrega' => $faker->numberBetween(16, 30),
            ],

            [
                'descripcion' => 'Equipo Médico',
                'primer_dia_entrega' => $faker->numberBetween(1, 15),
                'segundo_dia_entrega' => $faker->numberBetween(16, 30),
            ],

            [
                'descripcion' => 'Aporte Económico',
                'primer_dia_entrega' => $faker->numberBetween(1, 15),
                'segundo_dia_entrega' => $faker->numberBetween(16, 30),
            ],
        ]);
    }
}
