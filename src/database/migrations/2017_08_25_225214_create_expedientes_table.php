<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpedientesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('expedientes', function (Blueprint $table) {
            $table->increments('id');


            $table->tinyInteger('prioridad');
            $table->tinyInteger('estado');
            $table->text('descripcion');
            $table->text('recomendaciones'); 

            $table->integer('persona_fk')->unsigned();
            $table->integer('tipoayuda_expedientes_fk')->unsigned();

            $table->foreign('persona_fk')->references('id')->on('personas')->onDelete('no action');

            $table->foreign('tipoayuda_expedientes_fk')->references('id')->on('tipoayuda_expedientes')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expedientes');
    }
}
