<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserBalanceReplenishments extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_balance_replenishments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ik_inv_id')->nullable();
            $table->string('ik_pm_no')->nullable();
            $table->integer('unitpayId')->nullable();
            $table->integer('app_id')->unsigned()->nullable();
            $table->decimal('amount', 9, 2);
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('app_id')
                ->references('id')->on('tasks')
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
        Schema::dropIfExists('user_balance_replenishments');
    }
}
