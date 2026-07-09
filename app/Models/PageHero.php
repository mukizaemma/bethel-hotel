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

    /**
     * Get hero by page slug
     */
    public static function getBySlug($slug)
    {
        try {
            // Check if table exists first
            if (!\Schema::hasTable('page_heroes')) {
                return null;
            }
            
            $hero = self::where('page_slug', $slug)->first();
            
            // If hero doesn't exist, create it
            if (!$hero) {
                $definitions = config('page_heroes', []);
                $pageNames = collect($definitions)
                    ->mapWithKeys(fn ($meta, $key) => [$key => $meta['label']])
                    ->all();

                try {
                    $hero = self::create([
                        'page_slug' => $slug,
                        'page_name' => $pageNames[$slug] ?? ucfirst(str_replace('-', ' ', $slug)),
                        'is_active' => true,
                    ]);
                } catch (\Exception $e) {
                    // If creation fails, return null
                    return null;
                }
            }
            
            // Only return if active
            return $hero->is_active ? $hero : null;
        } catch (\Exception $e) {
            // If any error occurs, return null to fallback to default
            return null;
        }
    }
}
