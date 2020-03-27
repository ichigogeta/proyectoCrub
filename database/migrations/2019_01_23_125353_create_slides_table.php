<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * Slider básico, incluido con el paquete base.
         */
        Schema::create('slides', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(0);
            $table->unsignedInteger('orden')->default(0);//usar con el ordenamiento del bread
            $table->text('image');
            $table->string('title', 255)->nullable();
            $table->string('text', 255)->nullable();
            $table->string('url', 255)->nullable(); //clic directo o botón
            $table->string('url_text', 511)->nullable();//texto para el botón.
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slides');
    }
}
