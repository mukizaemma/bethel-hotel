<div class="lw-facilities-management-root">
<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Facilities Management</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#facilityModal" onclick="resetForm()">
                    <i class="fa fa-plus me-2"></i>Add New Facility
                </button>
            </div>

            <div class="table-responsive mb-5">
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
                        @foreach($facilities as $facility)
                        <tr>
                            <td>{{ $facility->id }}</td>
                            <td>{{ $facility->title }}</td>
                            <td><span class="badge bg-{{ $facility->status == 'Active' ? 'success' : 'danger' }}">{{ $facility->status }}</span></td>
                            <td>{{ $facility->images->count() }} images</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="viewFacility({{ $facility->id }})">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="editFacility({{ $facility->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteFacility({{ $facility->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(isset($facilityReservations) && $facilityReservations->count() > 0)
            <hr class="my-4">
            <h5 class="mb-3">Facility Reservations</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Facility</th>
                            <th>Guest Name</th>
                            <th>Date</th>
                            <th>People</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($facilityReservations as $reservation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reservation->facility->title ?? 'N/A' }}</td>
                            <td>{{ $reservation->names }}</td>
                            <td>{{ optional($reservation->checkin_date)->format('Y-m-d') }}</td>
                            <td>{{ $reservation->adults ?? $reservation->guests ?? '-' }}</td>
                            <td>{{ $reservation->phone }}</td>
                            <td>{{ $reservation->email }}</td>
                            <td>
                                <span class="badge bg-{{ $reservation->status === 'confirmed' ? 'success' : ($reservation->status === 'cancelled' ? 'danger' : 'secondary') }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

<!-- Facility Modal -->
<div class="modal fade" id="facilityModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="facilityModalTitle">Add New Facility</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="facilityForm" enctype="multipart/form-data" novalidate>
                <div class="modal-body">
                    <div id="facilityFormErrors" class="alert alert-danger" style="display: none;"></div>
                    <input type="hidden" id="facility_id" name="id">
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="facility_title" name="title" required>
                        <div class="invalid-feedback">Please provide a title.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="facility_description" name="description" rows="6"></textarea>
                        <small class="text-muted">Optional</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cover Image</label>
                        <input type="file" class="form-control" id="facility_cover_image" name="cover_image" accept="image/*">
                        <small class="text-muted">Optional - Main image for the facility</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gallery Images (Multiple)</label>
                        <div id="facilityExistingGalleryWrap" class="mb-3" style="display: none;">
                            <span class="small text-muted d-block mb-2">Current gallery — use × to remove an image</span>
                            <div id="facilityExistingGalleryGrid" class="row g-2"></div>
                        </div>
                        <input type="file" class="form-control" id="facility_images" name="images[]" multiple accept="image/*">
                        <small class="text-muted">Optional — new files are added to the gallery above</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="facility_status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <div class="invalid-feedback">Please select a status.</div>
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
let currentFacilityId = null;

function resetForm() {
    currentFacilityId = null;
    const form = document.getElementById('facilityForm');
    form.reset();
    form.classList.remove('was-validated');
    document.getElementById('facility_id').value = '';
    document.getElementById('facilityModalTitle').textContent = 'Add New Facility';
    document.getElementById('facilityFormErrors').style.display = 'none';
    document.getElementById('facilityFormErrors').innerHTML = '';
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    // Reset Summernote
    $('#facility_description').summernote('code', '');
    document.getElementById('facility_images').value = '';
    hideFacilityEditGallery();
}

function renderFacilityEditGallery(images, facilityId) {
    const wrap = document.getElementById('facilityExistingGalleryWrap');
    const grid = document.getElementById('facilityExistingGalleryGrid');
    if (!wrap || !grid) {
        return;
    }
    wrap.style.display = 'block';
    if (!images || images.length === 0) {
        grid.innerHTML = '<p class="text-muted small mb-0">No gallery images yet. Upload below.</p>';
        return;
    }
    let html = '';
    images.forEach(image => {
        html += `
            <div class="col-6 col-md-4 col-lg-3 position-relative">
                <img src="{{ asset('storage/') }}/${image.image}" class="img-fluid rounded border" style="height: 120px; width: 100%; object-fit: cover;" alt="">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="deleteFacilityImage(${image.id}, ${facilityId})" style="z-index: 10;" title="Remove image">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        `;
    });
    grid.innerHTML = html;
}

function hideFacilityEditGallery() {
    const wrap = document.getElementById('facilityExistingGalleryWrap');
    const grid = document.getElementById('facilityExistingGalleryGrid');
    if (wrap) {
        wrap.style.display = 'none';
    }
    if (grid) {
        grid.innerHTML = '';
    }
}

function editFacility(id) {
    fetch(`{{ route('content-management.facilities.show', ':id') }}`.replace(':id', id))
        .then(response => response.json())
        .then(data => {
            currentFacilityId = id;
            document.getElementById('facility_id').value = data.id;
            document.getElementById('facility_title').value = data.title;
            // Set Summernote content
            $('#facility_description').summernote('code', data.description || '');
            document.getElementById('facility_status').value = data.status;
            document.getElementById('facilityModalTitle').textContent = 'Edit Facility';
            document.getElementById('facility_images').value = '';
            renderFacilityEditGallery(data.images || [], id);
            new bootstrap.Modal(document.getElementById('facilityModal')).show();
        });
}

