<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('profiles_id');
            $table->integer('dict_bank_sets_id');
            $table->integer('penyelia_profiles_id');
            $table->integer('dict_bank_jobgroup_sets_id');
            $table->integer('status');
            $table->timestamps();
        });

        Schema::table('penilaians', function(Blueprint $table){
            $table->foreign('profiles_id')->references('id')->on('profiles');
            $table->foreign('dict_bank_sets_id')->references('id')->on('dict_bank_sets');
            $table->foreign('penyelia_profiles_id')->references('id')->on('profiles');
            $table->foreign('dict_bank_jobgroup_sets_id')->references('id')->on('dict_bank_jobgroup_sets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaians');
    }
}
