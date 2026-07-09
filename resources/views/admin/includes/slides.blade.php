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
                        <h6 class="mb-0">Home Sliding Images</h6>
                        <div class="col-dm3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#slideImage">
                                Add New Image
                              </button>

                              <a href="{{ route('aboutPage') }}" class="btn btn-secondary">Back to Story</a>
                        </div>
                        {{-- <a href="">Show All</a> --}}
                    </div>
                    <div class="table-responsive">

                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ImageCaption </th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($slides as $rs)
                                <tr>
                                    <td><a href="{{ route('editSlide', $rs->id) }}">{{$rs->heading}}</a></td>
                                    {{-- <td>{{$rs->subheading}}</td> --}}
                                    <td>
                                        <a href="{{ route('editSlide', $rs->id) }}"><img src="{{asset('storage/images/slides').$rs->image}}" alt="" width="150px"></a>
                                    
                                    </td>
                                    <td>  
                                        <div class="btn-btn-group ">
                                        <a type="button" href="{{ route('editSlide', $rs->id) }}"
                                            class="btn btn-primary text-black">Edit</a>
                                        <a type="button" href="{{ route('destroySlide', $rs->id) }}"
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
        <div class="modal fade" id="slideImage">
            <div class="modal-dialog modal-lg">
            <form class="form" action="{{ route('saveSlide') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
        
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Adding New Image</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                        <div class="form-body">
                            <div class="row mb-4">

                                <div class="col-lg-6 col-sm-12">
                                        <label>Photo <br><span style="color: red">(This Image should compressed to 1900X800
                                            pixels and less than 650KB)</span></label>
                                        <label id="projectinput7" class="file center-block">
                                            <input type="file" id="image" name="image"
                                                required="">
                                            <span class="file-custom"></span>
                                        </label>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-12">
                                    <label for="projectinput8">Heading </label>
                                    <input type="text" class="form-control"
                                    placeholder="Image heading" name="heading">
                            </div>

                            {{-- <div class="col-lg-6 col-sm-12">
                                <label for="projectinput8">Sub Heading</span></label>
                                <input type="text" class="form-control"
                                placeholder="Image subheading" name="subheading">
                            </div> --}}
                            </div>
                        </div>

                </div>
        
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-black">
                        <i class="fa fa-save"></i> Add New Vision
                    </button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
        
            </div>
            </form>
            </div>
        </div>

 @endsection