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
                        <a href="{{ route('getTours') }}" class="btn btn-dark">Back</a>
                    </li>
                    <li class="nav-item ">
                        
                    <li class="breadcrumb-item active">Updating <strong> {{$tour->title}}</strong></li>

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
                            <form class="form" action="{{ route('updateTour',$tour->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" name="title" class="form-control"
                                                id="title" value="{{$tour->title}}">
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="summernote" class="form-label">Description</label>
                                            <textarea id="Blogs" rows="5" class="form-control" name="description">{!!$tour->description!!}</textarea>
                                        </div>
                                    </div>

                                    <div  class="row mt-3">
                                        <div class="col-lg-4 col-sm-12">
                                            <label for="image" class="form-label">Cover Image</label>
                                            <img src="{{ asset('storage/images/tours/' . $tour->image) }}" alt="" width="120px">
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label for="image" class="form-label">Change Cover Image</label>
                                            <div class="input-group">

                                                <input type="file" name="image" class="form-control" id="image">

                                            </div>
                                        </div>

                                    </div>
                               
                                    

                                </div>

                                <div class="form-actions mt-5">
                                    <button type="submit" class="btn btn-primary text-black">
                                        <i class="fa fa-save"></i> Update Tour Details
                                    </button>

                                    <a href="{{ route('getTours') }}" class="btn btn-light">Back to Tours</a>


                                </div>
                            </form>
                        </div>
                    </div>

                        <!-- Image Gallery Section -->
                        <div class="card mt-5">
                            <div class="card-header bg-dark text-white d-flex align-items-center">
                                <h5 class="mb-0">
                                    <span style="color: yellow">{{ $totalImages }}</span> Images
                                </h5>
                                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#newImage">
                                    Add New Image
                                </button>
                            </div>
                            
                            <div class="card-body">
                                @if($images->count() == 0)
                                    <p class="text-muted">No images yet.</p>
                                @else
                                    <div class="row">
                                        @foreach($images as $image)
                                        <div class="col-md-4 col-sm-6 mb-4">
                                            <div class="card shadow" style="position: relative; overflow: hidden; transition: 0.3s;">
                                                <img src="{{ asset('storage/images/tours/' . $image->image) }}" 
                                                    class="card-img-top rounded" alt="Blog Image" style="width: 100%; height: auto;">
                                                <button onclick="confirmDelete('{{ route('deleteTourImage', $image->id) }}')" 
                                                        style="position: absolute; top: 10px; right: 10px; background: rgba(255, 0, 0, 0.8); color: white; border: none; padding: 6px 10px; border-radius: 50%; cursor: pointer; transition: 0.3s;">
                                                    ×
                                                </button>
                                                <div class="card-body text-center">
                                                    <h6 class="card-title text-truncate" style="max-width: 100%;">{{ $image->title }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                
                </div>



            </div>

        </div>
        <!-- Content End -->

        @include('admin.includes.footer')


        <!-- Add Image Modal -->
<div class="modal fade" id="newImage">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Adding New Image to {{ $tour->title ?? '' }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form class="form" action="{{ route('addTourImage',['id'=>$tour->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-lg-6 col-sm-12">
                            <label for="image" class="form-label">Upload Images</label>
                            <div class="input-group">
                                <input type="hidden" name="tour_id" value="{{ $tour->id }}">
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
                Are you sure you want to delete this image? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="" id="deleteConfirmBtn" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl) {
        document.getElementById('deleteConfirmBtn').setAttribute('href', deleteUrl);
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        confirmModal.show();
    }
</script>

 @endsection