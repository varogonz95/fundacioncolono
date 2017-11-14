<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->increments('id');

            $table->char('persona_fk', 9);
            $table->unsignedInteger('usuario_fk');
            $table->unsignedInteger('expediente_fk');

            // Fecha en la que el inspector eligió la visita
            // $table->date('fecha_seleccion')->nullable();
            // Fecha en la que se da por concluida la visita
            $table->date('fecha_visita')->nullable();

            $table->text('observaciones');

            // Soft delete for inspector
            // Documentation at: https://laravel.com/docs/5.5/eloquent#soft-deleting
            $table->foreign('persona_fk')
                  ->references('cedula')->on('personas')
                  ->onDelete('no action');

            $table->foreign('usuario_fk')
                  ->references('id')->on('usuarios')
                  ->onDelete('no action');

            $table->foreign('expediente_fk')
                  ->references('id')->on('expedientes')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitas');
    }
}
