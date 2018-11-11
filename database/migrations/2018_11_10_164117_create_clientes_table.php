<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('zona');
            $table->string('calle');
            $table->string('avenida');
            $table->integer('pisos');
            $table->integer('distancia');
            $table->integer('cantidad');
            $table->string('latitud');
            $table->string('longitud');
            $table->string('razonSocial');
            $table->string('nombre');
            $table->string('telefono');
            $table->string('observacion');

            $table->timestamps();
        });

        DB::table('clientes')->insert(
            array(
                'id' => '1',
                'zona' => 'Concepcion de San Rafael de Heredia',
                'calle' => 'Calle Hernandez',
                'avenida' => 'N/A',
                'pisos' => 2,
                'distancia' => 50,
                'cantidad' => 1,
                'latitud' => '10.0302279',
                'longitud' => '-84.0769844',
                'razonSocial' => 'Venta de Accesorios',
                'telefono' => '22680000',
                'nombre' => 'Manuel Salas Salas',
                'observacion' => '50 metros antes de la esquina si viene de oeste a este'
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
        Schema::dropIfExists('clientes');
    }
}
