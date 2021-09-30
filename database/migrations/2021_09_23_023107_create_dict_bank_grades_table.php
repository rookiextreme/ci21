<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictBankGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_bank_grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dict_bank_grades_categories_id');
            $table->integer('grades_id');
            $table->string('name');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dict_bank_grades', function(Blueprint $table){
            $table->foreign('dict_bank_grades_categories_id')->references('id')->on('dict_bank_grades_categories');
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
        Schema::dropIfExists('dict_bank_grades');
    }
}
