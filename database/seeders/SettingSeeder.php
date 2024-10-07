<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'github_link', 'value' => null, 'type' => 'social_media'],
            ['key' => 'linkedin_link', 'value' => null, 'type' => 'social_media'],
            ['key' => 'telegram_link', 'value' => null, 'type' => 'social_media'],
            ['key' => 'email_link', 'value' => null, 'type' => 'social_media'],
            ['key' => 'instagram_link', 'value' => null, 'type' => 'social_media'],
            ['key' => 'x_link', 'value' => null, 'type' => 'social_media'],
            ['key' => 'facebook_link', 'value' => null, 'type' => 'social_media'],
        ];
        Setting::insert($settings);
    }
}
