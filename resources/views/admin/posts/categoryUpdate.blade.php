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

                <div class="bg-light rounded p-4">
                    <h2><strong>Updating</strong> {{ $category->name }}</h2>

                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <form class="form" action="{{ route('updateCategory', $category->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <label for="title" class="form-label">Category Name</label>
                                            <input type="text" name="name" class="form-control"
                                                id="title" value="{{ $category->name }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="summernote" class="form-label">Description</label>
                                            <textarea id="description" rows="5" class="form-control" name="description">{!! $category->description !!}</textarea>
                                        </div>
                                    </div>
            
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            <label for="image" class="form-label">Featured Image<br></label>
                                            <div class="input-group">
                                                <img src="{{ asset('storage/images/blogs/' . $category->image) }}" alt="" width="120px">
            
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label for="image" class="form-label">Change featured Image</label>
                                            <div class="input-group">
            
                                                <input type="file" name="image" class="form-control"
                                                    id="image">
            
                                            </div>
                                        </div>
            
                                    </div>
                                          
            
                                    <div class="form-actions mt-5">
                                        <button type="submit" class="btn btn-primary text-black">
                                            <i class="fa fa-save"></i> Save Changes
                                        </button>

                                        <a href="{{ route('getCategories') }}" class="btn btn-secondary">Back to Categories</a>
            
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