<?php

namespace App\Livewire\Public;

use App\Services\PublicWebsiteData;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontbase')]
class AboutPage extends Component
{
    public function render()
    {
        return view('frontend.about', PublicWebsiteData::about());
    }
}
