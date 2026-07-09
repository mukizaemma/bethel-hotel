<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\AmenityController;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.adminBase')]
class AmenityIndex extends Component
{
    public function render()
    {
        return app(AmenityController::class)->index();
    }
}
