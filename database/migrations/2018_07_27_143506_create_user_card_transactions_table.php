<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCardTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_card_transactions', function (Blueprint $table) {
            $table->increments('ud');
            $table->integer('user_id')->unsigned();
            $table->integer('card_transaction_id')->unsigned();
            $table->decimal('amount', 7, 2)->default(0);
            $table->boolean('used')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('card_transaction_id')
                ->references('id')
                ->on('card_transactions')
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
        Schema::dropIfExists('user_card_transactions');
    }
}
