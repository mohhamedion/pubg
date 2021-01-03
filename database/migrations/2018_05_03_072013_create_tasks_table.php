<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('package_name');
            $table->string('slug')->nullable();
            $table->string('title');
            $table->string('image_url');
            $table->string('description');
            $table->boolean('description_active')->default(false);
            $table->string('tracking_service')->nullable();
            $table->string('tracking_link')->nullable();
            $table->decimal('award', 7, 2)->default('0');
            $table->integer('type')->default(0);
            $table->integer('days')->default(1);
            $table->integer('limit')->default(0);
            $table->integer('promotion_type')->default(0);
            $table->string('country_group', 32)->nullable();
            $table->unsignedInteger('time_delay')->default(24);
            $table->unsignedInteger('duration')->default(30);
            $table->boolean('run_after')->default(false);
            $table->boolean('daily_budget')->default(false);
            $table->decimal('daily_budget_amount')->nullable();
            $table->integer('daily_budget_installs_limit')->nullable();
            $table->boolean('hourly_budget')->default(false);
            $table->decimal('hourly_budget_amount')->nullable();
            $table->integer('hourly_budget_installs_limit')->nullable();
            $table->decimal('price', 5, 2)->nullable();
            $table->decimal('install_price', 5, 2)->nullable();
            $table->boolean('custom_price')->default(false);
            $table->boolean('top')->default(0);
            $table->boolean('active')->default(0);
            $table->boolean('done')->default(0);
            $table->boolean('paid')->default(0);
            $table->boolean('moderated')->default(0);
            $table->boolean('accepted')->default(0);
            $table->boolean('canceled')->default(0);
            $table->integer('min_tasks_limit_active')->default(0);
            $table->integer('min_tasks_limit')->default(0);
            $table->text('keywords')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->enum('device_type', ['android', 'ios']);
            $table->timestamps();
            $table->timestamp('deferred_start')->nullable();
            $table->boolean('other_type')->default(0);

            $table->foreign('city_id')
                ->references('id')
                ->on('cities');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('created_by')
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
        Schema::dropIfExists('tasks');
    }
}
