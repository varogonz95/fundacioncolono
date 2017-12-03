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

        DB::table('ayudas')->insert([
            ['descripcion' => 'Alimentación'],
            ['descripcion' => 'Construcción'],
            ['descripcion' => 'Medicamentos'],
            ['descripcion' => 'Equipo Médico'],
            ['descripcion' => 'Aporte Económico'],
        ]);
    }
}
