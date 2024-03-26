<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstalacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instalacion', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_programacion')->unsigned()->unique();
            $table->bigInteger('id_venta')->unsigned()->unique();
            $table->string('img', 10255)->nullable();
            $table->bigInteger('status');
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
        Schema::dropIfExists('instalacion');
    }
}
