<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\ServiceManagementController;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.adminBase')]
class ServiceManagementIndex extends Component
{
    public function render()
    {
        return app(ServiceManagementController::class)->index();
    }
}
