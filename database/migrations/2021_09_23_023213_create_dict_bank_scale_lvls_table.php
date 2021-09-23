<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictBankScaleLvlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_bank_scale_lvls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dict_bank_scale_lvls_types_id');
            $table->integer('years_id');
            $table->string('name');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dict_bank_scale_lvls', function(Blueprint $table){
            $table->foreign('dict_bank_scale_lvls_types_id')->references('id')->on('dict_bank_scale_lvls_types');
            $table->foreign('years_id')->references('id')->on('years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_bank_scale_lvls');
    }
}
