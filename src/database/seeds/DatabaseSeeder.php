<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        // $this->call(AyudasSeeder::class);
        // $ayudas_count = App\Models\Ayuda::count();

        factory(App\Models\Expediente::class, 50)->create()
        ->each(function($expediente){

            $faker = Faker\Factory::create();

            $ayudas = App\Models\Ayuda::all();
            $ayudas_count = count($ayudas);
            $number_of_attachs = rand(1,$ayudas_count);

            for ($i=0; $i < $number_of_attachs; $i++) {
                $expediente->ayudas()->attach($ayudas[rand(0,$ayudas_count-1)]->id,['detalle' => $faker->text(300)]);
            }

        });
    }
}
