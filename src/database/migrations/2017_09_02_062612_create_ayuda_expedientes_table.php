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

            // Many-to-many relationship between Ayuda and Expediente
            $table->unsignedInteger('expediente_id');
            $table->unsignedInteger('ayuda_id');
            // ------------------------------------------------------
            $table->text('detalle')
                   ->nullable()
                   ->default(null);
            $table->unsignedMediumInteger('monto')
                  ->nullable()
                  ->default(0);

            // Table constraints
            $table->foreign('expediente_id')
                  ->references('id')->on('expedientes')
                  ->onDelete('cascade');

            $table->foreign('ayuda_id')
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
