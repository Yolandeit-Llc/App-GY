<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupeCampagneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupecampagnes', function (Blueprint $table) {
            $table->id('id_campagne');
            $table->string('nom');
            $table->string('score');
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('contexte');
            $table->string('contenu_post_mere');
            $table->string('objectifs');
            $table->string('recommandation');
            $table->string('bilan');
            $table->date('date_programmation')->nullable();
            $table->string('nb_likes');
            $table->string('nb_comments');
            $table->string('nb_shares');
            $table->string('portee');
            $table->string('id_segmentation');
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
        Schema::dropIfExists('groupecampagnes');
    }
}
