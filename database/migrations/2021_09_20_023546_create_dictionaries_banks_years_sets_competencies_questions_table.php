<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionariesBanksYearsSetsCompetenciesQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionaries_banks_years_sets_competencies_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dictionaries_banks_years_sets_items_id');
            $table->text('title_eng');
            $table->text('title_mal');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dictionaries_banks_years_sets_competencies_questions', function(Blueprint $table){
            $table->foreign('dictionaries_banks_years_sets_items_id')->references('id')->on('dictionaries_banks_years_sets_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionaries_banks_years_sets_competencies_questions');
    }
}
