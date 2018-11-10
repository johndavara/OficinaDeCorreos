<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadopaqueteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadopaquete', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        DB::table('estadopaquete')->insert(
            array(
                'id' => '1',
                'descripcion' => 'En oficina de Correos'
            )
        );
        DB::table('estadopaquete')->insert(
            array(
                'id' => '2',
                'descripcion' => 'En Transito'
            )
        );
        
        DB::table('estadopaquete')->insert(
            array(
                'id' => '3',
                'descripcion' => 'Entregado'
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
        Schema::dropIfExists('estadopaquete');
    }
}
