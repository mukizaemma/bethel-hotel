<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <div>
                    <h4 class="mb-1">Media Images</h4>
                    <p class="text-muted mb-0">All uploaded photos. Files over 700 KB are compressed automatically; smaller files are kept as-is. Identical files are not stored twice.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <form action="{{ route('content-management.media.duplicates') }}" method="POST" onsubmit="return confirm('Remove duplicate media records and duplicate gallery items? The first copy of each image is kept.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" @if($duplicateCount < 1 && $galleryDuplicateCount < 1) disabled @endif>
                            <i class="fa fa-clone me-1"></i>Remove duplicates
                            @if($duplicateCount + $galleryDuplicateCount > 0)
                                <span class="badge bg-danger">{{ $duplicateCount + $galleryDuplicateCount }}</span>
                            @endif
                        </button>
                    </form>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mediaUploadModal">
                        <i class="fa fa-plus me-2"></i>Upload images
                    </button>
                </div>
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
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">{{ $errors->first() }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

            <div class="row">
                @forelse($images as $image)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card h-100">
                            <img src="{{ $image->url() }}" class="card-img-top" alt="{{ $image->original_name }}" style="height: 180px; object-fit: cover;">
                            <div class="card-body">
                                <p class="card-text small text-truncate mb-1" title="{{ $image->original_name }}">{{ $image->original_name ?: basename($image->path) }}</p>
                                <p class="text-muted small mb-2">{{ $image->sizeKb() }} KB</p>
                                @if(isset($duplicateGroups[$image->hash]) && $duplicateGroups[$image->hash] > 1)
                                    <span class="badge bg-warning text-dark">Duplicate</span>
                                @endif
                                <form action="{{ route('content-management.media.destroy', $image->id) }}" method="POST" class="d-inline float-end" onsubmit="return confirm('Remove this image from the media library?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted mb-0">No media images yet. Upload photos to reuse them in galleries, rooms, and facilities.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mediaUploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('content-management.media.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Upload images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                    <small class="text-muted d-block mt-2">Images larger than 700 KB are resized/compressed. Smaller images are not changed. Matching files already in the library are reused instead of duplicated.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
