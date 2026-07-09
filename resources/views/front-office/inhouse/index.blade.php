<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('front-office.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">In-House Guests</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#walkinModal" onclick="resetWalkInForm()">
                    <i class="fa fa-plus me-2"></i>Register Walk-in Guest
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Guest Name</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Room</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->names }}</td>
                            <td>{{ $booking->checkin_date->format('Y-m-d') }}</td>
                            <td>{{ $booking->checkout_date->format('Y-m-d') }}</td>
                            <td>{{ $booking->assignedRoom->room_number ?? $booking->assignedRoom->title ?? 'N/A' }}</td>
                            <td>{{ number_format($booking->paid_amount, 2) }} RWF</td>
                            <td>{{ number_format($booking->balance_amount, 2) }} RWF</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="moveGuest({{ $booking->id }})" title="Move to Another Room">
                                    <i class="fa fa-exchange-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-success" onclick="checkout({{ $booking->id }})" title="Check-out">
                                    <i class="fa fa-sign-out-alt"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Walk-in Guest Modal -->
<div class="modal fade" id="walkinModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register Walk-in Guest</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="walkinForm" action="{{ route('front-office.walkin.register') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Guest Name *</label>
                            <input type="text" class="form-control" name="names" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone *</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Assigned Room *</label>
                            <select class="form-control" name="assigned_room_id" required>
                                <option value="">Select Room</option>
                                @php $availableRooms = App\Models\Room::where('room_status', 'available')->get(); @endphp
                                @foreach($availableRooms as $room)
                                <option value="{{ $room->id }}">{{ $room->room_number ?? $room->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Check-in Date *</label>
                            <input type="date" class="form-control" name="checkin_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Check-out Date *</label>
                            <input type="date" class="form-control" name="checkout_date" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Adults *</label>
                            <input type="number" class="form-control" name="adults" value="1" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Children</label>
                            <input type="number" class="form-control" name="children" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total Amount *</label>
                            <input type="number" step="0.01" class="form-control" name="total_amount" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Paid Amount</label>
                        <input type="number" step="0.01" class="form-control" name="paid_amount" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Register & Check-in</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Move Guest Modal -->
<div class="modal fade" id="moveGuestModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Move Guest to Another Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="moveGuestForm">
                <div class="modal-body">
                    <input type="hidden" id="move_booking_id" name="booking_id">
                    <div class="mb-3">
                        <label class="form-label">To Room *</label>
                        <select class="form-control" name="to_room_id" required>
                            <option value="">Select Room</option>
                            @php $availableRooms = App\Models\Room::where('room_status', 'available')->get(); @endphp
                            @foreach($availableRooms as $room)
                            <option value="{{ $room->id }}">{{ $room->room_number ?? $room->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason</label>
                        <textarea class="form-control" name="reason" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Move Guest</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetWalkInForm() {
    document.getElementById('walkinForm').reset();
    document.querySelector('input[name="checkin_date"]').value = '{{ date('Y-m-d') }}';
}

function moveGuest(id) {
    document.getElementById('move_booking_id').value = id;
    new bootstrap.Modal(document.getElementById('moveGuestModal')).show();
}

function checkout(id) {
    if (confirm('Check-out this guest?')) {
        fetch(`/front-office/bookings/${id}/checkout`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

document.getElementById('moveGuestForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const bookingId = formData.get('booking_id');
    
    fetch(`/front-office/bookings/${bookingId}/move`, {
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
            const modalElement = document.getElementById('moveGuestModal');
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
