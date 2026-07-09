<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,           // Super Admin (seeded), Admin, Normal User
            SuperAdminSeeder::class,      // Creates super admin user
            CountrySeeder::class,         // Seeds common countries (optional - for user profiles)
            AmenitySeeder::class,         // Seeds 150+ hotel amenities
            HotelSettingSeeder::class,    // Creates default hotel settings
            WhyChooseUsItemSeeder::class, // Default “Why choose us” points (optional; safe to re-run)
            BethelHotelBrandingSeeder::class, // Bethel Hotel Rubengera branding (safe to re-run)
        ]);
    }
}
