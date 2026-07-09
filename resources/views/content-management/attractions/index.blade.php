@extends('layouts.adminBase')

@section('content')
<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0">Attractions</h4>
                    <p class="text-muted small mb-0">Nearby places and points of interest (title, optional image, description).</p>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#attractionModal" onclick="resetAttractionForm()">
                    <i class="fa fa-plus me-2"></i>Add attraction
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th style="width:90px">Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th style="width:120px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attractions as $row)
                        <tr>
                            <td>
                                @if($row->image)
                                    <img src="{{ asset('storage/'.$row->image) }}" alt="" class="rounded" style="width:72px;height:48px;object-fit:cover;">
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td><strong>{{ $row->title }}</strong></td>
                            <td class="small text-muted">{{ Str::limit(strip_tags($row->description ?? ''), 100) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" onclick="editAttraction({{ $row->id }})" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteAttraction({{ $row->id }})" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No attractions yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="attractionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attractionModalTitle">Add attraction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="attractionForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="attraction_id" name="id">
                    <div class="mb-3">
                        <label class="form-label" for="attraction_title">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="attraction_title" name="title" required maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="attraction_description">Description</label>
                        <textarea class="form-control" id="attraction_description" name="description" rows="5" placeholder="Optional details"></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="attraction_image">Image</label>
                        <input type="file" class="form-control" id="attraction_image" name="image" accept="image/*">
                        <div class="form-text">Optional. JPG or PNG, max ~4&nbsp;MB. Replaces existing image when editing.</div>
                    </div>
                    <div id="attraction_current_image_wrap" class="mb-0" style="display:none;">
                        <label class="form-label">Current image</label>
                        <div><img id="attraction_current_image" src="" alt="" class="img-thumbnail" style="max-height:120px;"></div>
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
let currentAttractionId = null;
const baseUrl = @json(url('content-management/attractions'));

function resetAttractionForm() {
    currentAttractionId = null;
    document.getElementById('attractionForm').reset();
    document.getElementById('attraction_id').value = '';
    document.getElementById('attractionModalTitle').textContent = 'Add attraction';
    document.getElementById('attraction_current_image_wrap').style.display = 'none';
}

function editAttraction(id) {
    fetch(`${baseUrl}/${id}`)
        .then(r => r.json())
        .then(data => {
            currentAttractionId = id;
            document.getElementById('attraction_id').value = data.id;
            document.getElementById('attraction_title').value = data.title || '';
            document.getElementById('attraction_description').value = data.description || '';
            document.getElementById('attraction_image').value = '';
            const wrap = document.getElementById('attraction_current_image_wrap');
            const img = document.getElementById('attraction_current_image');
            if (data.image) {
                img.src = '{{ asset('storage') }}/' + data.image;
                wrap.style.display = 'block';
            } else {
                wrap.style.display = 'none';
            }
            document.getElementById('attractionModalTitle').textContent = 'Edit attraction';
            new bootstrap.Modal(document.getElementById('attractionModal')).show();
        });
}

function deleteAttraction(id) {
    if (!confirm('Delete this attraction?')) return;
    fetch(`${baseUrl}/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) location.reload();
    });
}

document.getElementById('attractionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const url = currentAttractionId
        ? `${baseUrl}/${currentAttractionId}/update`
        : @json(route('content-management.attractions.store'));

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const el = document.getElementById('attractionModal');
            if (el && typeof bootstrap !== 'undefined') bootstrap.Modal.getInstance(el)?.hide();
            setTimeout(() => location.reload(), 200);
        }
    });
});
</script>
@endsection
