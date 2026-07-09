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
                    <li class="breadcrumb-item active">Events Management</li>
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

                <div class="card mb-4">
                    <div class="card-header">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"><i
                                class="fa fa-plus"></i> Add New Event</button>

                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Event Banner</th>
                                    <th>Title</th>
                                    <th>Venue</th>
                                    <th>Date & Time</th>
                                    <th style="width:300px;">Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($events as $rs)
                                    <tr>
                                        <td><img src="{{ asset('storage/images/events/' . $rs->image) }}" alt="" width="150px"></td>
                                        <td><a href="{{ route('editEvent', $rs->id) }}">{{ $rs->title }}</a></td>

                                        <td>{{ $rs->venue }}</td>
                                        <td>{{ $rs->date }} @ {{ $rs->time }}</td> 
                                        <td>{!! \Illuminate\Support\Str::limit(strip_tags($rs->description), 100) !!}</td>
                                        <td>
                                            <div class="btn-btn-group ">
                                                @if ($rs->status !== "Published")

                                                <a href="{{ route('publishEvent', $rs->id) }}" class="btn btn-primary text-black" data-toggle="tooltip" data-placement="top" title="Edit"
                                                    onclick="return confirm('Are you sure to publish this article?')">
                                                    Publish
                                                </a>

                                                @else
                                                <span class="btn btn-secondary">Published</span>
                                                @endif
                                                <a href="{{ route('editEvent', $rs->id) }}" class="btn btn-primary text-black" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fa fa-pen"></i>
                                                </a>
                                                <form action="{{ route('deleteEvent', $rs->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="submit" class="btn btn-danger text-black" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you sure to delete this item?')">
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
                <!-- The Modal for adding new Event -->
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Adding New Upcoming event</h4>
                                <button type="button" class="btn-close text-black" data-bs-dismiss="modal">X</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form class="form" action="{{ route('saveEvent') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">

                                        <div class="row mb-3">
                                            <div class="col-lg-9 col-sm-12">
                                                <label for="title" class="form-label">Event Title</label>
                                                <input type="text" name="title" class="form-control"
                                                    id="title" placeholder="Theme or Event Title" required="">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4 col-sm-12">
                                                <label for="title" class="form-label">Venue</label>
                                                <input type="text" name="venue" class="form-control"
                                                    id="title" placeholder="Address" required="">
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <label for="title" class="form-label">Date</label>
                                                <input type="date" name="date" class="form-control"
                                                    id="title" placeholder="Event Date" required="">
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <label for="title" class="form-label">Time</label>
                                                <input type="time" name="time" class="form-control"
                                                    id="title" placeholder="Event Time" required="">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="summernote" class="form-label">Description</label>
                                                <textarea id="Blogs" rows="5" class="form-control" name="description" required=""></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 col-sm-12">
                                                <label for="image" class="form-label">Event Banner<br> <span
                                                        style="color: red">(This Image should compressed to 600X400
                                                        pixels and less than 600KB)</span></label>
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