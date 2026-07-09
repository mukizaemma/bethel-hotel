<?php

namespace App\Livewire\Account;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.account')]
#[Title('Dashboard')]
class AccountDashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $base = $user->accountBookingsQuery();

        $totalBookings = (clone $base)->count();
        $pending = (clone $base)->where('status', 'pending')->count();
        $completed = (clone $base)->where('status', 'confirmed')->count();
        $recentBookings = (clone $base)
            ->with(['room', 'facility', 'tourActivity'])
            ->limit(8)
            ->get();

        return view('livewire.account.account-dashboard', [
            'totalBookings' => $totalBookings,
            'pending' => $pending,
            'completed' => $completed,
            'recentBookings' => $recentBookings,
        ]);
    }
}
