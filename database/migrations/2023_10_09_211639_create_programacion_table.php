<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programacion', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_instalacion')->nullable();
            $table->date('fecha_termino')->nullable();
            $table->bigInteger('status');
            $table->bigInteger('id_users')->unsigned()->nullable();
            $table->bigInteger('id_venta')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programacion');
    }
}
