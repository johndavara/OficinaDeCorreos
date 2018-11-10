<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zona', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
        });

        DB::table('zona')->insert(
            array(
                'id' => '1',
                'nombre' => 'San Jose'
            )
        );
        DB::table('zona')->insert(
            array(
                'id' => '2',
                'nombre' => 'Alajuela'
            )
        );
        DB::table('zona')->insert(
            array(
                'id' => '3',
                'nombre' => 'Cartago'
            )
        );
        DB::table('zona')->insert(
            array(
                'id' => '4',
                'nombre' => 'Heredia'
            )
        );
        DB::table('zona')->insert(
            array(
                'id' => '5',
                'nombre' => 'Puntarenas'
            )
        );
        DB::table('zona')->insert(
            array(
                'id' => '6',
                'nombre' => 'Guanacaste'
            )
        );
        DB::table('zona')->insert(
            array(
                'id' => '7',
                'nombre' => 'Limon'
            )
        );
        DB::table('zona')->insert(
            array(
                'id' => '8',
                'nombre' => 'Isla del Coco'
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
        Schema::dropIfExists('zona');
    }
}
