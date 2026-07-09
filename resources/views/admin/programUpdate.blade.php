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
            <div class="container pt-10">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('getPrograms') }}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ route('updateProgram', $program->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
        
                                <div class="row mb-3">
                                    <div class="col-12 mt-5">
                                        <label for="title" class="form-label">Program Title</label>
                                        <input type="text" name="title" class="form-control"
                                            id="title" value="{{ $program->title }}">

                                            <label id="projectinput7" class="file center-block">
                                                <img src="{{ asset('storage/images/programs/' .$program->image) }}"
                                                    alt="" width="150px">
                                            </label>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label for="image" class="form-label">Cover Image</label>
                                    <div class="input-group">
        
                                        <input type="file" name="image" class="form-control"
                                            id="image">
        
                                    </div>
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="summernote" class="form-label">Description</label>
                                        <textarea id="programDescription" rows="5" class="form-control" name="description">{!! $program->description !!}</textarea>
                                    </div>
                                </div>
        
                            </div>
        
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary text-black">
                                    <i class="fa fa-save"></i> Save Changes
                                </button>

                                <a href="{{ route('getPrograms') }}" class="btn btn-warning">Cancel</a>
        
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- Content End -->

        @include('admin.includes.footer')
 @endsection