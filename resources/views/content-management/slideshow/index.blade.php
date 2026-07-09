<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Slideshow Management</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#slideModal" onclick="resetForm()">
                    <i class="fa fa-plus me-2"></i>Add New Slide
                </button>
            </div>

            <div class="row">
                @foreach($slides as $slide)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if($slide->media_type === 'video')
                            @if($slide->video_url)
                                <div class="card-img-top" style="height: 200px; background: #000; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-video" style="font-size: 48px; color: #fff;"></i>
                                    <span class="badge bg-primary ms-2">Video URL</span>
                                </div>
                            @elseif($slide->video_file)
                                <video class="card-img-top" style="height: 200px; object-fit: cover;" controls>
                                    <source src="{{ asset('storage/' . $slide->video_file) }}" type="video/mp4">
                                </video>
                            @endif
                        @else
                            <img src="{{ asset('storage/' . ($slide->image ?? 'slides/default.jpg')) }}" class="card-img-top" alt="Slide" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $slide->heading ?? 'Slide ' . $slide->id }}</h5>
                            <span class="badge bg-{{ $slide->media_type === 'video' ? 'info' : 'success' }} mb-2">
                                {{ ucfirst($slide->media_type ?? 'image') }}
                            </span>
                            @if($slide->subheading)
                                <p class="card-text text-muted">{{ $slide->subheading }}</p>
                            @endif
                            @if($slide->button && $slide->link)
                                <a href="{{ $slide->link }}" class="btn btn-sm btn-primary" target="_blank">{{ $slide->button }}</a>
                            @endif
                            <div class="mt-2">
                                <button class="btn btn-sm btn-warning" onclick="editSlide({{ $slide->id }})">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteSlide({{ $slide->id }})">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Slide Modal -->
<div class="modal fade" id="slideModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Slide</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            @php
                $storeAction = route('content-management.slideshow.store');
                $updateActionTemplate = route('content-management.slideshow.update', ['slide' => '__SLIDE_ID__']);
                $deleteActionTemplate = route('content-management.slideshow.destroy', ['slide' => '__SLIDE_ID__']);
                $slidesData = $slides->keyBy('id');
            @endphp
            <form id="slideForm" enctype="multipart/form-data" action="{{ $storeAction }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="slideFormMethod" value="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Media Type <span class="text-danger">*</span></label>
                        <select class="form-control" name="media_type" id="media_type" required onchange="toggleMediaFields()">
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Heading</label>
                        <input type="text" class="form-control" name="heading" placeholder="Main heading text">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subheading</label>
                        <input type="text" class="form-control" name="subheading" placeholder="Subheading text">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Button Text</label>
                        <input type="text" class="form-control" name="button" placeholder="e.g., Book Now">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Button Link</label>
                        <input type="url" class="form-control" name="link" placeholder="https://...">
                    </div>
                    <!-- Image Fields -->
                    <div id="imageFields">
                        <div class="mb-3">
                            <label class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="image" id="imageInput" accept="image/*">
                            <small class="form-text text-muted">Accepted formats: JPG, PNG, GIF (Max: 2MB)</small>
                            <div class="invalid-feedback">Please select an image.</div>
                        </div>
                    </div>
                    <!-- Video Fields -->
                    <div id="videoFields" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Video URL (YouTube, Vimeo, etc.)</label>
                            <input type="url" class="form-control" name="video_url" id="video_url" placeholder="https://www.youtube.com/watch?v=... or https://vimeo.com/...">
                            <small class="form-text text-muted">Enter a video URL from YouTube, Vimeo, or other video hosting platforms</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">OR Upload Video File</label>
                            <input type="file" class="form-control" name="video_file" id="video_file" accept="video/*">
                            <small class="form-text text-muted">Accepted formats: MP4, WebM, OGG (Max: 10MB)</small>
                        </div>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> You can either provide a video URL or upload a video file. If both are provided, the URL will be used.
                        </div>
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

<form id="deleteSlideForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
    const slidesData = @json($slidesData);
    const storeAction = @json($storeAction);
    const updateActionTemplate = @json($updateActionTemplate);
    const deleteActionTemplate = @json($deleteActionTemplate);

    function resetForm() {
        const form = document.getElementById('slideForm');
        form.reset();
        form.action = storeAction;
        document.getElementById('slideFormMethod').value = 'POST';
        document.querySelector('#slideModal .modal-title').textContent = 'Add New Slide';
        document.getElementById('media_type').value = 'image';
        toggleMediaFields();
    }

    function toggleMediaFields() {
        const mediaType = document.getElementById('media_type').value;
        const imageFields = document.getElementById('imageFields');
        const videoFields = document.getElementById('videoFields');
        const imageInput = document.getElementById('imageInput');
        const videoUrl = document.getElementById('video_url');
        const videoFile = document.getElementById('video_file');
        
        if (mediaType === 'video') {
            imageFields.style.display = 'none';
            videoFields.style.display = 'block';
            if (imageInput) imageInput.removeAttribute('required');
        } else {
            imageFields.style.display = 'block';
            videoFields.style.display = 'none';
            if (imageInput) imageInput.setAttribute('required', 'required');
        }

        if (videoUrl) videoUrl.removeAttribute('required');
        if (videoFile) videoFile.removeAttribute('required');
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleMediaFields();
    });

    function editSlide(id) {
        const slide = slidesData[id];
        if (!slide) return;

        const form = document.getElementById('slideForm');
        const methodField = document.getElementById('slideFormMethod');
        const modalTitle = document.querySelector('#slideModal .modal-title');

        form.action = updateActionTemplate.replace('__SLIDE_ID__', id);
        methodField.value = 'POST'; // route is POST /update
        modalTitle.textContent = 'Edit Slide';

        document.getElementById('media_type').value = slide.media_type || 'image';
        document.querySelector('input[name=\"heading\"]').value = slide.heading || '';
        document.querySelector('input[name=\"subheading\"]').value = slide.subheading || '';
        document.querySelector('input[name=\"button\"]').value = slide.button || '';
        document.querySelector('input[name=\"link\"]').value = slide.link || '';
        document.getElementById('video_url').value = slide.video_url || '';

        const videoFileInput = document.getElementById('video_file');
        if (videoFileInput) {
            videoFileInput.value = '';
        }

        const imageInput = document.getElementById('imageInput');
        if (imageInput) {
            imageInput.value = '';
        }

        toggleMediaFields();

        const modal = new bootstrap.Modal(document.getElementById('slideModal'));
        modal.show();
    }

    function deleteSlide(id) {
        if (!confirm('Are you sure you want to delete this slide?')) {
            return;
        }
        const form = document.getElementById('deleteSlideForm');
        form.action = deleteActionTemplate.replace('__SLIDE_ID__', id);
        form.submit();
    }
</script>
</div>
