<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionariesBanksYearsSetsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionaries_banks_years_sets_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dictionaries_banks_years_sets_id');
            $table->integer('measuring_lvls_id');
            $table->integer('competency_types_scale_lvls_id');
            $table->integer('jurusan_id');
            $table->integer('dictionaries_banks_years_sets_grades_id');
            $table->text('title_eng');
            $table->text('title_mal');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dictionaries_banks_years_sets_items', function(Blueprint $table){
            $table->foreign('dictionaries_banks_years_sets_id')->references('id')->on('dictionaries_banks_years_sets');
            $table->foreign('measuring_lvls_id')->references('id')->on('measuring_lvls');
            $table->foreign('competency_types_scale_lvls_id')->references('id')->on('competency_types_scale_lvls');
            $table->foreign('dictionaries_banks_years_sets_grades_id', 'dictionaries_banks_grading')->references('id')->on('dictionaries_banks_years_sets_grades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionaries_banks_years_sets_items');
    }
}
