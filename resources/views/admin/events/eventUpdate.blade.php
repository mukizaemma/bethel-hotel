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
                {{-- <h1 class="mt-4">Dashboard</h1> --}}
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Updating <strong>{{$post->title}}</strong></li>
                </ol>
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

                <div class="container-fluid px-4">

                    <div class="card mb-4">

                        <div class="card-body">
                            <form class="form" action="{{ route('updateBlog',$post->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" name="title" class="form-control"
                                                id="title" value="{{$post->title}}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4 col-sm-12">
                                            <label for="title" class="form-label">Venue</label>
                                            <input type="text" name="venue" class="form-control"
                                                id="title" value="{{$post->venue}}">
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="date" name="date" class="form-control"
                                                id="title" value="{{$post->date}}">
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="time" name="time" class="form-control"
                                                id="title" value="{{$post->time}}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="summernote" class="form-label">Description</label>
                                            <textarea id="Blogs" rows="5" class="form-control" name="description">{!!$post->description!!}</textarea>
                                        </div>
                                    </div>

                                    <div  class="row mt-3">
                                        <div class="col-lg-4 col-sm-12">
                                            <label for="image" class="form-label">Cover Image<br> <span style="color: red">(This Image should be compressed to not beger than 600KB)</span></label>
                                            <img src="{{ asset('storage/images/events/' . $post->image) }}" alt="" width="120px">
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label for="image" class="form-label">Change Cover Image<br> <span style="color: red">(This image should be resized to 500X800 pixels)</span></label>
                                            <div class="input-group">

                                                <input type="file" name="image" class="form-control" id="image">

                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label for="image" class="form-label">Publish Status</label>
                                            <div class="form-group">
                                                <input type="radio" id="publish" name="status" value="Published" {{ $post->status == 'Published' ? 'checked' : '' }}>
                                                <label for="publish" style="{{ $post->status == 'Published' ? 'color: green;' : '' }}">Publish(This won't send notifications)</label><br>
                                                <input type="radio" id="unpublish" name="status" value="Unpublished" {{ $post->status == 'Unpublished' ? 'checked' : '' }}>
                                                <label for="unpublish" style="{{ $post->status == 'Unpublished' ? 'color: red;' : '' }}">Unpublish</label><br>
                                            </div>
                                            

                                        </div>

                                    </div>
                                </div>

                                <div class="form-actions">
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
        <!-- Content End -->

        @include('admin.includes.footer')
 @endsection