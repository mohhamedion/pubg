<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60)->nullable();
            //$table->unsignedInteger('age')->nullable();
            $table->string('age')->nullable();
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('tel_number',20)->nullable();
            $table->string('activation_code')->nullable();
            $table->decimal('balance', 20, 2)->default(0);
            $table->decimal('referral_balance', 7, 2)->default(0);
            $table->decimal('during', 7, 2)->default(0);
            $table->decimal('paid', 7, 2)->default(0);
            $table->decimal('referral_paid', 7, 2)->default(0);
            $table->string('token')->unique();
            $table->string('fcm_token')->nullable();
            $table->boolean('banned')->default(0);
            $table->integer('bans_reason')->default(0);
            $table->string('promo_code_first')->unique();
            $table->string('promo_code_second')->unique();
            $table->integer('referrer_id')->unsigned()->nullable();
            $table->integer('got_referral_bonus')->default(0);
            $table->integer('country_id')->unsigned()->nullable();
            $table->boolean('event')->default(0);
            $table->boolean('new_version')->default(0);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('referrer_id')
                ->references('id')
                ->on('users');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
