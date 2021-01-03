<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('method')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('amount', 6, 2);
            $table->decimal('amount_clean', 6, 2)->nullable();
            $table->string('response')->nullable();
            $table->string('state')->nullable();
            $table->boolean('manual')->default(false);
            $table->boolean('locked')->default(true);
            $table->boolean('restored')->default(false);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::drop('transactions');
    }
}
