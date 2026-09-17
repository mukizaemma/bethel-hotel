<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class PageHero extends Model
{
    use HasFactory;

    protected $table = 'page_heroes';

    protected $fillable = [
        'page_slug',
        'page_name',
        'background_image',
        'caption',
        'description',
        'is_active',
    ];

    public static function defaultHero(): ?self
    {
        if (! Schema::hasTable('page_heroes')) {
            return null;
        }

        return self::query()->where('page_slug', 'default')->first();
    }

    /**
     * Hero for a public page. If that page has no background image, the default
     * header image is used until the admin uploads one for this page.
     */
    public static function getBySlug($slug)
    {
        try {
            if (! Schema::hasTable('page_heroes')) {
                return null;
            }

            $definitions = config('page_heroes', []);
            $hero = self::query()->where('page_slug', $slug)->first();

            if (! $hero && isset($definitions[$slug])) {
                try {
                    $hero = self::create([
                        'page_slug' => $slug,
                        'page_name' => $definitions[$slug]['label'] ?? ucfirst(str_replace('-', ' ', $slug)),
                        'is_active' => true,
                    ]);
                } catch (\Exception $e) {
                    $hero = null;
                }
            }

            $default = $slug === 'default' ? $hero : self::defaultHero();

            if ($slug === 'default') {
                return ($hero && $hero->is_active) ? $hero : null;
            }

            if (! $hero || ! $hero->is_active) {
                return ($default && $default->is_active && filled($default->background_image)) ? $default : null;
            }

            if (! filled($hero->background_image) && $default && $default->is_active && filled($default->background_image)) {
                $hero->setAttribute('background_image', $default->background_image);
                $hero->setAttribute('uses_default_image', true);
            }

            return $hero;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function imageUrl(): string
    {
        $path = ltrim((string) $this->background_image, '/');
        if ($path === '') {
            return '';
        }

        return asset('storage/'.$path);
    }
}
