<?php

namespace App\Livewire\Account;

use App\Models\Booking;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.account')]
#[Title('Booking details')]
class AccountBookingShow extends Component
{
    public Booking $booking;

    public function mount(Booking $booking): void
    {
        abort_unless(auth()->user()->ownsBooking($booking), 403);
        $this->booking = $booking->load(['room', 'facility', 'tourActivity', 'assignedRoom']);
    }

    public function render()
    {
        return view('livewire.account.account-booking-show');
    }
}
