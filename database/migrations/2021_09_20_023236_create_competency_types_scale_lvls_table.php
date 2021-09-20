<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetencyTypesScaleLvlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competency_types_scale_lvls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('competency_types_id');
            $table->integer('scale_lvls_id');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('competency_types_scale_lvls', function(Blueprint $table){
            $table->foreign('competency_types_id')->references('id')->on('competency_types');
            $table->foreign('scale_lvls_id')->references('id')->on('scale_lvls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competency_types_scale_lvls');
    }
}
