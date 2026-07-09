@php
    $b = $booking;
@endphp
<div class="account-livewire-page">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <h1 class="h4 mb-0">Booking #{{ $b->id }}</h1>
        <a wire:navigate href="{{ route('account.bookings') }}" class="btn btn-outline-secondary btn-sm">← All bookings</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="stat-card p-4 mb-3">
                <h2 class="h6 text-uppercase text-muted mb-3">Reservation</h2>
                <dl class="row mb-0">
                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-{{ $b->status === 'confirmed' ? 'success' : ($b->status === 'pending' ? 'warning text-dark' : 'secondary') }}">{{ $b->status }}</span>
                    </dd>
                    <dt class="col-sm-4">Type</dt>
                    <dd class="col-sm-8 text-capitalize">{{ str_replace('_', ' ', $b->reservation_type) }}</dd>
                    @if($b->room)
                        <dt class="col-sm-4">Room</dt>
                        <dd class="col-sm-8">{{ $b->room->title }}</dd>
                    @endif
                    @if($b->facility)
                        <dt class="col-sm-4">Facility</dt>
                        <dd class="col-sm-8">{{ $b->facility->title }}</dd>
                    @endif
                    @if($b->tourActivity)
                        <dt class="col-sm-4">Tour / activity</dt>
                        <dd class="col-sm-8">{{ $b->tourActivity->title }}</dd>
                    @endif
                    @if($b->assignedRoom)
                        <dt class="col-sm-4">Assigned room</dt>
                        <dd class="col-sm-8">{{ $b->assignedRoom->title }}</dd>
                    @endif
                    <dt class="col-sm-4">Check-in</dt>
                    <dd class="col-sm-8">{{ $b->checkin_date ? $b->checkin_date->format('l, M j, Y') : '—' }}</dd>
                    <dt class="col-sm-4">Check-out</dt>
                    <dd class="col-sm-8">{{ $b->checkout_date ? $b->checkout_date->format('l, M j, Y') : '—' }}</dd>
                    <dt class="col-sm-4">Guests</dt>
                    <dd class="col-sm-8">
                        @if($b->adults !== null)
                            Adults: {{ $b->adults }}@if($b->children !== null), children: {{ $b->children }}@endif
                        @else
                            —
                        @endif
                    </dd>
                </dl>
            </div>

            @if($b->message)
                <div class="stat-card p-4 mb-3">
                    <h2 class="h6 text-uppercase text-muted mb-2">Your message</h2>
                    <p class="mb-0">{{ $b->message }}</p>
                </div>
            @endif

            @if($b->admin_reply)
                <div class="stat-card p-4 border-primary border-opacity-25">
                    <h2 class="h6 text-uppercase text-primary mb-2">Message from the hotel</h2>
                    <p class="mb-0">{!! nl2br(e($b->admin_reply)) !!}</p>
                    @if($b->admin_replied_at)
                        <small class="text-muted">{{ $b->admin_replied_at->format('M j, Y g:i a') }}</small>
                    @endif
                </div>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="stat-card p-4 mb-3">
                <h2 class="h6 text-uppercase text-muted mb-3">Guest details</h2>
                <p class="mb-1"><strong>Name:</strong> {{ $b->names }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $b->email ?? '—' }}</p>
                <p class="mb-0"><strong>Phone:</strong> {{ $b->phone ?? '—' }}</p>
            </div>
            <div class="stat-card p-4">
                <h2 class="h6 text-uppercase text-muted mb-3">Payment</h2>
                <p class="mb-1"><strong>Total:</strong> {{ number_format((float) $b->total_amount, 2) }}</p>
                <p class="mb-1"><strong>Paid:</strong> {{ number_format((float) $b->paid_amount, 2) }}</p>
                <p class="mb-1"><strong>Balance:</strong> {{ number_format((float) $b->balance_amount, 2) }}</p>
                <p class="mb-0"><strong>Payment status:</strong> <span class="text-capitalize">{{ $b->payment_status ?? '—' }}</span></p>
            </div>
        </div>
    </div>
</div>
