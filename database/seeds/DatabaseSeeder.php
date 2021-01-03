<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeed::class);
        $this->call(CountrySeed::class);
        $this->call(CitySeed::class);
        $this->call(UserSeed::class);
        $this->call(MarathonSeed::class);
        $this->call(LevelSeed::class);
        $this->call(LevelLimitSeed::class);
        $this->call(ReferralSeed::class);
        $this->call(SettingsSeed::class);
        $this->call(AppPricesSeed::class);
        $this->call(PaymentSystemsSeeder::class);
        $this->call(VideoSeed::class);
        $this->call(PartnerSeed::class);
        $this->call(CardTransactionSeed::class);
        //$this->call(TaskSeed::class);
        $this->call(QuizSeed::class);
        $this->call(UpdateQuizSeed::class);
        $this->call(QuizQuestionSeed::class);
        $this->call(GameSeed::class);
        $this->call(CreateTaskSeed::class);
        $this->call(ServiceRequestTypesSeeder::class);
        $this->call(PromocodeSeed::class);
        $this->call(UserLevelSeeder::class);
        $this->call(CardTransactionNominalSeed::class);
        $this->call(QuizImageSeeder::class);
        $this->call(GameImageSeeder::class);

    }
}
