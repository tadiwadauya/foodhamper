<?php

namespace Database\Seeders;

use App\Models\HumberSetting;
use Illuminate\Database\Seeder;

class HumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = HumberSetting::create([
            'food_available' => 1,
            'meat_available' => 1,
            'food_record' => 0,
            'meat_record' => 0,
            'last_agent' => 1,
        ]);
        $setting->save();
    }
}
