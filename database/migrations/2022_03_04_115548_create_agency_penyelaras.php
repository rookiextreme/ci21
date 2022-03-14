<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgencyPenyelaras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_penyelaras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('agency_id');
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::table('agency_penyelaras',  function(Blueprint $table) {
            $table->foreign('agency_id')->references('id')->on('agency_hierarchy');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agency_penyelaras');
    }
}
