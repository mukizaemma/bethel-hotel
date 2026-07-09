<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\TourActivityController;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.adminBase')]
class TourActivityIndex extends Component
{
    public function render()
    {
        return app(TourActivityController::class)->index();
    }
}
