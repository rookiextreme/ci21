<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionariesSetsItemsScoresSetsGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionaries_sets_items_scores_sets_grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dictionaries_banks_years_sets_items_id');
            $table->integer('grades_id');
            $table->integer('tech_discipline_flag');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dictionaries_sets_items_scores_sets_grades', function(Blueprint $table){
            $table->foreign('dictionaries_banks_years_sets_items_id')->references('id')->on('dictionaries_banks_years_sets_items');
            $table->foreign('grades_id')->references('id')->on('grades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionaries_sets_items_scores_sets_grades');
    }
}
