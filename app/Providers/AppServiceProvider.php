<?php

namespace App\Providers;

use App\Models\About;
use App\Models\Facility;
use App\Models\Room;
use App\Models\Setting;
use App\Models\WhyChooseUsItem;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

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

        // Share rooms and facilities globally for navigation
        View::composer('layouts.frontbase', function ($view) {
            $view->with('rooms', Room::where('status', 'Active')->oldest()->get());
            $view->with('facilities', Facility::where('status', 'Active')->oldest()->get());
            $view->with('setting', Setting::first());
            $view->with('about', About::first());
            $view->with(
                'whyChooseUsItems',
                WhyChooseUsItem::query()->orderBy('sort_order')->orderBy('id')->get()
            );
        });
    }
}
