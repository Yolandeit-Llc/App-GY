<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupes', function (Blueprint $table) {
            $table->id();
            $table->string('id_groupe');
            $table->string('nom');          
            $table->string('personnalisation');
            $table->string('nb_membres');
            $table->string('theme');
            $table->string('type');
            $table->string('reglementation');
            $table->string('url_a_propos');
            $table->string('frequence_post_mois');
            $table->string('format_groupe');
            $table->string('lieu');
            $table->string('actif_supprime');
            $table->string('statut_releve');
            $table->date('date_releve');
            $table->string('statut_integration');
            $table->string('tag_recherche');
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
        Schema::dropIfExists('groupes');
    }
}
