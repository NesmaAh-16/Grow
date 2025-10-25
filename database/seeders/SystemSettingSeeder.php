<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'site_name'        => config('app.name', 'Grow Platform'), 
                'official_email'   => 'contact@grow.com',
                'default_locale'   => 'ar',
                'registration_open'=> true,
            ]
        );
    }
}
