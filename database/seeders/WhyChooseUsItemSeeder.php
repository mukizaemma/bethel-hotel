<?php

namespace Database\Seeders;

use App\Models\WhyChooseUsItem;
use Illuminate\Database\Seeder;

class WhyChooseUsItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Prime Location in Rubengera',
                'description' => 'Located in Rubengera, Karongi District — easy to reach and close to Lake Kivu, with convenient access for groups travelling from Kigali and across Western Rwanda.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Ideal for Workshops & Meetings',
                'description' => 'Fully equipped meeting spaces for trainings, seminars, church gatherings, and corporate events — with flexible layouts and attentive planning support.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Comfortable & Affordable Rooms',
                'description' => 'Well-maintained single, twin, and double rooms at competitive rates — perfect for delegates and travellers on a practical budget.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Faith-Based Environment',
                'description' => 'A peaceful and respectful atmosphere ideal for retreats, reflection, and community gatherings.',
                'sort_order' => 4,
            ],
            [
                'title' => 'Restaurant & Catering',
                'description' => 'On-site dining and catering options for workshops, meetings, and celebrations using locally sourced ingredients.',
                'sort_order' => 5,
            ],
            [
                'title' => 'Professional & Caring Staff',
                'description' => 'A dedicated team committed to making your workshop, meeting, or stay run smoothly from start to finish.',
                'sort_order' => 6,
            ],
            [
                'title' => 'Free Wi‑Fi & Parking',
                'description' => 'Complimentary internet throughout the property and ample parking for guests arriving by car or bus.',
                'sort_order' => 7,
            ],
            [
                'title' => 'Safe & Serene Setting',
                'description' => 'A secure, quiet environment surrounded by gardens — ideal for focused work and restful stays.',
                'sort_order' => 8,
            ],
        ];

        foreach ($items as $row) {
            WhyChooseUsItem::firstOrCreate(
                ['title' => $row['title']],
                ['description' => $row['description'], 'sort_order' => $row['sort_order']]
            );
        }
    }
}
