<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\ContentManagementController;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.adminBase')]
class ContentManagementSeo extends Component
{
    public function render()
    {
        return app(ContentManagementController::class)->seoData();
    }
}
