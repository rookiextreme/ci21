<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictBankSetsItemsScoresSetsGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_bank_sets_items_scores_sets_grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dict_bank_sets_items_id');
            // $table->integer('dict_bank_grades_id');
            // $table->integer('tech_discipline_flag');
            $table->integer('dict_bank_grades_id');
            $table->integer('score');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dict_bank_sets_items_scores_sets_grades', function(Blueprint $table){
            $table->foreign('dict_bank_sets_items_id')->references('id')->on('dict_bank_sets_items');
            $table->foreign('dict_bank_grades_id')->references('id')->on('dict_bank_grades');
            // $table->foreign('dict_bank_grades_id')->references('id')->on('dict_bank_grades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_bank_sets_items_scores_sets_grades');
    }
}
