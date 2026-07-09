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
                    <div class="card mb-4">
                        <div class="card-header">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"><i
                                    class="fa fa-plus"></i> Add New Team Member</button>

                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Names</th>
                                        <th>Position</th>
                                        <th>Image</th>
                                        <th>Biograpgy</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($team as $rs)
                                        <tr>
                                            <td><a href="{{ route('editStaff', $rs->id) }}">{{ $rs->names }}</a></td>
                                            <td>{{ $rs->position }}</td>
                                            <td><img src="{{ asset('storage/images/team/' . $rs->image) }}" alt="" width="150px"></td>
                                            <td>{!! $rs->description !!}</td>
                                            <td>{{$rs->created_at}}</td>
                                            <td>
                                                <div class="btn-btn-group ">
                                                    <a type="button" href="{{ route('editStaff', $rs->id) }}" class="btn btn-primary text-black">Edit</a>
                                                    <a type="button" href="{{ route('deleteStaff', $rs->id) }}" class="btn btn-danger text-black"
                                                        onclick=" return confirm('Are you sure to delete this member?')">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- The Modal for adding new Event -->
                    <div class="modal fade" id="myModal">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Adding New Team Member</h4>
                                    <button type="button" class="btn-close text-black" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form class="form" action="{{ route('saveStaff') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">

                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="title" class="form-label">Names</label>
                                                    <input type="text" name="names" class="form-control"
                                                        id="title" placeholder="Full Names" required="">
                                                </div>

                                                <div class="row mb-3">
                                                    {{-- <div class="col-lg-4 col-sm-12 mt-3">
                                                        <select name="department" id="">
                                                            <label for="title" class="form-label">Department</label>
                                                            <option value="Advisory Team">Advisory Team</option>
                                                            <option value="Leadership Team">Leadership Team</option>
                                                            <option value="Community Facilitator">Community Facilitator</option>
                                                            <option value="Volunteers">Volunteers</option>
                                                        </select>
                                                    </div> --}}
                                                    <div class="col-lg-6 col-sm-12">
                                                        <label for="title" class="form-label">Job Title</label>
                                                        <input type="text" name="position" class="form-control"
                                                            id="title" placeholder="Position" required="">
                                                    </div>
                                                    <div class="col-lg-6 col-sm-12">
                                                        <label for="title" class="form-label">Email</label>
                                                        <input type="text" name="website" class="form-control"
                                                            id="title" placeholder="Email">
                                                    </div>
                                                </div>

                                                {{-- <div class="row mb-3">
                                                    <div class="col-lg-4 col-sm-12">
                                                        <label for="title" class="form-label">Facebook Profile Url</label>
                                                        <input type="text" name="facebook" class="form-control"
                                                            id="title" placeholder="facebook" required="">
                                                    </div>
                                                    <div class="col-lg-4 col-sm-12">
                                                        <label for="title" class="form-label">Twitter Profile Url</label>
                                                        <input type="text" name="twitter" class="form-control"
                                                            id="title" placeholder="twitter" required="">
                                                    </div>
                                                    <div class="col-lg-4 col-sm-12">
                                                        <label for="title" class="form-label">Linkedin Profile Url</label>
                                                        <input type="text" name="linkedin" class="form-control"
                                                            id="title" placeholder="linkedin" required="">
                                                    </div>
                                                </div> --}}

                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="summernote" class="form-label">Biography</label>
                                                    {{-- <textarea class="form-control" id="blogBody" rows="5" name="body"></textarea> --}}
                                                    <textarea id="bioDescription" rows="5" class="form-control" name="description"></textarea>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-sm-12">
                                                    <label for="image" class="form-label">Profile Image<br> <span
                                                            style="color: red">(This Image should compressed to 600KB)</span></label>
                                                    <div class="input-group">

                                                        <input type="file" name="image" class="form-control"
                                                            id="image">

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary text-black">
                                                <i class="fa fa-save"></i> Add New
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