<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\Eventpage;
use App\Models\HotelContact;
use App\Models\Setting;
use App\Models\WhyChooseUsItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * Applies Bethel Hotel (Rubengera) branding to an existing or fresh database.
 * Safe to re-run — uses updateOrCreate / targeted updates.
 */
class BethelHotelBrandingSeeder extends Seeder
{
    public function run(): void
    {
        $hotelName = 'Bethel Hotel';
        $address = 'Rubengera, Karongi District, Western Province, Rwanda';
        $phone = '+250 782 166 233';
        $email = 'centrebethel@ymail.com';
        $whatsapp = '250782166233';
        $whatsappMessage = "Hello {$hotelName}, I would like to enquire about:";
        $googlePlaceUrl = 'https://www.google.com/maps/search/Bethel+Hotel+Rubengera+Karongi+Rwanda';
        $googleEmbedUrl = 'https://maps.google.com/maps?q=Rubengera,Karongi,Rwanda&z=15&output=embed';

        $settingData = [
            'title' => $hotelName,
            'company' => $hotelName,
            'address' => $address,
            'phone' => $phone,
            'reception_phone' => $phone,
            'email' => $email,
            'star_rating' => 2,
            'quote' => 'Better be Safe Today',
            'logo' => '/bethel-logo.png',
            'donate' => '/bethel-logo.png',
            'google_map_embed' => $googleEmbedUrl,
            'google_place_url' => $googlePlaceUrl,
            'google_maps_embed_url' => $googleEmbedUrl,
            'whatsapp_e164' => $whatsapp,
            'whatsapp_default_message' => $whatsappMessage,
            'channel_contact_email' => $email,
        ];

        $setting = Schema::hasTable('settings') ? Setting::query()->first() : null;
        if (Schema::hasTable('settings')) {
            if ($setting) {
                $setting->update($settingData);
            } else {
                Setting::query()->create($settingData);
            }
        }

        $contactData = [
            'phone' => $phone,
            'email' => $email,
            'address' => 'Kibuye – Rubengera',
            'city' => 'Rubengera',
            'country' => 'Rwanda',
            'whatsapp' => $phone,
            'latitude' => -2.0790,
            'longitude' => 29.3480,
        ];

        if (Schema::hasTable('hotel_contacts')) {
            $contact = HotelContact::query()->first();
            if ($contact) {
                $contact->update($contactData);
            } else {
                HotelContact::query()->create($contactData);
            }
        }

        $aboutCopy = '<p>Bethel Hotel is a <strong>2-star hotel</strong> in the heart of <strong>Rubengera, Karongi</strong> — perfectly suited for <strong>workshops, seminars, and meetings</strong>. Our well-equipped meeting spaces, comfortable rooms, and attentive team make us the practical choice for trainings, church gatherings, and corporate retreats in Western Rwanda.</p>'
            .'<p>Enjoy our restaurant, complimentary Wi‑Fi, ample parking, and a peaceful setting just minutes from the shores of Lake Kivu. Whether you are here for a one-day workshop or an overnight stay, we offer affordable comfort with a welcoming atmosphere.</p>';

        $aboutData = [
            'title' => 'About Bethel Hotel',
            'subTitle' => 'Workshops, meetings & comfortable stays in Rubengera',
            'founderDescription' => $aboutCopy,
            'mission' => 'To provide affordable, comfortable accommodation and versatile meeting spaces for workshops, seminars, and events in Rubengera.',
            'vision' => 'Where comfort meets purpose — your trusted venue for workshops and meetings in Western Rwanda.',
        ];

        if (Schema::hasTable('abouts')) {
            $about = About::query()->first();
            if ($about) {
                $about->update($aboutData);
            } else {
                About::query()->create($aboutData);
            }
        }

        $eventData = [
            'title' => 'Workshops & Meetings',
            'description' => '<p>Host your next <strong>workshop, seminar, or meeting</strong> at Bethel Hotel in Rubengera. We offer flexible meeting rooms suited for trainings, church gatherings, and corporate events — with catering support, Wi‑Fi, and comfortable accommodation for your delegates.</p>'
                .'<p>Contact us to discuss room setup, catering, and group rates. Our team will help you plan a smooth, productive event.</p>',
        ];

        if (Schema::hasTable('eventpages')) {
            $event = Eventpage::query()->first();
            if ($event) {
                $event->update($eventData);
            } else {
                Eventpage::query()->create($eventData);
            }
        }

        $whyChooseUs = [
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

        if (! Schema::hasTable('why_choose_us_items')) {
            return;
        }

        foreach ($whyChooseUs as $row) {
            WhyChooseUsItem::updateOrCreate(
                ['title' => $row['title']],
                ['description' => $row['description'], 'sort_order' => $row['sort_order']]
            );
        }
    }
}
