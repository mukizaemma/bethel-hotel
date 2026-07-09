<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\FrontOfficeController;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.adminBase')]
class FrontOfficeSalesReport extends Component
{
    public function render()
    {
        return app(FrontOfficeController::class)->salesReport(request());
    }
}
