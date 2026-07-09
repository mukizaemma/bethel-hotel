@extends('layouts.adminBase')


@section('content')


        <!-- Sidebar Start -->
@include('admin.includes.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">

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
            <!-- Navbar Start -->
            @include('admin.includes.navbar')
            <!-- Navbar End -->

            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Our Rooms</h6>
                        <div class="col-dm3">
                            <button type="button" class="btn btn-primary float-left" data-bs-toggle="modal" data-bs-target="#NewProduct">
                                Add New Room
                              </button>
                        </div>
                        {{-- <a href="">Show All</a> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    {{-- <th scope="col"><input class="form-check-input" type="checkbox"></th> --}}
                                    <th scope="col">Room Title</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Cover Image</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $rs)
                                <tr>
                                    {{-- <td><input class="form-check-input" type="checkbox"></td> --}}
                                    <td><a href="{{ route('editRoom',['id'=>$rs->id]) }}">{{ $rs->title }}</a> 
                                    <br> <spam>{{$rs->images->count()}} Images  
                                    </td>
                                    <td>{{ $rs->category }}<br> <span class="text-teal">{{ hotel_price($rs->price ?? 0, $setting) }}</span></td>
                                    <td><img src="{{ asset('storage/images/rooms/' .$rs->image) }}" alt="" width="120px"></td>
                                    <td>{!! Str::words($rs->description, 50, '...') !!}</td>
                                    <td>
                                        <div class="bg-light rounded ">
                                            <div class="btn-group" role="group">
                                                {{-- <button type="button" class="btn btn-danger"><i class="fa fa-eye"></i></button> --}}
                                                <a href="{{ route('editRoom',['id'=>$rs->id]) }}" class="btn btn-info"><i class="fa fa-images"></i></a>
                                                <a href="{{ route('deleteRoom',['id'=>$rs->id]) }}" class="btn btn-warning"  onclick="return confirm('Are you sure to delete this item?')"><i class="fa fa-trash"></i></a>
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
                <h4 class="modal-title">Adding New Room</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                    <form class="form" action="{{ route('storeRoom') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-3">
                            <div class="col-lg-12 col-sm-12">
                                <label for="title" class="form-label">Room Title</label>
                                <input type="text" name="title" class="form-control"
                                    id="title" placeholder="Eg: Double Room" required="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-12">
                                <label for="title" class="form-label">Room price / night ({{ price_currency_label($setting) }})</label>
                                <input type="text" name="price" class="form-control"
                                    id="title" placeholder="Eg: 50" required="">
                            </div>
                            <div class="col-lg-8 col-sm-12">
                                <label for="image" class="form-label">Cover Image</label>
                            <div class="input-group">

                                <input type="file" name="image" class="form-control"
                                    id="image" required="">

                            </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <label for="summernote" class="form-label">Description</label>
                                <textarea id="description" rows="5" class="form-control" name="description"></textarea>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <label class="form-label">Select Room Amenities</label>
                                <div class="row">
                                    @foreach($amenities as $amenity)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="amenities[]" 
                                                       value="{{ $amenity->id }}" 
                                                       id="amenity{{ $amenity->id }}">
                                                <label class="form-check-label" for="amenity{{ $amenity->id }}">
                                                    {{ $amenity->title }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
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