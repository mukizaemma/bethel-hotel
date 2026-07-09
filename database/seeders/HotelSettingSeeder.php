<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class HotelSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        if (DB::table('settings')->count() > 0) {
            return;
        }

        $superAdmin = User::where('email', 'admin@iremetech.com')->first();

        DB::table('settings')->insert([
            'title' => 'Bethel Hotel',
            'company' => 'Bethel Hotel',
            'address' => 'Rubengera, Karongi District, Western Province, Rwanda',
            'phone' => '+250 782 166 233',
            'reception_phone' => '+250 782 166 233',
            'email' => 'centrebethel@ymail.com',
            'star_rating' => 2,
            'quote' => 'Better be Safe Today',
            'logo' => '/bethel-logo.png',
            'donate' => '/bethel-logo.png',
            'whatsapp_e164' => '250782166233',
            'whatsapp_default_message' => 'Hello Bethel Hotel, I would like to enquire about:',
            'channel_contact_email' => 'centrebethel@ymail.com',
            'facebook' => null,
            'instagram' => null,
            'twitter' => null,
            'youtube' => null,
            'linkedin' => null,
            'linktree' => null,
            'user_id' => $superAdmin ? $superAdmin->id : 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
