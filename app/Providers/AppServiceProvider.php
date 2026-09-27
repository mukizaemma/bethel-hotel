<?php

namespace App\Providers;

use App\Models\About;
use App\Models\Blog;
use App\Models\Facility;
use App\Models\HotelContact;
use App\Models\Room;
use App\Models\Setting;
use App\Models\Slide;
use App\Models\WhyChooseUsItem;
use App\Services\PublicWebsiteData;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Ensures helpers load even when Composer autoload "files" is stale on deploy (hotel_price, terms_content_html).
        require_once base_path('app/helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Livewire::useScriptTagAttributes(['defer' => true]);

        View::composer('layouts.frontbase', function ($view) {
            $view->with(PublicWebsiteData::layout());
        });

        $forgetPublicCache = static function () {
            PublicWebsiteData::forgetCaches();
        };

        foreach ([Room::class, Facility::class, Setting::class, About::class, WhyChooseUsItem::class, Slide::class, Blog::class, HotelContact::class] as $model) {
            $model::saved($forgetPublicCache);
            $model::deleted($forgetPublicCache);
        }
    }
}
