<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaiansCompetenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaians_competencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('penilaians_id');
            $table->integer('dict_bank_competency_types_scale_lvls_id');
            $table->integer('status');
            $table->timestamps();
        });

        Schema::table('penilaians_competencies', function(Blueprint $table){
            $table->foreign('penilaians_id')->references('id')->on('penilaians');
            $table->foreign('dict_bank_competency_types_scale_lvls_id')->references('id')->on('dict_bank_competency_types_scale_lvls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaians_competencies');
    }
}
