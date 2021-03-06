<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictBankCompetencyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_bank_competency_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('years_id')->nullable();
            $table->integer('dict_col_competency_types_id')->nullable();
            $table->integer('dict_bank_sets_id')->nullable();
            $table->integer('tech_discipline_flag')->nullable()->default(0);
            $table->integer('flag')->nullable();
            $table->integer('delete_id')->nullable();
            $table->timestamps();
        });

        Schema::table('dict_bank_competency_types', function(Blueprint $table){
            $table->foreign('years_id')->references('id')->on('years');
            $table->foreign('dict_col_competency_types_id')->references('id')->on('dict_col_competency_types');
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
        Schema::dropIfExists('dict_bank_competency_types');
    }
}
