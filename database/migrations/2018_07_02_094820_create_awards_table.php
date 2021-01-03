<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('referral_system')->nullable();
            $table->decimal('amount', 5, 2);
            $table->integer('user_id')->unsigned();
            $table->integer('referral_id')->unsigned()->nullable();
            $table->integer('application_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('referral_id')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');

            $table->foreign('application_id')
                ->references('id')
                ->on('tasks')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('awards');
    }
}
