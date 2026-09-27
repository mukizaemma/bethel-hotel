<?php

namespace App\Livewire\Public;

use App\Services\PublicWebsiteData;
use Illuminate\Support\Facades\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontbase', ['showCookiePopup' => false])]
class HomePage extends Component
{
    public function render()
    {
        $data = PublicWebsiteData::home();
        View::share('lcpImage', $data['lcpImage'] ?? null);

        return view('frontend.home', $data);
    }
}
