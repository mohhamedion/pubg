<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->integer('id', false, true);
            $table->integer('id_region');
            $table->integer('country_id')->unsigned();
            $table->integer('oid');
            $table->string('city_name_ru', 50);
            $table->string('city_name_en', 50);
            $table->primary('id');

            $table->foreign('country_id')
                ->references('id')
                ->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('city_');
    }
}
