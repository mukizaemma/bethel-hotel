<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            // Room Amenities
            ['title' => 'Air Conditioning', 'icon' => 'fa-snowflake'],
            ['title' => 'Heating', 'icon' => 'fa-fire'],
            ['title' => 'Wi-Fi', 'icon' => 'fa-wifi'],
            ['title' => 'TV', 'icon' => 'fa-tv'],
            ['title' => 'Cable TV', 'icon' => 'fa-satellite-dish'],
            ['title' => 'Satellite Channels', 'icon' => 'fa-satellite'],
            ['title' => 'Flat-screen TV', 'icon' => 'fa-tv'],
            ['title' => 'Private Bathroom', 'icon' => 'fa-bath'],
            ['title' => 'Shower', 'icon' => 'fa-shower'],
            ['title' => 'Bathtub', 'icon' => 'fa-bath'],
            ['title' => 'Hair Dryer', 'icon' => 'fa-wind'],
            ['title' => 'Free Toiletries', 'icon' => 'fa-pump-soap'],
            ['title' => 'Towels', 'icon' => 'fa-rug'],
            ['title' => 'Linen', 'icon' => 'fa-bed'],
            ['title' => 'Wardrobe/Closet', 'icon' => 'fa-wardrobe'],
            ['title' => 'Desk', 'icon' => 'fa-desktop'],
            ['title' => 'Seating Area', 'icon' => 'fa-couch'],
            ['title' => 'Sofa', 'icon' => 'fa-couch'],
            ['title' => 'Dining Area', 'icon' => 'fa-utensils'],
            ['title' => 'Kitchen', 'icon' => 'fa-kitchen-set'],
            ['title' => 'Kitchenette', 'icon' => 'fa-kitchen-set'],
            ['title' => 'Refrigerator', 'icon' => 'fa-refrigerator'],
            ['title' => 'Microwave', 'icon' => 'fa-microwave'],
            ['title' => 'Coffee Machine', 'icon' => 'fa-coffee'],
            ['title' => 'Electric Kettle', 'icon' => 'fa-kettle'],
            ['title' => 'Minibar', 'icon' => 'fa-wine-bottle'],
            ['title' => 'Safe', 'icon' => 'fa-vault'],
            ['title' => 'Telephone', 'icon' => 'fa-phone'],
            ['title' => 'Alarm Clock', 'icon' => 'fa-clock'],
            ['title' => 'Iron', 'icon' => 'fa-iron'],
            ['title' => 'Ironing Facilities', 'icon' => 'fa-iron'],
            ['title' => 'Clothes Rack', 'icon' => 'fa-tshirt'],
            ['title' => 'Extra Long Beds', 'icon' => 'fa-bed'],
            ['title' => 'Soundproofing', 'icon' => 'fa-volume-mute'],
            ['title' => 'City View', 'icon' => 'fa-city'],
            ['title' => 'Garden View', 'icon' => 'fa-tree'],
            ['title' => 'Mountain View', 'icon' => 'fa-mountain'],
            ['title' => 'Pool View', 'icon' => 'fa-swimming-pool'],
            ['title' => 'Balcony', 'icon' => 'fa-door-open'],
            ['title' => 'Terrace', 'icon' => 'fa-home'],
            ['title' => 'Private Entrance', 'icon' => 'fa-door-open'],
            ['title' => 'Interconnecting Rooms', 'icon' => 'fa-door-open'],
            ['title' => 'Smoking Allowed', 'icon' => 'fa-smoking'],
            ['title' => 'Non-Smoking', 'icon' => 'fa-ban'],
            ['title' => 'Elevator Access', 'icon' => 'fa-elevator'],
            ['title' => 'Room Service', 'icon' => 'fa-bell-concierge'],
            ['title' => 'Housekeeping', 'icon' => 'fa-broom'],
            ['title' => 'Laundry Service', 'icon' => 'fa-shirt'],
            ['title' => 'Concierge Service', 'icon' => 'fa-bell-concierge'],
            ['title' => 'Luggage Storage', 'icon' => 'fa-suitcase'],
            ['title' => 'Airport Shuttle', 'icon' => 'fa-shuttle-van'],
            ['title' => 'Free Parking', 'icon' => 'fa-parking'],
            ['title' => 'Pet Friendly', 'icon' => 'fa-paw'],
            ['title' => 'Family Rooms', 'icon' => 'fa-users'],
            ['title' => 'Extra Beds Available', 'icon' => 'fa-bed'],
            ['title' => 'Playground', 'icon' => 'fa-slide'],
            ['title' => 'Game Room', 'icon' => 'fa-gamepad'],
            ['title' => 'Fitness Center', 'icon' => 'fa-dumbbell'],
            ['title' => 'Spa', 'icon' => 'fa-spa'],
            ['title' => 'Massage', 'icon' => 'fa-hand-sparkles'],
            ['title' => 'Sauna', 'icon' => 'fa-hot-tub'],
            ['title' => 'Hot Water', 'icon' => 'fa-hot-tub'],
            ['title' => 'Swimming Pool', 'icon' => 'fa-swimming-pool'],
            ['title' => 'Indoor Pool', 'icon' => 'fa-swimming-pool'],
            ['title' => 'Outdoor Pool', 'icon' => 'fa-swimming-pool'],
            ['title' => 'Bicycle Rental', 'icon' => 'fa-bicycle'],
            ['title' => 'Car Rental', 'icon' => 'fa-car'],
            ['title' => 'Restaurant', 'icon' => 'fa-utensils'],
            ['title' => 'Bar', 'icon' => 'fa-wine-glass'],
            ['title' => 'Snack Bar', 'icon' => 'fa-cookie'],
            ['title' => 'Breakfast Included', 'icon' => 'fa-coffee'],
            ['title' => 'Breakfast Available', 'icon' => 'fa-coffee'],
            ['title' => 'Half Board', 'icon' => 'fa-utensils'],
            ['title' => 'Full Board', 'icon' => 'fa-utensils'],
            ['title' => 'All Inclusive', 'icon' => 'fa-utensils'],
            ['title' => 'Business Center', 'icon' => 'fa-briefcase'],
            ['title' => 'Meeting Rooms', 'icon' => 'fa-users'],
            ['title' => 'Conference Facilities', 'icon' => 'fa-chalkboard'],
            ['title' => 'Banquet Hall', 'icon' => 'fa-building'],
            ['title' => 'Gift Shop', 'icon' => 'fa-gift'],
            ['title' => 'Souvenir Shop', 'icon' => 'fa-shopping-bag'],
            ['title' => 'Library', 'icon' => 'fa-book'],
            ['title' => 'Chapel', 'icon' => 'fa-church'],
            ['title' => 'Temple', 'icon' => 'fa-place-of-worship'],
            ['title' => '24-Hour Front Desk', 'icon' => 'fa-clock'],
            ['title' => 'Express Check-in/Check-out', 'icon' => 'fa-clock'],
            ['title' => 'Late Check-out', 'icon' => 'fa-clock'],
            ['title' => 'Early Check-in', 'icon' => 'fa-clock'],
            ['title' => 'Key Card Access', 'icon' => 'fa-key'],
            ['title' => 'Security', 'icon' => 'fa-shield'],
            ['title' => 'Fire Extinguisher', 'icon' => 'fa-fire-extinguisher'],
            ['title' => 'Smoke Detector', 'icon' => 'fa-smoking'],
            ['title' => 'First Aid Kit', 'icon' => 'fa-kit-medical'],
            ['title' => 'Emergency Exit', 'icon' => 'fa-door-open'],
            ['title' => 'Fire Alarm', 'icon' => 'fa-bell'],
            ['title' => 'Security Alarm', 'icon' => 'fa-shield'],
            ['title' => 'CCTV', 'icon' => 'fa-video'],
            ['title' => 'Lockers', 'icon' => 'fa-lock'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::updateOrCreate(
                ['title' => $amenity['title']],
                $amenity
            );
        }
    }
}
