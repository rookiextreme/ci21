<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaiansJawapansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaians_jawapans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('penilaians_competencies_id');
            $table->integer('dict_bank_competencies_questions_id');
            $table->integer('dict_bank_sets_items_id');
            $table->integer('score');
            $table->timestamps();
        });

        Schema::table('penilaians_jawapans', function(Blueprint $table){
            $table->foreign('penilaians_competencies_id')->references('id')->on('penilaians_competencies');
            $table->foreign('dict_bank_competencies_questions_id')->references('id')->on('dict_bank_competencies_questions');
            $table->foreign('dict_bank_sets_items_id')->references('id')->on('dict_bank_sets_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaians_jawapans');
    }
}
