<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::query()
            ->firstOrCreate([
                'name'              => 'Admin',
                'email'             => 'admin@mafia.com',
                'password'          => bcrypt('admin'),
                'token'             => str_random(),
                'promo_code_first'  => str_random(),
                'promo_code_second' => str_random(),
                'country_id' => 219,
            ]);
        // attaching admin role to user
        if ($admin) {
            $admin->roles()
                ->attach(Role::ADMIN_ROLE_ID);
        }

        // creating manager user
        /** @var User $manager */
        $manager = User::query()
            ->firstOrCreate([
                'name'              => 'manager',
                'email'             => 'moder@app.com',
                'password'          => bcrypt('123123'),
                'token'             => str_random(),
                'promo_code_first'  => str_random(),
                'promo_code_second' => str_random(),
                'country_id' => 219,
            ]);
        // attaching admin role to user
        if ($manager) {
            $manager->roles()
                ->attach(Role::MANAGER_ROLE_ID);
        }
        //create test user
        $testUser = User::query()
            ->firstOrCreate([
                'name'              => 'test1',
                'email'             => 'test@gmail.com',
                'password'          => bcrypt('123123'),
                'tel_number'        => '+3810664742281',
                'gender'            => 'female',
                'token'             => 'test1',
                'promo_code_first'  => str_random(),
                'promo_code_second' => str_random(),
                'new_version'       => 1,
                'balance'           => 1234.56,
                'referral_balance'  => 2345.67,
                'during'            => 3456.78,
                'paid'              => 4567.89,
                'referral_paid'     => 5678.90,

                'country_id' => 219,
            ]);
        // attaching user role to user
        if ($testUser) {
            $testUser->roles()
                ->attach(Role::USER_ROLE_ID);
        }
        //test referrals users
        $testUser = User::query()
            ->firstOrCreate([
                'name'              => 'test2',
                'email'             => 'test2@gmail.com',
                'password'          => bcrypt('123123'),
                'tel_number'        => '+3810664742281',
                'gender'            => 'female',
                'token'             => 'test2',
                'promo_code_first'  => str_random(),
                'promo_code_second' => str_random(),
                'new_version'       => 1,
                'balance'           => 1234.56,
                'referrer_id'       => 3,
                'country_id' => 219,
            ]);
        // attaching user role to user
        if ($testUser) {
            $testUser->roles()
                ->attach(Role::USER_ROLE_ID);
        }
        $testUser = User::query()
            ->firstOrCreate([
                'name'              => 'test3',
                'email'             => 'test3@gmail.com',
                'password'          => bcrypt('123123'),
                'tel_number'        => '+3810664742281',
                'gender'            => 'female',
                'token'             => 'test3',
                'promo_code_first'  => str_random(),
                'promo_code_second' => str_random(),
                'new_version'       => 1,
                'balance'           => 1234.56,
                'referrer_id'       => 4,
                'country_id' => 219,
            ]);
        // attaching user role to user
        if ($testUser) {
            $testUser->roles()
                ->attach(Role::USER_ROLE_ID);
        }
        $testUser = User::query()
            ->firstOrCreate([
                'name'              => 'test4',
                'email'             => 'test4@gmail.com',
                'password'          => bcrypt('123123'),
                'tel_number'        => '+3810664742281',
                'gender'            => 'female',
                'token'             => 'test4',
                'promo_code_first'  => str_random(),
                'promo_code_second' => str_random(),
                'new_version'       => 1,
                'balance'           => 1234.56,
                'referrer_id'       => 4,
                'country_id' => 219,
            ]);
        // attaching user role to user
        if ($testUser) {
            $testUser->roles()
                ->attach(Role::USER_ROLE_ID);
        }
        $testUser = User::query()
            ->firstOrCreate([
                'name'              => 'test5',
                'email'             => 'test5@gmail.com',
                'password'          => bcrypt('123123'),
                'tel_number'        => '+3810664742281',
                'gender'            => 'female',
                'token'             => 'test5',
                'promo_code_first'  => str_random(),
                'promo_code_second' => str_random(),
                'new_version'       => 1,
                'balance'           => 1234.56,
                'referrer_id'       => 3,
                'country_id' => 219,
            ]);
        // attaching user role to user
        if ($testUser) {
            $testUser->roles()
                ->attach(Role::USER_ROLE_ID);
        }
    }
}
