<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictBankSetsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_bank_sets_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dict_bank_sets_id');
            $table->integer('dict_bank_measuring_lvls_id');
            $table->integer('dict_bank_competency_types_scale_lvls_id');
            $table->integer('jurusan_id');
            $table->integer('dict_bank_grades_categories_id');
            $table->text('title_eng');
            $table->text('title_mal');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dict_bank_sets_items', function(Blueprint $table){
            $table->foreign('dict_bank_sets_id')->references('id')->on('dict_bank_sets');
            $table->foreign('dict_bank_measuring_lvls_id')->references('id')->on('dict_bank_measuring_lvls');
            $table->foreign('dict_bank_competency_types_scale_lvls_id')->references('id')->on('dict_bank_competency_types_scale_lvls');
            $table->foreign('dict_bank_grades_categories_id', 'dict_bank_grading')->references('id')->on('dict_bank_grades_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_bank_sets_items');
    }
}
