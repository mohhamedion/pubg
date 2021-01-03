<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tasks', function (Blueprint $table) {
            $table->increments('ud');
            $table->integer('user_id')->unsigned();
            $table->integer('task_id')->unsigned();
            $table->boolean('is_checked')->default(1);
            $table->tinyInteger('status')->default(0);
            $table->integer('times')->default(0);
            $table->integer('failed_times')->default(0);
            $table->boolean('is_available')->default(1);
            $table->integer('is_rating_available')->default(0);
            $table->boolean('is_accepted')->default(0);
            $table->boolean('is_installed')->default(0);
            $table->decimal('earned', 7, 2)->default(0);
            $table->boolean('is_done')->default(0);
            $table->text('cards')->nullable();
            $table->text('progress_bar')->nullable();
            $table->string('date')->nullable();
            $table->timestamp('last_open')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
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
        Schema::dropIfExists('users_task');
    }
}
