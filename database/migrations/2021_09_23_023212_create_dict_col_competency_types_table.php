<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictColCompetencyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_col_competency_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('flag');
            $table->integer('tech_discipline_flag')->nullable()->default(0);
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
        Schema::dropIfExists('dict_col_competency_types');
    }
}
