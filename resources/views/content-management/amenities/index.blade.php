<div class="admin-livewire-page d-flex w-100 align-items-stretch">
<!-- Sidebar Start -->
@include('content-management.includes.sidebar')
<!-- Sidebar End -->

<!-- Content Start -->
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Amenities Management</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#amenityModal" onclick="resetForm()">
                    <i class="fa fa-plus me-2"></i>Add New Amenity
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($amenities as $amenity)
                        <tr>
                            <td>{{ $amenity->id }}</td>
                            <td>{{ $amenity->title }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editAmenity({{ $amenity->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteAmenity({{ $amenity->id }})">
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

<!-- Amenity Modal -->
<div class="modal fade" id="amenityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="amenityModalTitle">Add New Amenity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="amenityForm" novalidate>
                <div class="modal-body">
                    <div id="amenityFormErrors" class="alert alert-danger" style="display: none;"></div>
                    <input type="hidden" id="amenity_id" name="id">
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="amenity_title" name="title" required>
                        <div class="invalid-feedback">Please provide a title.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon (Font Awesome class, e.g., fa-wifi)</label>
                        <input type="text" class="form-control" id="amenity_icon" name="icon" placeholder="fa-wifi">
                        <small class="text-muted">Optional - Example: fa-wifi, fa-tv, fa-car</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentAmenityId = null;

function resetForm() {
    currentAmenityId = null;
    const form = document.getElementById('amenityForm');
    form.reset();
    form.classList.remove('was-validated');
    document.getElementById('amenity_id').value = '';
    document.getElementById('amenityModalTitle').textContent = 'Add New Amenity';
    document.getElementById('amenityFormErrors').style.display = 'none';
    document.getElementById('amenityFormErrors').innerHTML = '';
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
}

function editAmenity(id) {
    fetch(`{{ route('content-management.amenities.show', ':id') }}`.replace(':id', id))
        .then(response => response.json())
        .then(data => {
            currentAmenityId = id;
            document.getElementById('amenity_id').value = data.id;
            document.getElementById('amenity_title').value = data.title;
            document.getElementById('amenity_icon').value = data.icon || '';
            document.getElementById('amenityModalTitle').textContent = 'Edit Amenity';
            new bootstrap.Modal(document.getElementById('amenityModal')).show();
        });
}

function deleteAmenity(id) {
    if (confirm('Are you sure you want to delete this amenity?')) {
        fetch(`{{ route('content-management.amenities.destroy', ':id') }}`.replace(':id', id), {
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

document.getElementById('amenityForm').addEventListener('submit', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    const spinner = submitBtn.querySelector('.spinner-border');
    
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        form.querySelectorAll(':invalid').forEach(field => {
            field.classList.add('is-invalid');
        });
        return false;
    }
    
    submitBtn.disabled = true;
    spinner.classList.remove('d-none');
    
    const formData = new FormData(form);
    const url = currentAmenityId 
        ? `{{ route('content-management.amenities.update', ':id') }}`.replace(':id', currentAmenityId)
        : '{{ route('content-management.amenities.store') }}';
    
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
        submitBtn.disabled = false;
        spinner.classList.add('d-none');
        
        if (data.success) {
            // Close modal using jQuery (more reliable)
            const modalElement = document.getElementById('amenityModal');
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
        } else {
            const errorDiv = document.getElementById('amenityFormErrors');
            errorDiv.style.display = 'block';
            let errorHtml = '<strong>Please fix the following errors:</strong><ul class="mb-0">';
            
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    errorHtml += `<li>${data.errors[field][0]}</li>`;
                    const input = form.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                    }
                });
            } else if (data.message) {
                errorHtml += `<li>${data.message}</li>`;
            }
            errorHtml += '</ul>';
            errorDiv.innerHTML = errorHtml;
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        spinner.classList.add('d-none');
        const errorDiv = document.getElementById('amenityFormErrors');
        errorDiv.style.display = 'block';
        errorDiv.innerHTML = `<strong>Error:</strong> ${error.message || 'An error occurred. Please try again.'}`;
    });
});
</script>
</div>
