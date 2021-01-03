<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('limit');
            $table->unsignedInteger('time_delay');
            $table->unsignedTinyInteger('days');
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->string('keywords')->nullable();
            $table->string('description');
            $table->string('description_active');
            $table->string('tracking_service')->nullable();
            $table->string('tracking_link')->nullable();
            $table->string('min_tasks_limit_active');
            $table->string('min_tasks_limit');
            $table->string('daily_budget');
            $table->string('daily_budget_amount')->nullable();
            $table->string('daily_budget_installs_limit')->nullable();
            $table->boolean('clicks');
            $table->decimal('price', 5, 2)->nullable();
            $table->boolean('custom_price')->default(false);
            $table->timestamps();

            $table->foreign('app_id')
                ->references('id')->on('tasks')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('country_id')
                ->references('id')->on('countries')
                ->onDelete('cascade');

            $table->foreign('city_id')
                ->references('id')->on('cities')
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
        Schema::dropIfExists('apps_logs');
    }
}
