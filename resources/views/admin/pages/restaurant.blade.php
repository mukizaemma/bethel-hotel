@extends('layouts.adminBase')


@section('content')


        <!-- Sidebar Start -->
@include('admin.includes.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('admin.includes.navbar')
            <!-- Navbar End -->

            <div class="container-fluid px-4">
                <div class="row">
                    @if (session()->has('success'))
                        <div class="arlert alert-success">
                            <button class="close" type="button" data-dismiss="alert">X</button>
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="arlert alert-danger">
                            <button class="close" type="button" data-dismiss="alert">X</button>
                            {{ session()->get('error') }}
                        </div>
                    @endif
                </div>

                <ul class="nav mt-10">
                    <li class="nav-item mr-20 ">
                        <a href="{{ route('resto') }}" class="btn btn-dark">Back</a>
                    </li>
                    <li class="nav-item ">
                        
                    <li class="breadcrumb-item active">Updating <strong> {{$data->title}}</strong></li>

                    </li>
                    <li class="nav-item ms-auto">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newImage">
                            Add New Image
                        </button>
                    </li>
                </ul>

                <div class="container-fluid px-4">

                    <div class="card mb-4">

                        <div class="card-body">
                            <form class="form" action="{{ route('saveResto',$data->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" name="title" class="form-control"
                                                id="title" value="{{$data->title}}">
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="summernote" class="form-label">Description</label>
                                            <textarea id="Blogs" rows="5" class="form-control" name="description">{!!$data->description!!}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <label for="cuisine_section_title" class="form-label">Kitchen specializations — section title</label>
                                            <input type="text" name="cuisine_section_title" id="cuisine_section_title" class="form-control"
                                                value="{{ old('cuisine_section_title', $data->cuisine_section_title) }}"
                                                placeholder="e.g. Our kitchens &amp; flavors">
                                            <small class="text-muted">Shown above the specialization cards on the public Dining page. Leave blank to use the default heading.</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <label for="cuisine_section_lead" class="form-label">Kitchen specializations — short intro</label>
                                            <textarea name="cuisine_section_lead" id="cuisine_section_lead" rows="2" class="form-control"
                                                placeholder="One or two lines introducing your culinary styles.">{{ old('cuisine_section_lead', $data->cuisine_section_lead) }}</textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-actions mt-5">
                                    <button type="submit" class="btn btn-primary text-black">
                                        <i class="fa fa-save"></i> Update Resto Page
                                    </button>

                                    <a href="{{ route('resto') }}" class="btn btn-light">Back</a>


                                </div>
                            </form>
                        </div>
                    </div>

                        <!-- Kitchen specializations (cuisines) -->
                        <div class="card mt-5">
                            <div class="card-header bg-dark text-white d-flex align-items-center">
                                <h5 class="mb-0">
                                    <span style="color: yellow">{{ $totalCuisines ?? 0 }}</span> Kitchen specializations
                                </h5>
                                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#newRestoCuisineModal">
                                    Add specialization
                                </button>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small">Examples: French cuisine, Indian kitchen, Chinese specialties — each with its own photo. These appear on the public Dining page below your intro.</p>
                                @if(($cuisines ?? collect())->isEmpty())
                                    <p class="text-muted mb-0">No specializations yet. Add at least one to highlight your kitchens on the site.</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width:100px;">Image</th>
                                                    <th>Title &amp; short line</th>
                                                    <th style="width:120px;">Order</th>
                                                    <th style="width:220px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cuisines as $cuisine)
                                                <tr>
                                                    <td>
                                                        @if($cuisine->image)
                                                            <img src="{{ asset('storage/images/restaurant/cuisines/' . $cuisine->image) }}" alt="" class="rounded" style="width: 88px; height: 56px; object-fit: cover;">
                                                        @else
                                                            <span class="text-muted small">—</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('updateRestoCuisine', $cuisine->id) }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-2">
                                                            @csrf
                                                            <input type="text" name="title" value="{{ old('title', $cuisine->title) }}" class="form-control form-control-sm" required placeholder="Title">
                                                            <input type="text" name="summary" value="{{ old('summary', $cuisine->summary) }}" class="form-control form-control-sm" placeholder="Optional short line (e.g. Classic sauces &amp; pastries)">
                                                            <div class="input-group input-group-sm">
                                                                <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
                                                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('reorderRestoCuisine', $cuisine->id) }}" method="POST" class="d-inline">@csrf
                                                            <input type="hidden" name="direction" value="up">
                                                            <button type="submit" class="btn btn-sm btn-outline-secondary" title="Move up">↑</button>
                                                        </form>
                                                        <form action="{{ route('reorderRestoCuisine', $cuisine->id) }}" method="POST" class="d-inline">@csrf
                                                            <input type="hidden" name="direction" value="down">
                                                            <button type="submit" class="btn btn-sm btn-outline-secondary" title="Move down">↓</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('{{ route('deleteRestoCuisine', $cuisine->id) }}')">Delete</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Image Gallery Section (CRUD: caption, reorder, replace, delete) -->
                        <div class="card mt-5">
                            <div class="card-header bg-dark text-white d-flex align-items-center">
                                <h5 class="mb-0">
                                    <span style="color: yellow">{{ $totalImages }}</span> Gallery images
                                </h5>
                                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#newImage">
                                    Add images
                                </button>
                            </div>

                            <div class="card-body">
                                @if($images->count() == 0)
                                    <p class="text-muted mb-0">No images yet. Upload photos for the dining page gallery.</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width:100px;">Preview</th>
                                                    <th>Caption (shown on site)</th>
                                                    <th style="width:120px;">Order</th>
                                                    <th style="width:200px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($images as $image)
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset('storage/images/restaurant/' . $image->image) }}" alt="" class="rounded" style="width: 88px; height: 56px; object-fit: cover;">
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('updateRestoImage', $image->id) }}" method="POST" class="d-flex flex-column gap-1">
                                                            @csrf
                                                            <input type="text" name="caption" value="{{ old('caption', $image->caption) }}" class="form-control form-control-sm" placeholder="Optional caption">
                                                            <button type="submit" class="btn btn-sm btn-primary align-self-start">Save caption</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('reorderRestoImage', $image->id) }}" method="POST" class="d-inline">@csrf
                                                            <input type="hidden" name="direction" value="up">
                                                            <button type="submit" class="btn btn-sm btn-outline-secondary" title="Move up">↑</button>
                                                        </form>
                                                        <form action="{{ route('reorderRestoImage', $image->id) }}" method="POST" class="d-inline">@csrf
                                                            <input type="hidden" name="direction" value="down">
                                                            <button type="submit" class="btn btn-sm btn-outline-secondary" title="Move down">↓</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-primary mb-1" data-bs-toggle="modal" data-bs-target="#replaceRestoImageModal" data-image-id="{{ $image->id }}">Replace file</button>
                                                        <br>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('{{ route('deleteRestoImage', $image->id) }}')">Delete</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>

                
                </div>



            </div>

        </div>
        <!-- Content End -->

        @include('admin.includes.footer')


        <!-- Add kitchen specialization -->
