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

                <div class="card mb-4">
                    <div class="card-header">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                            <i class="fa fa-plus"></i> Add New Job
                        </button>
                    </div>
                    <div class="card-body">
                        <!-- Tabs for filtering -->
                        <ul class="nav nav-tabs mb-3" id="blogTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="latest-tab" data-bs-toggle="tab" data-bs-target="#latest" 
                                    type="button" role="tab" aria-controls="latest" aria-selected="true">
                                    Latest
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="views-tab" data-bs-toggle="tab" data-bs-target="#views" 
                                    type="button" role="tab" aria-controls="views" aria-selected="false">
                                    Most Viewed
                                </button>
                            </li>
                        </ul>
                
                        <!-- Tab Contents -->
                        <div class="tab-content" id="blogTabContent">
                            <!-- Latest Blogs Tab -->
                            <div class="tab-pane fade show active" id="latest" role="tabpanel" aria-labelledby="latest-tab">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Cover Image</th>
                                            <th>Title</th>
                                            <th style="width:300px;">Description</th>
                                            <th>Views</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($latestBlogs as $rs)
                                            <tr>
                                                <td><img src="{{ asset('storage/images/blogs/' . $rs->image) }}" alt="" width="150px"></td>
                                                <td><a href="{{ route('viewBlog', $rs->id) }}">{{ $rs->title }}</a></td>
                                                <td>{!! $rs->short_body !!}</td>
                                                <td style="text-align: center;">
                                                    <i class="fa fa-eye" style="margin-left: 15px; margin-right: 5px;"></i><a href="{{ route('viewBlog', $rs->id) }}">{{ $rs->views }}</a> 
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($rs->status !== "Published")
                                                            <a href="{{ route('publishBlog', $rs->id) }}" class="btn btn-primary text-black mr-2" 
                                                                onclick="return confirm('Are you sure to publish this Story?')">
                                                                Publish
                                                            </a>
                                                        @else
                                                            <span class="btn btn-secondary">Published</span>
                                                        @endif
                                                        <a href="{{ route('editBlog', $rs->id) }}" class="btn btn-primary text-black mr-2">
                                                            <i class="fa fa-pen"></i>
                                                        </a>
                                                        <form action="{{ route('deleteBlog', $rs->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('GET')
                                                            <button type="submit" class="btn btn-danger text-black" 
                                                                onclick="return confirm('Are you sure to delete this item?')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                
                            <!-- Most Viewed Blogs Tab -->
                            <div class="tab-pane fade" id="views" role="tabpanel" aria-labelledby="views-tab">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Cover Image</th>
                                            <th>Title</th>
                                            <th style="width:300px;">Description</th>
                                            <th>Views</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mostViewedBlogs as $rs)
                                            <tr>
                                                <td><img src="{{ asset('storage/images/blogs/' . $rs->image) }}" alt="" width="150px"></td>
                                                <td><a href="{{ route('viewBlog', $rs->id) }}">{{ $rs->title }}</a></td>
                                                <td>{!! $rs->short_body !!}</td>
                                                <td style="text-align: center;">
                                                    <i class="fa fa-eye" style="margin-left: 15px; margin-right: 5px;"></i> <a href="{{ route('viewBlog',['id'=>$rs->id]) }}">{{ $rs->views }}</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($rs->status !== "Published")
                                                            <a href="{{ route('publishBlog', $rs->id) }}" class="btn btn-primary text-black mr-2" 
                                                                onclick="return confirm('Are you sure to publish this Story?')">
                                                                Publish
                                                            </a>
                                                        @else
                                                            <span class="btn btn-secondary">Published</span>
                                                        @endif
                                                        <a href="{{ route('editBlog', $rs->id) }}" class="btn btn-primary text-black mr-2">
                                                            <i class="fa fa-pen"></i>
                                                        </a>
                                                        <form action="{{ route('deleteBlog', $rs->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('GET')
                                                            <button type="submit" class="btn btn-danger text-black" 
                                                                onclick="return confirm('Are you sure to delete this item?')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
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
                
                <!-- The Modal for adding new Event -->
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Adding New Blog</h4>
                                <button type="button" class="btn-close text-black" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form class="form" action="{{ route('saveBlog') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">

                                        <div class="row mb-3">
                                            <div class="col-lg-12">
                                                <label for="title" class="form-label">Blog Title</label>
                                                <input type="text" name="title" class="form-control"
                                                    id="title" placeholder="Title" required="">
                                            </div>
                                            <div class="col-lg-5 col-sm-12">
                                                <label for="title" class="form-label">Blog Category</label>
                                                <select name="category_id" id="">

                                                    <option value="" disabled selected>Select Category</option>
                                                    @foreach($blogCategories as $categ)
                                                    <option value="{{ $categ->id }}">{{ $categ->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="summernote" class="form-label">Blog Details</label>
                                                <textarea id="Blogs" rows="5" class="form-control" name="body"></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 col-sm-12">
                                                <label for="image" class="form-label">Cover Image</label>
                                                <div class="input-group">

                                                    <input type="file" name="image" class="form-control"
                                                        id="image">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary text-black">
                                            <i class="fa fa-save"></i> Save Draft
                                        </button>

                                    </div>
                                </form>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger text-black"
                                    data-bs-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- Content End -->
        @include('admin.includes.footer')

 @endsection