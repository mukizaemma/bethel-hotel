<div class="account-livewire-page">
    <h1 class="h4 mb-4">My bookings</h1>

    <div class="stat-card p-4">
        @if($bookings->isEmpty())
            <div class="text-center text-muted py-5">
                <i class="fa fa-calendar fa-3x mb-3 opacity-25"></i>
                <p class="mb-3">You have no reservations yet.</p>
                <a wire:navigate href="{{ route('connect') }}" class="btn btn-primary me-2">Book now</a>
                <a wire:navigate href="{{ route('rooms') }}" class="btn btn-outline-primary">Browse rooms</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Stay / event</th>
                            <th>Guests</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $b)
                        <tr>
                            <td>{{ $b->id }}</td>
                            <td class="text-capitalize">{{ str_replace('_', ' ', $b->reservation_type) }}</td>
                            <td>
                                @if($b->checkin_date && $b->checkout_date)
                                    {{ $b->checkin_date->format('M j, Y') }} — {{ $b->checkout_date->format('M j, Y') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $b->adults ?? '—' }}</td>
                            <td>
                                <span class="badge bg-{{ $b->status === 'confirmed' ? 'success' : ($b->status === 'pending' ? 'warning text-dark' : 'secondary') }}">
                                    {{ $b->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a wire:navigate href="{{ route('account.bookings.show', $b) }}" class="btn btn-sm btn-outline-primary">Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
