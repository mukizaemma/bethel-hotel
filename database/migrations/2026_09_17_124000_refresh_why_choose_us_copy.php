<?php

use App\Models\WhyChooseUsItem;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        if (! class_exists(WhyChooseUsItem::class)) {
            return;
        }

        $items = [
            [
                'title' => 'Comfortable & Affordable Rooms',
                'description' => 'Well-kept rooms at practical rates, with bed and breakfast available — a quiet home away from home for delegates and individual travellers.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Faith-Based Environment',
                'description' => 'A Christian-led hotel with a respectful, peaceful atmosphere — well suited to retreats, workshops, church gatherings, and restful personal stays.',
                'sort_order' => 4,
            ],
            [
                'title' => 'Restaurant & Catering',
                'description' => 'Bed and breakfast, varied dishes, cooking for events on site, and outside catering — all from the hotel kitchen.',
                'sort_order' => 5,
            ],
            [
                'title' => 'Free Wi‑Fi & Parking',
                'description' => 'Strong internet throughout the property and ample parking for guests arriving by car or bus.',
                'sort_order' => 7,
            ],
            [
                'title' => 'Safe & Serene Setting',
                'description' => 'A secure, quiet environment with gardens and green space — comfortable for focused work, community visits, and rest.',
                'sort_order' => 8,
            ],
            [
                'title' => 'Community Impact',
                'description' => 'Part of the hotel’s income supports health insurance, education, and development projects through the Rubengera Presbytery of the Presbyterian Church in Rwanda (EPR).',
                'sort_order' => 9,
            ],
        ];

        foreach ($items as $row) {
            WhyChooseUsItem::updateOrCreate(
                ['title' => $row['title']],
                ['description' => $row['description'], 'sort_order' => $row['sort_order']]
            );
        }
    }

    public function down(): void
    {
        WhyChooseUsItem::query()->where('title', 'Community Impact')->delete();
    }
};
