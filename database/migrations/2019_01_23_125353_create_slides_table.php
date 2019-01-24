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
            $table->string('image');
            $table->string('title')->nullable();
            $table->string('text')->nullable();
            $table->string('url')->nullable(); //clic directo o botón
            $table->string('url_text')->nullable();//texto para el botón.
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
