<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictBankMeasuringLvlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_bank_measuring_lvls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_bank_measuring_lvls');
    }
}
