<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParadasrutaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paradasruta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('oficinadesde')->nullable();
            $table->unsignedInteger('oficinahasta')->nullable();
            $table->unsignedInteger('paquete')->nullable();
            $table->unsignedInteger('ruta')->nullable();
            $table->unsignedInteger('idRepartidor')->nullable();
            $table->timestamps();

            $table->foreign('oficinadesde')
            ->references('id')->on('oficina')
            ->onDelete('cascade');

            $table->foreign('oficinahasta')
            ->references('id')->on('oficina')
            ->onDelete('cascade');

            $table->foreign('paquete')
            ->references('id')->on('paquete')
            ->onDelete('cascade');

            $table->foreign('ruta')
            ->references('id')->on('ruta')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paradasruta');
    }
}
