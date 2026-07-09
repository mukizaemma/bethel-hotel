<?php

namespace App\Livewire\Public;

use App\Services\PublicWebsiteData;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontbase')]
class SpaWellnessPage extends Component
{
    public function render()
    {
        return view('frontend.spa-wellness', PublicWebsiteData::spaWellness());
    }
}
