<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepartidorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repartidor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('cedula')->nullable();
            $table->string('telefono')->nullable();
            $table->unsignedInteger('idusuario')->nullable();
            $table->timestamps();
                         //FOREIGH KEYS
            //zona
            $table->foreign('idusuario')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });

        
        DB::table('repartidor')->insert(
            array(
                'id' => '1',
                'nombre' => 'Gerardo Ocampo Jimenez',
                'cedula' => '409870342',
                'telefono' => '88888888',
                'idusuario' => '2'
            )
        );

        DB::table('repartidor')->insert(
            array(
                'id' => '2',
                'nombre' => 'Julian Valverde Vega',
                'cedula' => '603430653',
                'telefono' => '65324125',
                'idusuario' => '3'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repartidor');
    }
}
