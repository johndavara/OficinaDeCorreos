<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOficinaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oficina', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supervisor');
            $table->string('telefono');
            $table->string('nombreOficina');
            $table->unsignedInteger('zona')->nullable();
            $table->timestamps();

            //FOREIGH KEYS
            //zona
            $table->foreign('zona')
                  ->references('id')->on('zona')
                  ->onDelete('cascade');
        });

        

         DB::table('oficina')->insert(
                    array(
                        'id' => '1',
                        'supervisor' => 'Juan Pablo Gutierrez',
                        'telefono' => '22950000',
                        'nombreOficina' => 'Oficina de San Jose',
                        'zona' => 1
                    )
        );

        DB::table('oficina')->insert(
            array(
                'id' => '2',
                'supervisor' => 'Johnnatan Vargas Ramirez',
                'telefono' => '22620000',
                'nombreOficina' => 'Oficina de Heredia',
                'zona' => 2
            )
        );

        
        DB::table('oficina')->insert(
            array(
                'id' => '3',
                'supervisor' => 'Marco Sanchez Rojas',
                'telefono' => '24400000',
                'nombreOficina' => 'Oficina de Alajuela',
                'zona' => 3
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
        Schema::dropIfExists('oficina');
    }
}
