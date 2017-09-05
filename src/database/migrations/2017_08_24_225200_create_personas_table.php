<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->char('cedula',20)->unique();
            $table->string('nombre', 50);
            $table->string('apellidos', 100);
            $table->string('ocupacion', 100);
            $table->text('tels',150);
            $table->char('ubicacion',6);
            $table->text('direccion',150);
            $table->text('contactos',150);
            $table->char('esInspector',1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
