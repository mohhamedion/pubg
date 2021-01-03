<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_awards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('referrer_id')->unsigned();
            $table->integer('referral_id')->unsigned();
            $table->decimal('paid', 7, 2)->default(0);
            $table->timestamps();

            $table->foreign('referrer_id')
                ->references('id')
                ->on('users');
            $table->foreign('referral_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_awards');
    }
}
