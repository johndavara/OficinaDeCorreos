<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRutaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo')->nullable();
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        DB::table('ruta')->insert(
            array(
                'id' => '1',
                'tipo' => 'Ruta Diurna',
                'descripcion' => 'Ruta que comprende de 7am a 12md'
            )
        );

        
        DB::table('ruta')->insert(
            array(
                'id' => '2',
                'tipo' => 'Ruta Nocturna',
                'descripcion' => 'Ruta que comprende de 12:01am a 5pm'
            )
        );

        DB::table('ruta')->insert(
            array(
                'id' => '3',
                'tipo' => 'Ruta Especial',
                'descripcion' => 'Movimiento entre oficinas de correo'
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
        Schema::dropIfExists('ruta');
    }
}
