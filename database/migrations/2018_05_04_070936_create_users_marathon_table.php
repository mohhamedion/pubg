<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersMarathonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_marathon', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('marathon_id')->unsigned();
            $table->integer('times')->default(0);
            $table->boolean('failed')->default(0);
            $table->boolean('is_available')->default(0);
            $table->boolean('done')->default(0);
            $table->string('last_open')->nullable();
            $table->integer('user_current_day')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('marathon_id')
                ->references('id')
                ->on('marathons')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_marathon');
    }
}
