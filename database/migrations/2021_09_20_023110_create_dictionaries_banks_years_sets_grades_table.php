<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionariesBanksYearsSetsGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionaries_banks_years_sets_grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dictionaries_banks_years_sets_id');
            $table->integer('grades_categories_id');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dictionaries_banks_years_sets_grades', function(Blueprint $table){
            $table->foreign('dictionaries_banks_years_sets_id')->references('id')->on('dictionaries_banks_years_sets');
            $table->foreign('grades_categories_id')->references('id')->on('grades_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionaries_banks_years_sets_grades');
    }
}
