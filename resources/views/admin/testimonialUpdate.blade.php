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

            <div class="container pt-10">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('getTestimonials') }}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ route('updateTestimonial', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-lg-8 col-sm-12">
                                        <label for="title" class="form-label">Testimonial Title</label>
                                        <input type="text" name="title" class="form-control" id="title" value="{{ $testimonial->title }}">
                                    </div>
                                </div>
                    
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="summernote" class="form-label">Description</label>
                                        <textarea id="progProblem" rows="5" class="form-control" name="testimony">{!! $testimonial->testimony !!}</textarea>
                                    </div>
                                </div>
                    
                                <div class="row mt-5">
                                    <div class="col-lg-6 col-sm-12">
                                        <label id="projectinput7" class="file center-block">
                                            <img src="{{ asset('storage/images/testimonials/' .$testimonial->image) }}" alt="" width="150px">
                                        </label>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label>Change the cover Image <br><span style="color: red">(Max. 600KB pixels)</span></label>
                                        <label id="projectinput7" class="file center-block">
                                            <input type="file" id="image" name="image">
                                            <span class="file-custom"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary text-black">
                                    <i class="fa fa-save"></i> Update
                                </button>
                                <a href="{{ route('getTestimonials') }}" class="btn btn-warning">Back</a>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>

        </div>
        <!-- Content End -->

        @include('admin.includes.footer')
 @endsection