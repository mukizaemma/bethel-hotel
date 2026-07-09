<div class="account-livewire-page">
    <h1 class="h4 mb-4">Dashboard</h1>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card p-4 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small text-uppercase">Total bookings</div>
                    <div class="fs-2 fw-semibold">{{ $totalBookings }}</div>
                </div>
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary">
                    <i class="fa fa-calendar fa-lg"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card p-4 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small text-uppercase">Pending</div>
                    <div class="fs-2 fw-semibold">{{ $pending }}</div>
                </div>
                <div class="rounded-circle bg-warning bg-opacity-10 p-3 text-warning">
                    <i class="fa fa-clock fa-lg"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card p-4 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small text-uppercase">Confirmed</div>
                    <div class="fs-2 fw-semibold">{{ $completed }}</div>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success">
                    <i class="fa fa-check fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-2 small text-uppercase text-primary fw-semibold">Recent bookings</div>
    <div class="stat-card p-4">
        @if($recentBookings->isEmpty())
            <div class="text-center text-muted py-5">
                <i class="fa fa-calendar fa-3x mb-3 opacity-25"></i>
                <p class="mb-0">No bookings yet. Start by browsing our rooms &amp; halls.</p>
                <a wire:navigate href="{{ route('rooms') }}" class="btn btn-primary mt-3">Browse rooms</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Reference</th>
                            <th>Type</th>
                            <th>Dates</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $b)
                        <tr>
                            <td>#{{ $b->id }}</td>
                            <td>
                                @if($b->reservation_type === 'room')
                                    Room{{ $b->room ? ' — ' . $b->room->title : '' }}
                                @elseif($b->reservation_type === 'facility')
                                    Facility{{ $b->facility ? ' — ' . $b->facility->title : '' }}
                                @elseif($b->reservation_type === 'tour_activity')
                                    Tour{{ $b->tourActivity ? ' — ' . $b->tourActivity->title : '' }}
                                @else
                                    {{ $b->reservation_type }}
                                @endif
                            </td>
                            <td>
                                @if($b->checkin_date && $b->checkout_date)
                                    {{ $b->checkin_date->format('M j, Y') }} — {{ $b->checkout_date->format('M j, Y') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $b->status === 'confirmed' ? 'success' : ($b->status === 'pending' ? 'warning text-dark' : 'secondary') }}">
                                    {{ $b->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a wire:navigate href="{{ route('account.bookings.show', $b) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="row g-3 mt-2">
        <div class="col-md-6">
            <a wire:navigate href="{{ route('rooms') }}" class="stat-card p-4 d-block text-decoration-none text-dark h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary"><i class="fa fa-bed fa-lg"></i></div>
                    <div>
                        <div class="fw-semibold">Browse rooms</div>
                        <small class="text-muted">Find your perfect stay</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a wire:navigate href="{{ route('account.profile') }}" class="stat-card p-4 d-block text-decoration-none text-dark h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary"><i class="fa fa-user fa-lg"></i></div>
                    <div>
                        <div class="fw-semibold">Edit profile</div>
                        <small class="text-muted">Update your information</small>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
