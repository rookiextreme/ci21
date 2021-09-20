<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScaleLvlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scale_lvls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('scale_lvls_types_id');
            $table->integer('years_id');
            $table->string('name');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('scale_lvls', function(Blueprint $table){
            $table->foreign('scale_lvls_types_id')->references('id')->on('scale_lvls_types');
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
        Schema::dropIfExists('scale_lvls');
    }
}
