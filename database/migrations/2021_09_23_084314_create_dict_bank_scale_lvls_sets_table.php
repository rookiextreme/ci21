<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictBankScaleLvlsSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_bank_scale_lvls_sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dict_bank_scale_lvls_id');
            $table->integer('dict_bank_scale_lvls_skillsets_id');
            $table->string('name');
            $table->integer('score')->nullable();
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dict_bank_scale_lvls_sets', function(Blueprint $table){
            $table->foreign('dict_bank_scale_lvls_id')->references('id')->on('dict_bank_scale_lvls');
            $table->foreign('dict_bank_scale_lvls_skillsets_id')->references('id')->on('dict_bank_scale_lvls_skillsets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_bank_scale_lvls_sets');
    }
}
