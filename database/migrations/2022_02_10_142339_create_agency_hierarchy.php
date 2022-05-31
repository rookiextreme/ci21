<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgencyHierarchy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_hierarchy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('waran_code')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('agency_hierarchy',  function(Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('agency_hierarchy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agency_hierarchy');
    }
}
