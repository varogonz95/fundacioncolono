<?php

use Illuminate\Database\Seeder;

class DatabaseUnseeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('inspectores')->delete();
        DB::table('personas')->delete();
        DB::table('ayudas')->delete();
        $referente_otro = DB::table('referentes')->first();
        DB::table('referentes')->where('id', '<>', $referente_otro->id)->delete();
        DB::table('visitas')->delete();
        DB::table('expedientes')->delete();
        DB::table('historico_expedientes')->delete();
        DB::table('ayuda_expedientes')->delete();
    }
}
