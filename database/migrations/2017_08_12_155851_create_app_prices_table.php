<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppPricesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_prices', function (Blueprint $table) {
            $table->increments('id');

            $table->decimal('android_24h_price_first_user', 5, 2);
            $table->decimal('android_24h_price_second_user', 5, 2);
            $table->decimal('android_24h_price_third_user', 5, 2);
            $table->decimal('android_24h_price_fourth_user', 5, 2);
            $table->decimal('android_24h_price_first_manager', 5, 2);
            $table->decimal('android_24h_price_second_manager', 5, 2);
            $table->decimal('android_24h_price_third_manager', 5, 2);
            $table->decimal('android_24h_price_fourth_manager', 5, 2);
            $table->decimal('ios_24h_price_first_user', 5, 2);
            $table->decimal('ios_24h_price_second_user', 5, 2);
            $table->decimal('ios_24h_price_third_user', 5, 2);
            $table->decimal('ios_24h_price_fourth_user', 5, 2);
            $table->decimal('ios_24h_price_first_manager', 5, 2);
            $table->decimal('ios_24h_price_second_manager', 5, 2);
            $table->decimal('ios_24h_price_third_manager', 5, 2);
            $table->decimal('ios_24h_price_fourth_manager', 5, 2);

            $table->decimal('android_48h_price_first_user', 5, 2);
            $table->decimal('android_48h_price_second_user', 5, 2);
            $table->decimal('android_48h_price_third_user', 5, 2);
            $table->decimal('android_48h_price_fourth_user', 5, 2);
            $table->decimal('android_48h_price_first_manager', 5, 2);
            $table->decimal('android_48h_price_second_manager', 5, 2);
            $table->decimal('android_48h_price_third_manager', 5, 2);
            $table->decimal('android_48h_price_fourth_manager', 5, 2);
            $table->decimal('ios_48h_price_first_user', 5, 2);
            $table->decimal('ios_48h_price_second_user', 5, 2);
            $table->decimal('ios_48h_price_third_user', 5, 2);
            $table->decimal('ios_48h_price_fourth_user', 5, 2);
            $table->decimal('ios_48h_price_first_manager', 5, 2);
            $table->decimal('ios_48h_price_second_manager', 5, 2);
            $table->decimal('ios_48h_price_third_manager', 5, 2);
            $table->decimal('ios_48h_price_fourth_manager', 5, 2);

            $table->decimal('android_72h_price_first_user', 5, 2);
            $table->decimal('android_72h_price_second_user', 5, 2);
            $table->decimal('android_72h_price_third_user', 5, 2);
            $table->decimal('android_72h_price_fourth_user', 5, 2);
            $table->decimal('android_72h_price_first_manager', 5, 2);
            $table->decimal('android_72h_price_second_manager', 5, 2);
            $table->decimal('android_72h_price_third_manager', 5, 2);
            $table->decimal('android_72h_price_fourth_manager', 5, 2);
            $table->decimal('ios_72h_price_first_user', 5, 2);
            $table->decimal('ios_72h_price_second_user', 5, 2);
            $table->decimal('ios_72h_price_third_user', 5, 2);
            $table->decimal('ios_72h_price_fourth_user', 5, 2);
            $table->decimal('ios_72h_price_first_manager', 5, 2);
            $table->decimal('ios_72h_price_second_manager', 5, 2);
            $table->decimal('ios_72h_price_third_manager', 5, 2);
            $table->decimal('ios_72h_price_fourth_manager', 5, 2);

            $table->decimal('other_price', 5, 2)->default(10);
            $table->decimal('other_price_keywords', 5, 2)->default(15);

            $table->decimal('other_type_price', 5, 2)->default(10);
            $table->decimal('other_type_price_keywords', 5, 2)->default(15);

            $table->decimal('android_30s_price_user', 5, 2)->default(1);
            $table->decimal('android_60s_price_user', 5, 2)->default(2);
            $table->decimal('android_120s_price_user', 5, 2)->default(3);
            $table->decimal('android_300s_price_user', 5, 2)->default(4);

            $table->decimal('android_30s_price_manager', 5, 2)->default(2);
            $table->decimal('android_60s_price_manager', 5, 2)->default(3);
            $table->decimal('android_120s_price_manager', 5, 2)->default(4);
            $table->decimal('android_300s_price_manager', 5, 2)->default(5);

            $table->decimal('android_install_price_user', 5, 2)->default(2);

            $table->decimal('android_install_price_manager', 5, 2)->default(4);

            $table->timestamps();
        });

       /* Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'android_daily_price_first_user',
                'android_daily_price_second_user',
                'android_daily_price_third_user',
                'android_daily_price_fourth_user',
                'android_daily_price_first_manager',
                'android_daily_price_second_manager',
                'android_daily_price_third_manager',
                'android_daily_price_fourth_manager',
                'ios_daily_price_first_user',
                'ios_daily_price_second_user',
                'ios_daily_price_third_user',
                'ios_daily_price_fourth_user',
                'ios_daily_price_first_manager',
                'ios_daily_price_second_manager',
                'ios_daily_price_third_manager',
                'ios_daily_price_fourth_manager',
            ]);
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_prices');
    }
}
