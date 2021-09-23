<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictColJobgroupSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_col_jobgroup_sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('profiles_id');
            $table->integer('years_id');
            $table->integer('jurusan_id');
            $table->integer('dict_col_grades_categories_id');
            $table->text('title_eng');
            $table->text('title_mal');
            $table->text('desc_eng');
            $table->text('desc_mal');
            $table->integer('ref_id');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dict_col_jobgroup_sets', function(Blueprint $table){
            $table->foreign('profiles_id')->references('id')->on('profiles');
            $table->foreign('years_id')->references('id')->on('years');
            $table->foreign('dict_col_grades_categories_id')->references('id')->on('dict_col_grades_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_col_jobgroup_sets');
    }
}
