<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobgroupYearsSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobgroup_years_sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('profiles_id');
            $table->integer('years_id');
            $table->integer('jurusan_id');
            $table->integer('dictionaries_banks_years_sets_grades_id');
            $table->text('title_eng');
            $table->text('title_mal');
            $table->text('desc_eng');
            $table->text('desc_mal');
            $table->integer('ref_id');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('jobgroup_years_sets', function(Blueprint $table){
            $table->foreign('profiles_id')->references('id')->on('profiles');
            $table->foreign('years_id')->references('id')->on('years');
            $table->foreign('dictionaries_banks_years_sets_grades_id')->references('id')->on('dictionaries_banks_years_sets_grades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobgroup_years_sets');
    }
}
