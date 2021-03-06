<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJugadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jugadores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('apodo');
            $table->string('nombre');
            $table->string('apellido')->nullable();
            $table->date('fechaNac')->nullable();
            $table->timestamps();
        });


        Schema::create('reglasdados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reto1');
            $table->string('reto2');
            $table->string('accion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jugadores');
    }
}