function deleteFacility(id) {
    if (confirm('Are you sure you want to delete this facility?')) {
        fetch(`{{ route('content-management.facilities.destroy', ':id') }}`.replace(':id', id), {
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

document.getElementById('facilityForm').addEventListener('submit', function(e) {
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
    const url = currentFacilityId 
        ? `{{ route('content-management.facilities.update', ':id') }}`.replace(':id', currentFacilityId)
        : '{{ route('content-management.facilities.store') }}';
    
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
            const modalElement = document.getElementById('facilityModal');
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
            const errorDiv = document.getElementById('facilityFormErrors');
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
        const errorDiv = document.getElementById('facilityFormErrors');
        errorDiv.style.display = 'block';
        errorDiv.innerHTML = `<strong>Error:</strong> ${error.message || 'An error occurred. Please try again.'}`;
    });
});

function viewFacility(id) {
    fetch(`{{ route('content-management.facilities.show', ':id') }}`.replace(':id', id))
        .then(response => response.json())
        .then(data => {
            // Display facility details
            document.getElementById('viewFacilityTitle').textContent = data.title;
            document.getElementById('viewFacilityDetails').innerHTML = `
                <p><strong>Status:</strong> <span class="badge bg-${data.status == 'Active' ? 'success' : 'danger'}">${data.status}</span></p>
                <p><strong>Description:</strong> ${data.description || 'N/A'}</p>
            `;
            
            // Display cover image
            const coverImageHtml = data.cover_image 
                ? `<img src="{{ asset('storage/') }}/${data.cover_image}" class="img-fluid rounded mb-3" style="max-height: 300px; width: 100%; object-fit: cover;">`
                : '<p class="text-muted">No cover image</p>';
            document.getElementById('viewFacilityCoverImage').innerHTML = coverImageHtml;
            
            // Display gallery images
            let galleryHtml = '';
            if (data.images && data.images.length > 0) {
                galleryHtml = '<div class="row g-2">';
                data.images.forEach(image => {
                    galleryHtml += `
                        <div class="col-md-3 position-relative">
                            <img src="{{ asset('storage/') }}/${image.image}" class="img-fluid rounded" style="height: 150px; width: 100%; object-fit: cover;">
                            <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="deleteFacilityImage(${image.id}, ${id})" style="z-index: 10;">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    `;
                });
                galleryHtml += '</div>';
            } else {
                galleryHtml = '<p class="text-muted">No gallery images</p>';
            }
            document.getElementById('viewFacilityGallery').innerHTML = galleryHtml;
            
            // Set facility ID for adding images
            document.getElementById('addFacilityImagesFacilityId').value = id;
            
            new bootstrap.Modal(document.getElementById('viewFacilityModal')).show();
        });
}

function deleteFacilityImage(imageId, facilityId) {
    if (!confirm('Are you sure you want to delete this image?')) {
        return;
    }
    fetch(`{{ route('content-management.facilities.delete-image', ':id') }}`.replace(':id', imageId), {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            return;
        }
        const viewModalEl = document.getElementById('viewFacilityModal');
        if (viewModalEl && viewModalEl.classList.contains('show')) {
            viewFacility(facilityId);
        }
        const editModalEl = document.getElementById('facilityModal');
        if (editModalEl && editModalEl.classList.contains('show') && currentFacilityId === facilityId) {
            fetch(`{{ route('content-management.facilities.show', ':id') }}`.replace(':id', facilityId))
                .then(response => response.json())
                .then(d => renderFacilityEditGallery(d.images || [], facilityId));
        }
    });
}

function addFacilityImages() {
    const form = document.getElementById('addFacilityImagesForm');
    const formData = new FormData(form);
    const facilityId = formData.get('facility_id');
    
    fetch(`{{ route('content-management.facilities.add-images', ':id') }}`.replace(':id', facilityId), {
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
            document.getElementById('addFacilityImagesForm').reset();
            viewFacility(facilityId); // Refresh view
        }
    });
}

// Initialize Summernote for description
$(document).ready(function() {
    $('#facility_description').summernote({
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

<!-- View Facility Modal -->
<div class="modal fade" id="viewFacilityModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewFacilityTitle">Facility Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div id="viewFacilityDetails"></div>
                    </div>
                    <div class="col-md-6">
                        <h6>Cover Image</h6>
                        <div id="viewFacilityCoverImage"></div>
                    </div>
                </div>
                <hr>
                <div class="mb-3">
                    <h6>Gallery Images</h6>
                    <div id="viewFacilityGallery"></div>
                </div>
                <hr>
                <div class="mb-3">
                    <h6>Add More Gallery Images</h6>
                    <form id="addFacilityImagesForm" onsubmit="event.preventDefault(); addFacilityImages();">
                        <input type="hidden" id="addFacilityImagesFacilityId" name="facility_id">
                        <input type="file" class="form-control mb-2" name="images[]" multiple accept="image/*" required>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Add Images
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
