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

            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
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
                    
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Images</h6>
                        <div class="col-dm3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addImageModal">
                                Add New Image
                              </button>
                        </div>
                        {{-- <a href="">Show All</a> --}}
                    </div>
                    <div class="table-responsive">

                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    
                                    <th>Image</th>
                                    <th>Image Caption </th>
                                    <th>Display Page </th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($images as $rs)
                                <tr>

                                    {{-- <td>{{$rs->subheading}}</td> --}}
                                    <td>
                                        <a href="{{ route('editImage', $rs->id) }}"><img src="{{asset('storage/images/slides').$rs->image}}" alt="" width="150px"></a>
                                    
                                    </td>
                                    <td><a href="{{ route('editImage', $rs->id) }}">{{$rs->caption}}</a></td>
                                    <td>{{$rs->category ?? ''}}</td>
                                    <td>  
                                        <div class="btn-btn-group ">
                                        <a type="button" href="{{ route('editImage', $rs->id) }}"
                                            class="btn btn-primary text-black">Edit</a>
                                        <a type="button" href="{{ route('destroyImage', $rs->id) }}"
                                            class="btn btn-danger text-black" onclick="return confirm('Are you sure to delete this item?')">Delete</a>
                                    </div>
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
        <!-- Content End -->


        <!-- The Modal -->
        <div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form class="form" action="{{ route('saveImage') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addImageModalLabel">Add Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- File Input -->
                            <div class="row mb-4">
                                <div class="col-lg-8 col-sm-12">
                                    <label>Photo <span style="color: red;">*</span></label>
                                    <input type="file" id="image" name="image" class="form-control" required>
                                </div>
                            </div>
                            <!-- Category Dropdown -->
                            <div class="row mb-4">
                                <div class="col-lg-6 col-sm-12">
                                    <label>Display Page</label>
                                    <select class="form-control border-success" name="category" id="category" required onchange="toggleCaptionField()">
                                        <option value="" disabled selected>Select a page</option>
                                        <option value="Gallery">Gallery</option>
                                        <option value="Slide">Home Slides</option>
                                    </select>
                                </div>
                                <!-- Caption Field -->
                                <div class="col-lg-6 col-sm-12" id="caption-field" style="display: none;">
                                    <label for="caption">Image Caption</label>
                                    <input type="text" class="form-control" id="caption" name="caption" placeholder="Image Caption">
                                </div>
                            </div>
                        </div>
                        <!-- Footer with Submit Button -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Add Image
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        

 @endsection