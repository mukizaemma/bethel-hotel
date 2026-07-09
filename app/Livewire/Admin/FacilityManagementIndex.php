<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\FacilityManagementController;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.adminBase')]
class FacilityManagementIndex extends Component
{
    public function render()
    {
        $inner = app(FacilityManagementController::class)->index();

        return view('content-management.facilities.index', $inner->getData());
    }
}
