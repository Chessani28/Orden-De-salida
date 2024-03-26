<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentaTable extends Migration
{
    public function up()
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ine')->nullable();
            $table->string('luz')->nullable();
            $table->string('ubicacion', 100)->nullable();
            $table->string('pago')->nullable();
            $table->bigInteger('status');
            $table->bigInteger('tipo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('venta');
    }
}
