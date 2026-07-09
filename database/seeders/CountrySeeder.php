<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'Rwanda', 'code' => 'RW'],
            ['name' => 'Kenya', 'code' => 'KE'],
            ['name' => 'Uganda', 'code' => 'UG'],
            ['name' => 'Tanzania', 'code' => 'TZ'],
            ['name' => 'Burundi', 'code' => 'BI'],
            ['name' => 'United States', 'code' => 'US'],
            ['name' => 'United Kingdom', 'code' => 'GB'],
            ['name' => 'Canada', 'code' => 'CA'],
            ['name' => 'France', 'code' => 'FR'],
            ['name' => 'Germany', 'code' => 'DE'],
            ['name' => 'Belgium', 'code' => 'BE'],
            ['name' => 'Netherlands', 'code' => 'NL'],
            ['name' => 'South Africa', 'code' => 'ZA'],
            ['name' => 'Nigeria', 'code' => 'NG'],
            ['name' => 'Ghana', 'code' => 'GH'],
            ['name' => 'Ethiopia', 'code' => 'ET'],
            ['name' => 'India', 'code' => 'IN'],
            ['name' => 'China', 'code' => 'CN'],
            ['name' => 'Japan', 'code' => 'JP'],
            ['name' => 'Australia', 'code' => 'AU'],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['code' => $country['code']],
                $country
            );
        }
    }
}
