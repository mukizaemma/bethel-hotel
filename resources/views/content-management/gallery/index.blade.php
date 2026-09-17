<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <div>
                    <h4 class="mb-1">Gallery Management</h4>
                    <p class="text-muted mb-0">This list is what visitors see on the public gallery page. Newest images start at the top. Use the arrows to change order, or remove items without deleting them from Media Images.</p>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="resetForm()">
                    <i class="fa fa-plus me-2"></i>Add to gallery
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show">{{ session('warning') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

            <div class="row">
                @forelse($gallery as $item)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        @if($item->media_type == 'image' && (!empty($item->image) || $item->mediaImage))
                            <img src="{{ $item->publicUrl() }}" class="card-img-top" alt="{{ $item->caption }}" style="height: 180px; object-fit: cover;">
                        @elseif($item->media_type != 'image')
                            @if($item->youtube_link)
                                <div class="card-img-top bg-dark text-white d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <i class="fa fa-video fa-3x"></i>
                                </div>
                            @elseif($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" class="card-img-top" alt="{{ $item->caption }}" style="height: 180px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-dark text-white d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <i class="fa fa-video fa-3x"></i>
                                </div>
                            @endif
                        @endif
                        <div class="card-body">
                            <p class="card-text">{{ $item->caption ?: 'Untitled' }}</p>
                            <span class="badge bg-info">{{ ucfirst($item->media_type) }}</span>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="btn-group">
                                    <form action="{{ route('content-management.gallery.move', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="direction" value="up">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Move up (towards top)">&uarr;</button>
                                    </form>
                                    <form action="{{ route('content-management.gallery.move', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="direction" value="down">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Move down">&darr;</button>
                                    </form>
                                </div>
                                <form action="{{ route('content-management.gallery.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Remove this item from the public gallery page?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-muted">No gallery items yet. Add images from the media library or upload new ones.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="galleryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
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
                            <option value="image">Images (upload or select multiple)</option>
                            <option value="video">Video</option>
                        </select>
                    </div>
                    <div id="imageFields">
                        <div class="mb-3">
                            <label class="form-label">Images</label>
                            @include('content-management.includes.media-picker', [
                                'pickerId' => 'galleryPicker',
                                'multiple' => true,
                                'existingName' => 'existing_media_ids[]',
                                'fileName' => 'images[]',
                                'fileId' => 'gallery_image',
                            ])
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
        const img = document.getElementById('gallery_image');
        if (img) img.removeAttribute('required');
        document.getElementById('gallery_video').required = false;
    } else {
        document.getElementById('imageFields').style.display = 'none';
        document.getElementById('videoFields').style.display = 'block';
        const img = document.getElementById('gallery_image');
        if (img) img.removeAttribute('required');
    }
}
</script>
</div>
