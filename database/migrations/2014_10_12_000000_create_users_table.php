<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert(
            array(
                'id' => '1',
                'name' => 'Usuario Administrador',
                'email' => 'admin@correos.com',
                'password' => bcrypt('admin123')
            )
        );
        DB::table('users')->insert(
            array(
                'id' => '2',
                'name' => 'Usuario Repartidor',
                'email' => 'repartidor@correos.com',
                'password' => bcrypt('repartidor123')
            )
        );

        DB::table('users')->insert(
            array(
                'id' => '3',
                'name' => 'Usuario Repartidor 2',
                'email' => 'repartidor2@correos.com',
                'password' => bcrypt('repartidor123')
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
        Schema::dropIfExists('users');
    }
}
