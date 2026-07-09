<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\UserManagementController;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.adminBase')]
class UserManagementIndex extends Component
{
    public function render()
    {
        return app(UserManagementController::class)->index();
    }
}
