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
            $table->char('persona_fk', 9);
            $table->integer('tipo_ayuda_fk')->unsigned();
            $table->tinyInteger('prioridad');
            $table->tinyInteger('estado');
            $table->text('descripcion');
            $table->text('recomendaciones');
            $table->timestamp('fecha_creacion');
            $table->mediumInteger('monto')
                  ->unsigned();

            $table->foreign('persona_fk')
                  ->references('cedula')->on('personas')
                  ->onDelete('cascade');

            $table->foreign('tipo_ayuda_fk')
                  ->references('id')->on('tipo_ayudas')
                  ->onDelete('no action');
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
