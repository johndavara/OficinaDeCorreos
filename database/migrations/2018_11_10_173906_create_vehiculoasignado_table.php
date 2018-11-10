<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculoasignadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculoasignado', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idrepartidor')->nullable();
            $table->unsignedInteger('idvehiculo')->nullable();
            $table->timestamps();

                                     //FOREIGH KEYS
            //asignados
            $table->foreign('idrepartidor')
                  ->references('id')->on('repartidor')
                  ->onDelete('cascade');

             $table->foreign('idvehiculo')
                  ->references('id')->on('vehiculo')
                  ->onDelete('cascade');
        });


        DB::table('vehiculoasignado')->insert(
            array(
                'id' => '1',
                'idrepartidor' => '1',
                'idvehiculo' => '1'
            )
        );

        DB::table('vehiculoasignado')->insert(
            array(
                'id' => '2',
                'idrepartidor' => '2',
                'idvehiculo' => '2'
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
        Schema::dropIfExists('vehiculoasignado');
    }
}
