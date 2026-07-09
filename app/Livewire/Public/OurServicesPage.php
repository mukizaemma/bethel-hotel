<?php

namespace App\Livewire\Public;

use App\Services\PublicWebsiteData;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontbase')]
class OurServicesPage extends Component
{
    public function render()
    {
        return view('frontend.our-services', PublicWebsiteData::ourServices());
    }
}
