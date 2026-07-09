<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('front-office.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Reservations Calendar</h4>
                <form method="GET" class="d-flex">
                    <input type="date" class="form-control me-2" name="date" value="{{ $selectedDate->format('Y-m-d') }}">
                    <button type="submit" class="btn btn-primary">Go</button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Guest Name</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Room</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->names }}</td>
                            <td>{{ $reservation->checkin_date->format('Y-m-d') }}</td>
                            <td>{{ $reservation->checkout_date->format('Y-m-d') }}</td>
                            <td>{{ $reservation->assignedRoom->room_number ?? 'Not Assigned' }}</td>
                            <td><span class="badge bg-{{ $reservation->status == 'confirmed' ? 'success' : 'warning' }}">{{ ucfirst($reservation->status) }}</span></td>
                            <td>
                                @if(!$reservation->assigned_room_id && $reservation->status == 'confirmed')
                                <button class="btn btn-sm btn-primary" onclick="assignRoom({{ $reservation->id }})">
                                    <i class="fa fa-bed"></i> Assign Room
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Assign Room Modal -->
<div class="modal fade" id="assignRoomModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="assignRoomForm">
                <div class="modal-body">
                    <input type="hidden" id="reservation_id" name="booking_id">
                    <div class="mb-3">
                        <label class="form-label">Select Room *</label>
                        <select class="form-control" name="assigned_room_id" required>
                            <option value="">Select Room</option>
                            @php $availableRooms = App\Models\Room::where('room_status', 'available')->get(); @endphp
                            @foreach($availableRooms as $room)
                            <option value="{{ $room->id }}">{{ $room->room_number ?? $room->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Assign & Check-in</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function assignRoom(id) {
    document.getElementById('reservation_id').value = id;
    new bootstrap.Modal(document.getElementById('assignRoomModal')).show();
}

document.getElementById('assignRoomForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const bookingId = formData.get('booking_id');
    
    fetch(`/front-office/bookings/${bookingId}/checkin`, {
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
            const modalElement = document.getElementById('assignRoomModal');
            if (modalElement) {
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) modal.hide();
                    else jQuery(modalElement).modal('hide');
                } else {
                    jQuery(modalElement).modal('hide');
                }
            }
            setTimeout(() => location.reload(), 300);
        }
    });
});
</script>
</div>
