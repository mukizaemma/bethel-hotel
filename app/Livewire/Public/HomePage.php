<?php

namespace App\Livewire\Public;

use App\Services\PublicWebsiteData;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontbase', ['showCookiePopup' => false])]
class HomePage extends Component
{
    public function render()
    {
        return view('frontend.home', PublicWebsiteData::home());
    }
}
