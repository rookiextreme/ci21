<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScaleLvlsSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scale_lvls_sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('scale_lvls_id');
            $table->integer('scale_lvls_skillsets_id');
            $table->string('name');
            $table->integer('score');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('scale_lvls_sets', function(Blueprint $table){
            $table->foreign('scale_lvls_id')->references('id')->on('scale_lvls');
            $table->foreign('scale_lvls_skillsets_id')->references('id')->on('scale_lvls_skillsets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scale_lvls_sets');
    }
}
