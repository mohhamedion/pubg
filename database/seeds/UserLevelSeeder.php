<?php

use Illuminate\Database\Seeder;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_levels')->insert([
            'user_id' => 3,
            'level' => 1,
            'stars' => 1,
            'task' => serialize([
                1,
                50,
                1,
            ]),
            'video' => serialize([
                1,
                300,
                1,
            ]),
            'partner' => serialize([
                1,
                5,
                1,
            ]),
            'referral' => serialize([
                1,
                3,
                1,
            ]),
        ]);
        DB::table('user_levels')->insert([
            'user_id' => 4,
            'level' => 2,
            'stars' => 2,
            'task' => serialize([
                2,
                100,
                2,
            ]),
            'video' => serialize([
                2,
                600,
                2,
            ]),
            'partner' => serialize([
                2,
                10,
                2,
            ]),
            'referral' => serialize([
                2,
                25,
                2,
            ]),
        ]);
        DB::table('user_levels')->insert([
            'user_id' => 5,
            'level' => 3,
            'stars' => 3,
            'task' => serialize([
                1,
                50,
                1,
            ]),
            'video' => serialize([
                2,
                600,
                2,
            ]),
            'partner' => serialize([
                3,
                15,
                3,
            ]),
            'referral' => serialize([
                4,
                25,
                4,
            ]),
        ]);
        DB::table('user_levels')->insert([
            'user_id' => 6,
            'level' => 4,
            'stars' => 4,
            'task' => serialize([
                1,
                50,
                1,
            ]),
            'video' => serialize([
                2,
                600,
                2,
            ]),
            'partner' => serialize([
                3,
                15,
                3,
            ]),
            'referral' => serialize([
                4,
                25,
                4,
            ]),
        ]);
        DB::table('user_levels')->insert([
            'user_id' => 7,
            'level' => 5,
            'stars' => 5,
            'task' => serialize([
                1,
                50,
                1,
            ]),
            'video' => serialize([
                2,
                600,
                2,
            ]),
            'partner' => serialize([
                3,
                15,
                3,
            ]),
            'referral' => serialize([
                4,
                25,
                4,
            ]),
        ]);
    }
}
