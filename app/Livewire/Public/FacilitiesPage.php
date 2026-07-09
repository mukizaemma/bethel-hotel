<?php

namespace App\Livewire\Public;

use App\Services\PublicWebsiteData;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontbase')]
class FacilitiesPage extends Component
{
    public function render()
    {
        return view('frontend.facilities', PublicWebsiteData::facilities());
    }
}
