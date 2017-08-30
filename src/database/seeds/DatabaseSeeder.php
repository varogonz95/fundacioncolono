<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        factory(App\Model\Persona::class, 100)->create();
        factory(App\Model\TipoAyuda::class, 4)->create();
        factory(App\Model\Expediente::class, 25)->create();
    }
}
