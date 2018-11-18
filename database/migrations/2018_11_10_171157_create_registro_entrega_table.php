<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistroEntregaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_entrega', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identificadorPaquete')->nullable();
            $table->unsignedInteger('idPaquete')->nullable();
            $table->string('descripcion')->nullable();
            $table->timestamps();           
             //FOREIGH KEYS
            //zona
            $table->foreign('idPaquete')
                  ->references('id')->on('paquete')
                  ->onDelete('cascade');
        });

        DB::table('registro_entrega')->insert(
            array(
                'id' => '1',
                'identificadorPaquete' => 'AX99934KAJSDKAS',
                'idPaquete' => '1',
                'descripcion' => 'Se le entrega al señor Marco en la puerta de su casa',
                'idRepartidor' => '1'
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
        Schema::dropIfExists('registro_entrega');
    }
}
