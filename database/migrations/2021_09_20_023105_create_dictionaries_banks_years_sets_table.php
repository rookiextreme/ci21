<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionariesBanksYearsSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionaries_banks_years_sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('profiles_id');
            $table->integer('years_id');
            $table->string('title');
            $table->dateTime('tkh_mula', $precision = 0);
            $table->dateTime('tkh_tamat', $precision = 0);
            $table->integer('flag_publish');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->integer('ref_id');
            $table->timestamps();
        });

        Schema::table('dictionaries_banks_years_sets', function(Blueprint $table){
            $table->foreign('profiles_id')->references('id')->on('profiles');
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
        Schema::dropIfExists('dictionaries_banks_years_sets');
    }
}
