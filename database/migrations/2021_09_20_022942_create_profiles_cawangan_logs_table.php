<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesCawanganLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_cawangan_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('profiles_id');
            $table->integer('neg_perseketuan')->nullable();
            $table->bigInteger('cawangan');
            $table->bigInteger('sektor');
            $table->bigInteger('bahagian');
            $table->bigInteger('unit');
            $table->bigInteger('penempatan');
            $table->string('cawangan_name', 300);
            $table->string('sektor_name', 300);
            $table->string('bahagian_name', 300);
            $table->string('unit_name', 300);
            $table->string('penempatan_name', 300);
            $table->year('tahun');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('profiles_cawangan_logs', function(Blueprint $table){
           $table->foreign('profiles_id')->references('id')->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles_cawangan_logs');
    }
}
