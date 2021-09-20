<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobgroupYearsSetsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobgroup_years_sets_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('jobgroup_years_sets_id');
            $table->integer('dictionaries_banks_years_sets_items_id');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('jobgroup_years_sets_items', function(Blueprint $table){
            $table->foreign('jobgroup_years_sets_id')->references('id')->on('jobgroup_years_sets');
            $table->foreign('dictionaries_banks_years_sets_items_id')->references('id')->on('dictionaries_banks_years_sets_items');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobgroup_years_sets_items');
    }
}
