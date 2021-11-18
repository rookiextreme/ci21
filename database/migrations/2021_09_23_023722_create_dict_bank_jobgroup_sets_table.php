<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictBankJobgroupSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_bank_jobgroup_sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->integer('profiles_id');
            // $table->integer('years_id');
            $table->text('jurusan_id');
            $table->integer('dict_bank_grades_categories_id');
            $table->integer('dict_bank_sets_id');
            $table->text('title_eng');
            $table->text('title_mal')->nullable();
            $table->text('desc_eng')->nullable();;
            $table->text('desc_mal')->nullable();;
            // $table->integer('ref_id');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dict_bank_jobgroup_sets', function(Blueprint $table){
            // $table->foreign('profiles_id')->references('id')->on('profiles');
            // $table->foreign('years_id')->references('id')->on('years');
            $table->foreign('dict_bank_grades_categories_id')->references('id')->on('dict_bank_grades_categories');
            $table->foreign('dict_bank_sets_id')->references('id')->on('dict_bank_sets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_bank_jobgroup_sets');
    }
}
