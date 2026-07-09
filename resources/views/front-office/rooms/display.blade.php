<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('front-office.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <h4 class="mb-4">Rooms Display</h4>

            <div class="row">
                @foreach($rooms as $room)
                <div class="col-md-3 mb-4">
                    <div class="card border-{{ $room->room_status == 'available' ? 'success' : ($room->room_status == 'occupied' ? 'danger' : ($room->room_status == 'reserved' ? 'warning' : 'secondary')) }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $room->title }}</h5>
                            <p class="card-text">
                                <strong>Room #:</strong> {{ $room->room_number ?? 'N/A' }}<br>
                                <strong>Status:</strong> 
                                <span class="badge bg-{{ $room->room_status == 'available' ? 'success' : ($room->room_status == 'occupied' ? 'danger' : ($room->room_status == 'reserved' ? 'warning' : 'secondary')) }}">
                                    {{ ucfirst($room->room_status) }}
                                </span>
                            </p>
                            @if($room->bookings->count() > 0)
                            <p class="card-text">
                                <small class="text-muted">
                                    Guest: {{ $room->bookings->first()->names }}<br>
                                    Check-in: {{ $room->bookings->first()->checkin_date->format('Y-m-d') }}
                                </small>
                            </p>
                            @endif
                            <button class="btn btn-sm btn-primary" onclick="updateRoomStatus({{ $room->id }})">
                                <i class="fa fa-edit"></i> Update Status
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Room Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusForm">
                <div class="modal-body">
                    <input type="hidden" id="room_id_status" name="room_id">
                    <div class="mb-3">
                        <label class="form-label">Room Status *</label>
                        <select class="form-control" id="room_status_select" name="room_status" required>
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                            <option value="reserved">Reserved</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateRoomStatus(id) {
    document.getElementById('room_id_status').value = id;
    new bootstrap.Modal(document.getElementById('statusModal')).show();
}

document.getElementById('statusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const roomId = formData.get('room_id');
    
    fetch(`/front-office/rooms/${roomId}/update-status`, {
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
            const modalElement = document.getElementById('statusModal');
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
