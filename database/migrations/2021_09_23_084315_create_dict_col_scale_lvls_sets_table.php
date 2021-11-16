<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictColScaleLvlsSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_col_scale_lvls_sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dict_col_scale_lvls_id');
            $table->integer('dict_col_scale_lvls_skillsets_id');
            $table->text('name');
            $table->integer('score');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dict_col_scale_lvls_sets', function(Blueprint $table){
            $table->foreign('dict_col_scale_lvls_id')->references('id')->on('dict_col_scale_lvls');
            $table->foreign('dict_col_scale_lvls_skillsets_id')->references('id')->on('dict_col_scale_lvls_skillsets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_col_scale_lvls_sets');
    }
}
