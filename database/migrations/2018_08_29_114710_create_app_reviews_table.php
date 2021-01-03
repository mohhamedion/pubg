<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppReviewsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_id');
            $table->unsignedInteger('rates');
            $table->unsignedInteger('comments');
            $table->string('keywords');
            $table->tinyInteger('stars')->default(5);
            $table->timestamps();

            $table->foreign('app_id')->references('id')->on('tasks')
                ->onUpdate('cascade')
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
        Schema::dropIfExists('app_reviews');
    }
}
