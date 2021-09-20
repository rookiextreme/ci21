<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobgroupSetsItemsScoresSetsGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobgroup_sets_items_scores_sets_grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('jobgroup_years_sets_items_id');
            $table->integer('grades_id');
            $table->integer('score');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('jobgroup_sets_items_scores_sets_grades', function(Blueprint $table){
            $table->foreign('jobgroup_years_sets_items_id')->references('id')->on('jobgroup_years_sets_items');
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
        Schema::dropIfExists('jobgroup_sets_items_scores_sets_grades');
    }
}
