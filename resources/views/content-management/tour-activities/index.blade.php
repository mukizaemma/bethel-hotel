<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Tour Activities Management</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#activityModal" onclick="resetForm()">
                    <i class="fa fa-plus me-2"></i>Add New Tour Activity
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Images</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                        <tr>
                            <td>{{ $activity->id }}</td>
                            <td>{{ $activity->title }}</td>
                            <td><span class="badge bg-{{ $activity->status == 'Active' ? 'success' : 'danger' }}">{{ $activity->status }}</span></td>
                            <td>{{ $activity->images->count() }} images</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editActivity({{ $activity->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteActivity({{ $activity->id }})">
                                    <i class="fa fa-trash"></i>
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

<!-- Tour Activity Modal -->
<div class="modal fade" id="activityModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activityModalTitle">Add New Tour Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="activityForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="activity_id" name="id">
                    <div class="mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" class="form-control" id="activity_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="activity_description" name="description" rows="6"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cover Image</label>
                        <input type="file" class="form-control" id="activity_cover_image" name="cover_image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gallery Images (Multiple)</label>
                        <input type="file" class="form-control" id="activity_images" name="images[]" multiple accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status *</label>
                        <select class="form-control" id="activity_status" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentActivityId = null;

function resetForm() {
    currentActivityId = null;
    document.getElementById('activityForm').reset();
    document.getElementById('activity_id').value = '';
    document.getElementById('activityModalTitle').textContent = 'Add New Tour Activity';
}

function editActivity(id) {
    fetch(`{{ route('content-management.tour-activities.show', ':id') }}`.replace(':id', id))
        .then(response => response.json())
        .then(data => {
            currentActivityId = id;
            document.getElementById('activity_id').value = data.id;
            document.getElementById('activity_title').value = data.title;
            document.getElementById('activity_description').value = data.description || '';
            document.getElementById('activity_status').value = data.status;
            document.getElementById('activityModalTitle').textContent = 'Edit Tour Activity';
            new bootstrap.Modal(document.getElementById('activityModal')).show();
        });
}

function deleteActivity(id) {
    if (confirm('Are you sure you want to delete this tour activity?')) {
        fetch(`{{ route('content-management.tour-activities.destroy', ':id') }}`.replace(':id', id), {
            method: 'DELETE',
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

document.getElementById('activityForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const url = currentActivityId 
        ? `{{ route('content-management.tour-activities.update', ':id') }}`.replace(':id', currentActivityId)
        : '{{ route('content-management.tour-activities.store') }}';
    
    fetch(url, {
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
            // Close modal using jQuery (more reliable)
            const modalElement = document.getElementById('activityModal');
            if (modalElement && typeof jQuery !== 'undefined') {
                jQuery(modalElement).modal('hide');
            } else if (modalElement) {
                // Fallback: manually hide
                modalElement.classList.remove('show');
                modalElement.style.display = 'none';
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            }
            setTimeout(() => location.reload(), 300);
        }
    });
});

// Initialize Summernote for description
$(document).ready(function() {
    $('#activity_description').summernote({
        height: 200,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview']]
        ]
    });
});
</script>
</div>
