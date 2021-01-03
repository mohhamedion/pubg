<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->decimal( 'exchange_rate_rub_uah', 5, 2)->default('2.45');
            $table->decimal( 'uc_rate', 5, 2)->default('100');
            $table->decimal( 'points_rate', 5, 2)->default('10');
            $table->decimal( 'popularity_rate', 11, 2)->default('100');
            $table->decimal( 'version', 5, 1)->default('1');
            $table->decimal( 'award_standard_promo_code', 5, 2)->default('50');
            $table->decimal( 'award_partner_promo_code', 5, 2)->default('100');
            //$table->integer('application_downloads_min_limit')->default(10);
            //$table->decimal( 'withdraw_limit', 5, 2)->default('117.55');
            //$table->integer( 'withdraw_commission')->default(18);
           // $table->integer( 'transfer_commission')->default(15);
            //$table->integer( 'referral_first_balance_limit')->default(50);
            //$table->integer( 'referral_first_reward_percentage')->default(30);
            //$table->integer( 'referral_second_balance_limit')->default(100);
            //$table->integer( 'referral_second_reward_percentage')->default(30);
           // $table->integer( 'referral_second_reward_time')->default(3600);
            $table->string( 'task_reminder_text');
            $table->decimal( 'award_standard_task_video', 5, 2)->default('0.05');
            $table->decimal( 'award_standard_task_vk_group', 5, 2)->default('2.0');

            $table->integer('application_downloads_min_limit')->unsigned()->default(1);
            $table->decimal('balance_replenishment_min', 6, 2)->unsigned()->default(1);
            //$table->string('video_tour_frame');
            $table->text('agreement_ru')->nullable();
            $table->text('agreement_en')->nullable();
            $table->decimal('review_price', 5, 2)->default(0);
            $table->decimal('review_comment_price', 5, 2)->default(0);
            $table->string('review_keywords')->nullable();
            $table->unsignedTinyInteger('review_min_task_run_limit')->default(1);
            $table->decimal('description_price', 5, 2)->default(1);

            $table->decimal('withdraw_limit', 5, 2)->default(288 / 2.45);
            $table->integer('withdraw_commission')->default(18);
            $table->integer('transfer_commission')->default(15);

            // android prices
            $prefix = 'android_';
            //$table->decimal($prefix . 'single_price_user', 5, 2)->default('1.00');
            $table->decimal($prefix . 'daily_price_first_user', 5, 2)->default('2.00');
            $table->decimal($prefix . 'daily_price_second_user', 5, 2)->default('1.00');
            $table->decimal($prefix . 'daily_price_third_user', 5, 2)->default('1.00');
            $table->decimal($prefix . 'daily_price_fourth_user', 5, 2)->default('1.00');
            //$table->decimal($prefix . 'single_price_manager', 5, 2)->default('2.00');
            $table->decimal($prefix . 'daily_price_first_manager', 5, 2)->default('4.00');
            // ios prices
            /*$prefix = 'ios_';
            $table->decimal($prefix . 'install_price', 5, 2)->default('1.00');
            $table->decimal($prefix . 'additional_install_price', 5, 2)->default('2.00');
            $table->decimal($prefix . 'price', 5, 2)->default('2.00');
            $table->decimal($prefix . 'additional_price', 5, 2)->default('4.00');*/

            //price for top
            $table->decimal('top_price', 5, 2)->default('1.00');
            $table->decimal('run_after_price', 5, 2)->default('6.00');
            $table->text('cashback')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');
    }
}
