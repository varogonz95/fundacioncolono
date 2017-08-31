<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class HistoricoExpedientesSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        factory(App\Model\HistoricoExpediente::class, 12)->create();
    }
}
