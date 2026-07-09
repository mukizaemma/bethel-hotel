<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <h4 class="mb-4">Reservations</h4>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" id="reservationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="rooms-tab" data-bs-toggle="tab" data-bs-target="#rooms" type="button" role="tab" aria-controls="rooms" aria-selected="true">
                        Room Reservations
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="facilities-tab" data-bs-toggle="tab" data-bs-target="#facilities" type="button" role="tab" aria-controls="facilities" aria-selected="false">
                        Facility Reservations
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="reservationTabsContent">
                <!-- Rooms tab -->
                <div class="tab-pane fade show active" id="rooms" role="tabpanel" aria-labelledby="rooms-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guest</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Room</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roomReservations as $booking)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $booking->names }}</td>
                                        <td>{{ $booking->email }}</td>
                                        <td>{{ $booking->phone }}</td>
                                        <td>{{ optional($booking->checkin_date)->format('Y-m-d') }}</td>
                                        <td>{{ optional($booking->checkout_date)->format('Y-m-d') }}</td>
                                        <td>{{ $booking->assignedRoom->room_number ?? $booking->room->title ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'secondary') }}">
                                                {{ ucfirst($booking->status ?? 'pending') }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" onclick="openReservationModal({{ $booking->id }})">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No room reservations found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Facilities tab -->
                <div class="tab-pane fade" id="facilities" role="tabpanel" aria-labelledby="facilities-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Facility</th>
                                    <th>Guest</th>
                                    <th>Date</th>
                                    <th>People</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($facilityReservations as $booking)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $booking->facility->title ?? 'N/A' }}</td>
                                        <td>{{ $booking->names }}</td>
                                        <td>{{ optional($booking->checkin_date)->format('Y-m-d') }}</td>
                                        <td>{{ $booking->adults ?? '-' }}</td>
                                        <td>{{ $booking->phone }}</td>
                                        <td>{{ $booking->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'secondary') }}">
                                                {{ ucfirst($booking->status ?? 'pending') }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" onclick="openReservationModal({{ $booking->id }})">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No facility reservations found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reservation detail & reply modal -->
<div class="modal fade" id="reservationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reservation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="reservationDetails" class="mb-4">
                    <!-- Filled by JS -->
                </div>
                <hr>
                <form id="reservationReplyForm">
                    @csrf
                    <input type="hidden" id="reservation_id" name="reservation_id">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="confirmed">Confirmed</option>
                            <option value="rejected">Rejected</option>
                            <option value="full-booked">Full-booked</option>
                            <option value="scam">Scam</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message to guest</label>
                        <textarea name="admin_reply" class="form-control" rows="4" required placeholder="Write a personalized message that will be emailed to the guest."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitReservationReply()">Send Reply</button>
            </div>
        </div>
    </div>
</div>

<script>
function openReservationModal(id) {
    const detailsDiv = document.getElementById('reservationDetails');
    detailsDiv.innerHTML = '<p class="text-muted mb-0">Loading details...</p>';
    document.getElementById('reservation_id').value = id;

    fetch(`{{ route('content-management.reservations.show', ':id') }}`.replace(':id', id))
        .then(response => response.json())
        .then(data => {
            let itemName = 'Reservation';
            if (data.reservation_type === 'facility' && data.facility) {
                itemName = data.facility.title;
            } else if (data.reservation_type === 'tour_activity' && data.tour_activity) {
                itemName = data.tour_activity.title;
            } else if (data.room) {
                itemName = data.room.title;
            }

            const checkin = data.checkin_date ?? '';
            const checkout = data.checkout_date ?? '';

            detailsDiv.innerHTML = `
                <dl class="row mb-0">
                    <dt class="col-sm-3">Guest</dt>
                    <dd class="col-sm-9">${data.names ?? ''}</dd>

                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">${data.email ?? ''}</dd>

                    <dt class="col-sm-3">Phone</dt>
                    <dd class="col-sm-9">${data.phone ?? ''}</dd>

                    <dt class="col-sm-3">Item</dt>
                    <dd class="col-sm-9">${itemName}</dd>

                    <dt class="col-sm-3">Type</dt>
                    <dd class="col-sm-9">${data.reservation_type ?? ''}</dd>

                    <dt class="col-sm-3">Check-in</dt>
                    <dd class="col-sm-9">${checkin}</dd>

                    <dt class="col-sm-3">Check-out</dt>
                    <dd class="col-sm-9">${checkout}</dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9">${data.status ?? 'pending'}</dd>

                    <dt class="col-sm-3">Message</dt>
                    <dd class="col-sm-9">${data.message ?? ''}</dd>
                </dl>
            `;
        });

    new bootstrap.Modal(document.getElementById('reservationModal')).show();
}

function submitReservationReply() {
    const form = document.getElementById('reservationReplyForm');
    const id = document.getElementById('reservation_id').value;
    const formData = new FormData(form);

    fetch(`{{ route('content-management.reservations.reply', ':id') }}`.replace(':id', id), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modalElement = document.getElementById('reservationModal');
            if (modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modal.hide();
            }
            setTimeout(() => location.reload(), 300);
        } else if (data.message) {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('An error occurred while sending the reply. Please try again.');
        console.error(error);
    });
}
</script>
</div>
