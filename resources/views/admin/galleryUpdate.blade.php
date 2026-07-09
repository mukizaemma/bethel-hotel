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
                <div class="bg-light rounded p-4">
                    <h2>{{ $data->heading }}</h2>

                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <form class="form" action="{{ route('updateGallery',$data->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <label for="title" class="form-label">caption</label>
                                            <input type="text" name="caption" class="form-control"
                                                id="title" value="{{ $data->caption }}">
                                        </div>
                                        {{-- <div class="col-12">
                                            <label for="title" class="form-label">Sub Heading</label>
                                            <input type="text" name="subheading" class="form-control"
                                                id="title" value="{{ $data->subheading }}">
                                        </div> --}}
                                    </div>

                                    {{-- <div class="row">
                                        <div class="col-lg-12">
                                            <label for="summernote" class="form-label">Description</label>
                                            <textarea id="description" rows="5" class="form-control" name="description">{!! $book->description !!}</textarea>
                                        </div>
                                    </div> --}}
            
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            <label for="image" class="form-label">Featured Image<br></label>
                                            <div class="input-group">
                                                <img src="{{ asset('storage/images/gallery/' . $data->image) }}" alt="" width="120px">
            
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label for="image" class="form-label">Change Image<br> <span
                                                    style="color: red">(This Image should compressed to not greater than 500KB)</span></label>
                                            <div class="input-group">
            
                                                <input type="file" name="image" class="form-control"
                                                    id="image">
            
                                            </div>
                                        </div>
            
                                    </div>                              
            
                                    <div class="form-actions mt-20">
                                        <button type="submit" class="btn btn-primary text-black">
                                            <i class="fa fa-save"></i> Save Changes
                                        </button>
            
                                    </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Content End -->


        @include('admin.includes.footer')

 @endsection