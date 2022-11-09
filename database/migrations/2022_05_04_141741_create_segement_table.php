<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSegementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('segements', function (Blueprint $table) {
            $table->id('id_segment');
            $table->string('nom_segment');
            $table->string('theme');
            $table->string('type');
            $table->string('caracteristique');
            $table->string('description');
            $table->string('id_segmentation');
            $table->string('nb_groupe');
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
        Schema::dropIfExists('segements');
    }
}
