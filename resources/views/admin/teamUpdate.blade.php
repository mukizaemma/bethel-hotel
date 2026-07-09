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
                        <a href="{{ route('staff') }}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ url('updateStaff',$team->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">

                                <div class="row mb-3">
                                    <div class="col-lg-6 col-sm-12">
                                        <label for="title" class="form-label">Names</label>
                                        <input type="text" name="names" class="form-control"
                                            id="title" value="{{ $team->names }}" >
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <label for="title" class="form-label">Emails</label>
                                        <input type="text" name="website" class="form-control"
                                            id="title" value="{{ $team->website }}" >
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <label for="title" class="form-label">Position</label>
                                        <input type="text" name="position" class="form-control"
                                            id="title"  value="{{ $team->position }}">
                                    </div>

                                </div>

                                {{-- <div class="row mb-3">
                                    <div class="col-lg-4 col-sm-12">
                                        <label for="title" class="form-label">Facebook Profile Url</label>
                                        <input type="text" name="facebook" class="form-control"
                                            id="title" value="{{ $team->facebook }}">
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label for="title" class="form-label">Twitter Profile Url</label>
                                        <input type="text" name="twitter" class="form-control"
                                            id="title" value="{{ $team->twitter }}">
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label for="title" class="form-label">Linkedin Profile Url</label>
                                        <input type="text" name="linkedin" class="form-control"
                                            id="title" value="{{ $team->linkedin }}">
                                    </div>
                                </div> --}}

                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="summernote" class="form-label">Description</label>
                                        {{-- <textarea class="form-control" id="blogBody" rows="5" name="body"></textarea> --}}
                                        <textarea id="bioDescription" rows="5" class="form-control" name="description">{{ $team->description }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-12">
                                        <label for="image" class="form-label">Profile Image<br> <span
                                                style="color: red">(This Image should compressed to 600X400
                                                pixels and less than 400KB)</span></label>
                                            <img src="{{ asset('storage/images/team/' . $team->image) }}" alt="" width="120px">
                                    </div>
                                    <div class="col-lg-5 col-sm-12">
                                        <label for="image" class="form-label">Profile Image<br> <span
                                                style="color: red">(This Image should not exceed 500X800
                                                pixels)</span></label>
                                        <div class="input-group">

                                            <input type="file" name="image" class="form-control"
                                                id="image">

                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-3 col-sm-12">
                                        <label for="title" class="form-label">Display on website?</label>
                                        <select name="display" >
                                            <option value="{{ $team->display }}">{{ $team->display }}</option>
                                            <option value="true">Yes</option>
                                            <option value="false">No</option>
                                        </select>
                                    </div> --}}

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
        <!-- Content End -->

        @include('admin.includes.footer')
 @endsection