<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        if(App\Models\Ayuda::count() === 0){
            $this->call(AyudasSeeder::class);
        }

        factory(App\Models\Expediente::class, 150)->create()
        ->each(function($expediente){

            $faker = Faker\Factory::create();

            $ayudas = App\Models\Ayuda::all();
            $ayudas_count = count($ayudas);
            $number_of_attachs = $faker->numberBetween(1,$ayudas_count);

            for ($i=0; $i < $number_of_attachs; $i++) {
                $expediente->ayudas()
                           ->attach(
                               $ayudas[$faker->numberBetween(0,$ayudas_count-1)]->id,
                               [
                                   'detalle' => $faker->text(300),
                                   'monto' => $faker->numberBetween(10000, 1000000)
                               ]
                           );
            }

        });
    }
}
