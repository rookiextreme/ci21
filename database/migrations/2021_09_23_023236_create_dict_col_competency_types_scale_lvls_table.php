<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictColCompetencyTypesScaleLvlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_col_competency_types_scale_lvls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dict_col_competency_types_id');
            $table->integer('dict_col_scale_lvls_id');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dict_col_competency_types_scale_lvls', function(Blueprint $table){
            $table->foreign('dict_col_competency_types_id')->references('id')->on('dict_col_competency_types');
            $table->foreign('dict_col_scale_lvls_id')->references('id')->on('dict_col_scale_lvls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_col_competency_types_scale_lvls');
    }
}
