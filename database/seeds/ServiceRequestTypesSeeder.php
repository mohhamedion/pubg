<?php

use App\Models\ServiceRequestType;
use Illuminate\Database\Seeder;

class ServiceRequestTypesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (ServiceRequestType::TYPES as $type) {
            ServiceRequestType::query()->create([
                'name' => $type,
            ]);
        }
    }
}
