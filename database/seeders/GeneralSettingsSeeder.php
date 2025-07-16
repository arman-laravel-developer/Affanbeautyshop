<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class GeneralSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_settings')->insert([
            'site_name' => 'My Fashion Store',
            'mobile' => '0123456789',
            'email' => 'info@fashionstore.com',
            'address' => '123 Fashion Street, Dhaka, Bangladesh',
            'header_logo' => 'header_logo.png',
            'footer_logo' => 'footer_logo.png',
            'favicon' => 'favicon.ico',
            'payment_method_image' => 'payment_methods.png',
            'about_us_short' => 'Welcome to My Fashion Store, where fashion meets quality!',
            'facebook_url' => 'https://facebook.com/myfashionstore',
            'instagram_url' => 'https://instagram.com/myfashionstore',
            'youtube_url' => 'https://youtube.com/myfashionstore',
            'twitter_url' => 'https://twitter.com/myfashionstore',
            'pinterest_url' => 'https://pinterest.com/myfashionstore',
            'linkedin_url' => 'https://linkedin.com/myfashionstore',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
