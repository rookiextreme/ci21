<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictBankSetsCompetenciesQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_bank_sets_competencies_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dict_bank_sets_items_id');
            $table->text('title_eng');
            $table->text('title_mal');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dict_bank_sets_competencies_questions', function(Blueprint $table){
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
        Schema::dropIfExists('dict_bank_sets_competencies_questions');
    }
}
