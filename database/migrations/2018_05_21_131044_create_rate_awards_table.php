<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRateAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_awards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('level');
            $table->decimal('task', 7, 2);
            $table->decimal('video', 7, 2);
            $table->decimal('partner', 7, 2);
            $table->decimal('referral', 7, 2);
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
        Schema::dropIfExists('rate_awards');
    }
}
