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
            $table->integer('dict_bank_sets_id')->nullable();;
            $table->integer('years_id')->nullable();;
            $table->string('name');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('dict_bank_scale_lvls', function(Blueprint $table){
            $table->foreign('years_id')->references('id')->on('years');
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
        Schema::dropIfExists('dict_bank_scale_lvls');
    }
}
