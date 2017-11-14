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
            // one-to-one relationship with Persona
            $table->char('persona_fk', 9);
            $table->unsignedInteger('referente_fk');
            // In case Referente not in options but exists
            $table->string('referente_otro',100)->nullable();
            $table->tinyInteger('prioridad');
            $table->tinyInteger('estado');
            $table->text('descripcion');
            $table->date('pago_inicio')->nullable();
            $table->date('pago_final')->nullable();
            $table->timestamp('fecha_creacion');
            $table->softDeletes('fecha_eliminacion');
            // $table->boolean('activo')->default(true);

            // Table constraints
            $table->foreign('persona_fk')
                  ->references('cedula')->on('personas')
                  ->onDelete('cascade');

            $table->foreign('referente_fk')
                  ->references('id')->on('referentes')
                  ->onDelete('no action');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down(){
        Schema::dropIfExists('expedientes');
    }

}
