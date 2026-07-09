<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Facility;
use App\Models\MeetingRoom;
use App\Models\Room;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [];

        $static = [
            ['loc' => route('home'), 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['loc' => route('about'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('rooms'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => route('facilities'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => route('gallery'), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => route('meetings-events'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => route('dining'), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('connect'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('our-team'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => route('reviews'), 'changefreq' => 'weekly', 'priority' => '0.6'],
            ['loc' => route('updates'), 'changefreq' => 'weekly', 'priority' => '0.6'],
            ['loc' => route('promotions'), 'changefreq' => 'weekly', 'priority' => '0.6'],
            ['loc' => route('activities'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => route('tours'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => route('spa-wellness'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => route('terms'), 'changefreq' => 'yearly', 'priority' => '0.3'],
            ['loc' => route('our-services'), 'changefreq' => 'monthly', 'priority' => '0.6'],
        ];

        foreach ($static as $entry) {
            $urls[] = $entry + ['lastmod' => now()->toAtomString()];
        }

        Room::query()
            ->where('status', 'Active')
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->oldest('id')
            ->get(['slug', 'updated_at'])
            ->each(function (Room $room) use (&$urls): void {
                $urls[] = [
                    'loc' => route('room', ['slug' => $room->slug]),
                    'lastmod' => optional($room->updated_at)->toAtomString() ?? now()->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            });

        Facility::query()
            ->where('status', 'Active')
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->oldest('id')
            ->get(['slug', 'updated_at'])
            ->each(function (Facility $facility) use (&$urls): void {
                $urls[] = [
                    'loc' => route('facility', ['slug' => $facility->slug]),
                    'lastmod' => optional($facility->updated_at)->toAtomString() ?? now()->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            });

        MeetingRoom::query()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->oldest('id')
            ->get(['slug', 'updated_at'])
            ->each(function (MeetingRoom $room) use (&$urls): void {
                $urls[] = [
                    'loc' => route('meetings-events.room', ['slug' => $room->slug]),
                    'lastmod' => optional($room->updated_at)->toAtomString() ?? now()->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                ];
            });

        Blog::query()
            ->where(function ($q): void {
                $q->where('status', 'published')
                    ->orWhere('publish', 1)
                    ->orWhere('publish', '1')
                    ->orWhere('publish', true);
            })
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->latest('updated_at')
            ->get(['slug', 'updated_at', 'published_at'])
            ->each(function (Blog $blog) use (&$urls): void {
                $urls[] = [
                    'loc' => route('update', ['slug' => $blog->slug]),
                    'lastmod' => optional($blog->updated_at ?? $blog->published_at)->toAtomString() ?? now()->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.5',
                ];
            });

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
