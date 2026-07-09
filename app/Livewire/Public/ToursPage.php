<?php

namespace App\Livewire\Public;

use App\Services\PublicWebsiteData;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontbase')]
class ToursPage extends Component
{
    public function render()
    {
        return view('frontend.tours', PublicWebsiteData::tours());
    }
}
