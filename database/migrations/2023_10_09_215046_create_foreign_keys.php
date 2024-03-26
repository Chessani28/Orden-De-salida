<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });*/

        Schema::table('venta', function (Blueprint $table) {
            //$table->foreign('id_verificacion')->references('id')->on('verificacion');
            //$table->foreign('id_instalacion')->references('id')->on('instalacion');
            //$table->foreign('id_users')->references('id')->on('users');
        });

        
        //Desde acá no me funciona lo de abajo, no se porque jajajajajaj ayuda quiero un abrazo, la muchacha con la que estoy intentando no me gusta nada jaja, ayuda, quiero un helado
        Schema::table('instalacion', function (Blueprint $table) {
            $table->foreign('id_programacion')->references('id')->on('programacion');
            $table->foreign('id_venta')->references('id')->on('venta');
        });

        Schema::table('programacion', function (Blueprint $table) {
            $table->foreign('id_users')->references('id')->on('users');
            $table->foreign('id_venta')->references('id')->on('venta');
        });
      
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foreign_keys');
    }
}
