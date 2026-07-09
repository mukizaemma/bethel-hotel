<?php

namespace App\Livewire\Account;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.account')]
#[Title('My bookings')]
class AccountBookings extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $bookings = auth()->user()
            ->accountBookingsQuery()
            ->with(['room', 'facility', 'tourActivity'])
            ->paginate(12);

        return view('livewire.account.account-bookings', compact('bookings'));
    }
}
