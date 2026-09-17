<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\MediaLibraryController;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.adminBase')]
class ContentManagementMedia extends Component
{
    public function render()
    {
        return app(MediaLibraryController::class)->index();
    }
}
