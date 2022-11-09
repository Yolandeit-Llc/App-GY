<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionadTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */

    public function up()
    {
        Schema::create('questionads', function (Blueprint $table) {
            $table->id();
            $table->string('id_groupe');
            $table->string('nom');
            $table->string('theme');
            $table->string('nb_membres');
            $table->string('id_question');
            $table->string('question');
            $table->string('reponse');
            $table->string('reponse2');
            $table->string('reponse3');
 
            $table->timestamps();
        });
    }
    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionads');
    }
}
