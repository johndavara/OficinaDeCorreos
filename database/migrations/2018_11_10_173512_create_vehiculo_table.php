<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('placa')->nullable();
            $table->string('modelo')->nullable();
            $table->string('marca')->nullable();
            $table->string('año')->nullable();
            $table->timestamps();
        });

        DB::table('vehiculo')->insert(
            array(
                'placa' => '123456',
                'modelo' => 'HD50',
                'marca' => 'Hiunday',
                'año' => '2018'
            )
        );

        DB::table('vehiculo')->insert(
            array(
                'placa' => '456123',
                'modelo' => 'HD50',
                'marca' => 'Hiunday',
                'año' => '2018'
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
        Schema::dropIfExists('vehiculo');
    }
}
