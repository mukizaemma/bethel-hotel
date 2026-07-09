<?php

namespace App\Livewire\Public;

use App\Services\PublicWebsiteData;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontbase')]
class ReviewShowPage extends Component
{
    public int|string $id;

    public function mount(int|string $id): void
    {
        $this->id = $id;
    }

    public function render()
    {
        return view('frontend.review', PublicWebsiteData::review($this->id));
    }
}
