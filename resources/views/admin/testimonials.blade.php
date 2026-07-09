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
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Our Recent Testimonials</h6>
                        <div class="col-dm3">
                            <button type="button" class="btn btn-primary float-left" data-bs-toggle="modal" data-bs-target="#NewProduct">
                                Add A Testmony
                              </button>
                        </div>
                        {{-- <a href="">Show All</a> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    {{-- <th scope="col"><input class="form-check-input" type="checkbox"></th> --}}
                                    <th scope="col">Testimonial Title</th>
                                    <th scope="col">Cover Image</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($testimonials as $rs)
                                <tr>
                                    {{-- <td><input class="form-check-input" type="checkbox"></td> --}}
                                    <td><a href="{{ route('editTestimonial',['id'=>$rs->id]) }}">{{ $rs->title }}</a></td>
                                    <td><img src="{{ asset('storage/images/testimonials/' .$rs->image) }}" alt="" width="120px"></td>
                                    <td>{!! $rs->testimony !!}</td>
                                    <td>
                                        <div class="bg-light rounded ">
                                            <div class="btn-group" role="group">
                                                {{-- <button type="button" class="btn btn-danger"><i class="fa fa-eye"></i></button> --}}
                                                <a href="{{ route('editTestimonial',['id'=>$rs->id]) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('deleteTestimonial',['id'=>$rs->id]) }}" class="btn btn-warning"  onclick="return confirm('Are you sure to delete this item?')"><i class="fa fa-trash"></i></a>
                                            </div>
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
        <div class="modal fade" id="NewProduct">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
        
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Adding New Testimonial</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                    <form class="form" action="{{ route('storeTestimonial') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-3">
                            <div class="col-lg-6 col-sm-12">
                                <label for="title" class="form-label">Testimonial Title</label>
                                <input type="text" name="title" class="form-control"
                                    id="title" placeholder="Testimonial Title" required="">
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label for="image" class="form-label">Cover Image<br></label>
                            <div class="input-group">

                                <input type="file" name="image" class="form-control"
                                    id="image" required="">

                            </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6 col-sm-12">
                                <label for="title" class="form-label">Stakeholder's Names</label>
                                <input type="text" name="names" class="form-control"
                                    id="title" placeholder="Names" required="">
                            </div>
                            {{-- <div class="col-lg-6 col-sm-12">
                                <label for="title" class="form-label">Position</label>
                                <input type="text" name="position" class="form-control"
                                    id="title" placeholder="Who is this person?">
                            </div> --}}
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <label for="summernote" class="form-label">Testimony Description</label>
                                <textarea id="progTestimony" rows="5" class="form-control" name="testimony"></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary text-black">
                            <i class="fa fa-save"></i> Publish
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
        @include('admin.includes.footer')
 @endsection