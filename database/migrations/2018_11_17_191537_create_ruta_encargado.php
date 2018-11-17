<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRutaEncargado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paradasruta', function (Blueprint $table) {
            $table->unsignedInteger('idRepartidor')->nullable();

            $table->foreign('idRepartidor')
                ->references('id')->on('repartidor')
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
        Schema::table('paradasruta', function($table) {
            $table->dropForeign('paradasruta_idrepartidor_foreign');
            $table->dropColumn('idRepartidor');
        });
    }
}