<div class="modal fade" id="newRestoCuisineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add kitchen specialization</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('addRestoCuisine') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="restaurant_id" value="{{ $data->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. French kitchen" maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Short line (optional)</label>
                        <input type="text" name="summary" class="form-control" placeholder="e.g. Classic sauces, pastries &amp; wine pairings" maxlength="500">
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Image <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <small class="text-muted">Shown as the card photo on the Dining page.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

        <!-- Add Image Modal -->
<div class="modal fade" id="newImage">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Adding New Image to {{ $data->title ?? '' }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form class="form" action="{{ route('addRestoImage',['id'=>$data->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-lg-6 col-sm-12">
                            <label for="image" class="form-label">Upload Images</label>
                            <div class="input-group">
                                <input type="hidden" name="restaurant_id" value="{{ $data->id }}">
                                <input type="file" name="image[]" class="form-control" id="image" multiple>
                            </div>
                            <small class="text-muted">You can upload one or multiple images.</small>
                        </div>
                    </div>
                </div>
            
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary text-black">
                        <i class="fa fa-save"></i> Upload
                    </button>
                </div>
            </form>
            
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>

    </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="" id="deleteConfirmBtn" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Replace image file -->
<div class="modal fade" id="replaceRestoImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Replace image file</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="replaceRestoImageForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label class="form-label">New image</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                    <small class="text-muted d-block mt-2">Caption is unchanged unless you edit it in the table.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl) {
        document.getElementById('deleteConfirmBtn').setAttribute('href', deleteUrl);
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        confirmModal.show();
    }

    document.getElementById('replaceRestoImageModal').addEventListener('show.bs.modal', function (event) {
        var btn = event.relatedTarget;
        var id = btn && btn.getAttribute('data-image-id');
        var form = document.getElementById('replaceRestoImageForm');
        if (form && id) {
            form.action = "{{ url('/updateRestoImage') }}/" + id;
        }
    });
</script>

 @endsection