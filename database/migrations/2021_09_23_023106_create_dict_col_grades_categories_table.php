<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictColGradesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_col_grades_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dict_col_sets_id');
            $table->string('nama');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dict_col_grades_categories', function(Blueprint $table){
            $table->foreign('dict_col_sets_id')->references('id')->on('dict_bank_sets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_col_grades_categories');
    }
}
