<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Role::ROLES as $role) {
            Role::query()->firstOrCreate($role);
        }
    }
}
