<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_games', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('game_id')->unsigned();
            $table->integer('limit')->default(2);
            $table->integer('today_times')->default(0);
            $table->integer('times')->default(0);
            $table->decimal('earned', 7, 2)->default(0);
            $table->integer('best_score')->default(0);
            $table->boolean('is_available')->nullable();
            $table->string('last_open')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('game_id')
                ->references('id')
                ->on('games')
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
        Schema::dropIfExists('user_games');
    }
}
