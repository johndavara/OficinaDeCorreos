<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaqueteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paquete', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identificador');
            $table->string('descripcion')->nullable();
            $table->string('remitente');
            $table->string('destinatario');
            $table->unsignedInteger('zona')->nullable();
            $table->string('direccion')->nullable();
            $table->string('peso')->nullable();
            $table->unsignedInteger('idestado')->nullable();
            $table->float('montoACancelar', 8, 2)->nullable();
            $table->timestamps();

            //FOREIGH KEYS
            //zona
            $table->foreign('zona')
                  ->references('id')->on('zona')
                  ->onDelete('cascade');
            // estado
            $table->foreign('idestado')
                  ->references('id')->on('estadopaquete')
                  ->onDelete('cascade');
        });

        DB::table('paquete')->insert(
            array(
                'id' => '1',
                'identificador' => 'AX1BISDKLSDD001',
                'descripcion' => 'Bola de bolos',
                'remitente' => 'David Alvarez Fonseca',
                'destinatario' => 'Marco Gutierrez Jimenez',
                'zona' => 1,
                'direccion' => 'En Barrio Cuba, de la pulperia chepe 50 sur y 20 norte, casa color roja, portones blancos',
                'peso' => '2 Kilogramos',
                'idestado' => 2,
                'montoACancelar' => 5000,
            )
        );

        DB::table('paquete')->insert(
            array(
                'id' => '2',
                'identificador' => 'AX99934KAJSDKAS',
                'descripcion' => 'Guitarra electrica Gibson',
                'remitente' => 'Miguel Perez Venegas',
                'destinatario' => 'Roger Zamora Vivaldi',
                'zona' => 2,
                'direccion' => 'En Barrio Don Bosco, de la esquina surm 50 este y 20 norte, casa color blanca, portones negros',
                'peso' => '5 Kilogramos',
                'idestado' => 2,
                'montoACancelar' => 15000,
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
        Schema::dropIfExists('paquete');
    }
}
