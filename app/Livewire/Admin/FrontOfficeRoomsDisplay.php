<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\FrontOfficeController;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.adminBase')]
class FrontOfficeRoomsDisplay extends Component
{
    public function render()
    {
        return app(FrontOfficeController::class)->roomsDisplay();
    }
}
