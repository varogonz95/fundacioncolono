<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAyudaExpedientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ayuda_expedientes', function (Blueprint $table) {

            $table->increments('id');
            // Many-to-many relationship between Ayuda and Expediente
            $table->unsignedInteger('expediente_fk');
            $table->unsignedInteger('ayuda_fk');
            // ------------------------------------------------------
            $table->text('detalle');

            // Table constraints
            $table->foreign('expediente_fk')
                  ->references('id')->on('expedientes')
                  ->onDelete('cascade');

            $table->foreign('ayuda_fk')
                  ->references('id')->on('ayudas')
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
        Schema::dropIfExists('ayuda_expedientes');
    }
}
