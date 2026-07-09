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

            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Registered Guests</h6>
                        <form action="{{ route('getGuests') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">Names</th>
                                    <th scope="col">Birth Date</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guests as $guest)
                                <tr>
                                    <td>{{ $guest->names }}</td>
                                    <td>{{ $guest->dob }}</td>
                                    <td>{{ $guest->phone }}</td>
                                    <td>{{ $guest->email }}</td>
                                    <td>{{ $guest->address }}</td>
                                    <td>{{ $guest->description }}</td>
                                    <td>{{ $guest->status }}</td>
                                    <td>
                                        <div class="button-group">
                                            @if ($guest->status == "Confirmed")
                                            <a class="btn btn-primary">Approved</a>
                                            @else
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#comment_{{ $guest->id }}">
                                                Approve
                                            </button>
                                            <a href="{{ route('deleteGuest', ['id' => $guest->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to do this?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal" id="comment_{{$guest->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                    
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{ $guest->names }}</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                    
                                            <!-- Modal body -->
                                            <div class="modal-body">

                                                <div class="container text-left">
                                                    <p><strong>Phone:</strong> {{ $guest->phone }}</p>
                                                    <p><strong>Email:</strong> {{ $guest->email }}</p>
                                                    <p><strong>Address:</strong> {{ $guest->address }}</p>
                                                    <p><strong>Occupation:</strong> {{ $guest->occupation }}</p>
                                                    <p><strong>Birth Date:</strong> {{ $guest->dob }}</p>
                                                    <hr>
                                                    <p><strong>Special Request:</strong> {{ $guest->description }}</p>
                                                </div>
                                                <form class="form" action="{{ route('approveGuest',['id'=>$guest->id]) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                            
                                                        <div class="row mb-3">

                                                        </div>
                                                    </div>
                            
                                                    <div class="form-actions">
                                                        <button type="submit" class="btn btn-primary text-black">
                                                            <i class="fa fa-save"></i> Approve
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                    
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="color:black">Close</button>
                                            </div>
                                    
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $guests->appends(['search' => request('search')])->links() }}
                        </div>
                    </div>
                    

            </div>
            <!-- Recent Sales End -->



        </div>
        <!-- Content End -->


        @include('admin.includes.footer')
 @endsection