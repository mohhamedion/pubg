<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('amount', 8, 2);
            $table->text('features'); // Here store serialized array of features list
            $table->boolean('popular')->default(false);
            $table->timestamps();
        });

        Schema::create('user_special_offer_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('special_offer_id');
            $table->unsignedInteger('amount');
            $table->string('search_query');
            $table->string('package_name');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('special_offer_id')
                ->references('id')->on('special_offers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_special_offer_pivot');
        Schema::dropIfExists('special_offers');
    }
}
