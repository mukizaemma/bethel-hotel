<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <h4 class="mb-0">Gallery Management</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="resetForm()">
                    <i class="fa fa-plus me-2"></i>Add Gallery Item
                </button>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

            <div class="row">
                @foreach($gallery as $item)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        @if($item->media_type == 'image' && !empty($item->image))
                            <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->caption }}">
                        @elseif($item->media_type != 'image')
                            @if($item->youtube_link)
                                <div class="card-img-top bg-dark text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fa fa-video fa-3x"></i>
                                </div>
                            @elseif($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" class="card-img-top" alt="{{ $item->caption }}">
                            @else
                                <div class="card-img-top bg-dark text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fa fa-video fa-3x"></i>
                                </div>
                            @endif
                        @endif
                        <div class="card-body">
                            <p class="card-text">{{ $item->caption }}</p>
                            <span class="badge bg-info">{{ ucfirst($item->media_type) }}</span>
                            <button class="btn btn-sm btn-danger float-end" onclick="deleteGallery({{ $item->id }})">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Gallery Modal: add single/multiple images or video -->
<div class="modal fade" id="galleryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Gallery Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="galleryForm" enctype="multipart/form-data" action="{{ route('content-management.gallery.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Media Type *</label>
                        <select class="form-control" name="media_type" id="gallery_media_type" required onchange="toggleMediaFields()">
                            <option value="image">Images (single or multiple)</option>
                            <option value="video">Video</option>
                        </select>
                    </div>
                    <div id="imageFields">
                        <div class="mb-3">
                            <label class="form-label">Upload images *</label>
                            <input type="file" class="form-control" name="images[]" id="gallery_image" accept="image/*" multiple>
                            <small class="text-muted d-block mt-1">You can select multiple images at once; the same caption and category will apply to all.</small>
                        </div>
                    </div>
                    <div id="videoFields" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Upload Video</label>
                            <input type="file" class="form-control" name="video" id="gallery_video" accept="video/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">OR YouTube Link</label>
                            <input type="url" class="form-control" name="youtube_link" id="gallery_youtube_link" placeholder="https://youtube.com/watch?v=...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" name="thumbnail" id="gallery_thumbnail" accept="image/*">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Caption</label>
                        <input type="text" class="form-control" name="caption">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" class="form-control" name="category">
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
function resetForm() {
    document.getElementById('galleryForm').reset();
    toggleMediaFields();
}

function toggleMediaFields() {
    const mediaType = document.getElementById('gallery_media_type').value;
    if (mediaType === 'image') {
        document.getElementById('imageFields').style.display = 'block';
        document.getElementById('videoFields').style.display = 'none';
        document.getElementById('gallery_image').setAttribute('required', 'required');
        document.getElementById('gallery_video').required = false;
    } else {
        document.getElementById('imageFields').style.display = 'none';
        document.getElementById('videoFields').style.display = 'block';
        document.getElementById('gallery_image').required = false;
    }
}

function deleteGallery(id) {
    if (confirm('Are you sure you want to delete this gallery item?')) {
        // Implement delete functionality
        alert('Delete functionality to be implemented');
    }
}
</script>
</div>
