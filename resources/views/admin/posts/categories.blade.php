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
                
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Categories</h6>
                        <div class="col-dm3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#NewProduct">
                                Add New Category
                              </button>
                              <a href="{{ route('getBlogs') }}" class="btn btn-light">Resources</a>
                        </div>
                        {{-- <a href="">Show All</a> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    {{-- <th scope="col"><input class="form-check-input" type="checkbox"></th> --}}
                                    <th scope="col">Category Name</th>
                                    <th scope="col">Cover Image</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">No of Blogs</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $rs)
                                <tr>
                                    {{-- <td><input class="form-check-input" type="checkbox"></td> --}}
                                    <td><a href="{{ route('editCategory',['id'=>$rs->id]) }}">{{ $rs->name }}</a></td>
                                    <td><img src="{{ asset('storage/images/blogs/' .$rs->image) }}" alt="" width="120px"></td>
                                    <td>{!! $rs->description !!}</td>
                                    <td>{{ $rs->blogs->count() }} blogs</td>
                                    <td>
                                        <div class="bg-light rounded ">
                                            <div class="btn-group" role="group">
                                                {{-- <button type="button" class="btn btn-danger"><i class="fa fa-eye"></i></button> --}}
                                                <a href="{{ route('editCategory',['id'=>$rs->id]) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('deleteCategory',['id'=>$rs->id]) }}" class="btn btn-warning" onclick="return confirm('Are you sure to delete this category?') "><i class="fa fa-trash"></i></a>
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
                <h4 class="modal-title">Adding New Category</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                    <form class="form" action="{{ route('postCategory') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="title" class="form-label">Category Name</label>
                                <input type="text" name="name" class="form-control"
                                    id="title" placeholder="Category Name" required="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <label for="summernote" class="form-label">Category Description</label>
                                {{-- <textarea class="form-control" id="blogBody" rows="5" name="body"></textarea> --}}
                                <textarea id="description" rows="5" class="form-control" name="description"></textarea>
                            </div>
                            {{-- <div class="col-lg-12">
                                <label for="summernote" class="form-label">Delivery Details</label>
                                <textarea id="shipingInfo" rows="5" class="form-control" name="shipingInfo"></textarea>
                            </div> --}}
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <label for="image" class="form-label">Image</label>
                                <div class="input-group">
                                    <input type="file" name="image" class="form-control"
                                        id="image">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary text-black">
                            <i class="fa fa-save"></i> Save
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