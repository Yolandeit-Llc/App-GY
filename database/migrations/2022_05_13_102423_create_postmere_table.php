<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostmereTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postmeres', function (Blueprint $table) {
            $table->id('id_post');
            $table->string('id_campagne');
            $table->string('url_post');
            $table->string('statut_scrappe');
            $table->string('titre');
            $table->string('type_media');
            $table->string('legende');
            $table->string('hashtag');
            $table->string('portee');
            $table->string('interaction');
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
        Schema::dropIfExists('postmeres');
    }
}
