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
                        <h6 class="mb-0">Our Trips</h6>
                        <div class="col-dm3">
                            <button type="button" class="btn btn-primary float-left" data-bs-toggle="modal" data-bs-target="#NewProduct">
                                Add New Trip
                              </button>
                        </div>
                        {{-- <a href="">Show All</a> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    {{-- <th scope="col"><input class="form-check-input" type="checkbox"></th> --}}
                                    <th scope="col">Trip Title</th>
                                    <th scope="col">Cover Image</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trips as $rs)
                                <tr>
                                    {{-- <td><input class="form-check-input" type="checkbox"></td> --}}
                                    <td><a href="{{ route('editTrip',['id'=>$rs->id]) }}">{{ $rs->title }}</a> 
                                    <br> <spam>{{$rs->images->count()}} Images  
                                    </td>
                                    <td><img src="{{ asset('storage/images/trips/' .$rs->image) }}" alt="" width="120px"></td>
                                    <td>{!! Str::words($rs->description, 50, '...') !!}</td>
                                    <td>
                                        <div class="bg-light rounded ">
                                            <div class="btn-group" role="group">
                                                {{-- <button type="button" class="btn btn-danger"><i class="fa fa-eye"></i></button> --}}
                                                <a href="{{ route('editTrip',['id'=>$rs->id]) }}" class="btn btn-info"><i class="fa fa-images"></i></a>
                                                <a href="{{ route('deleteTrip',['id'=>$rs->id]) }}" class="btn btn-warning"  onclick="return confirm('Are you sure to delete this item?')"><i class="fa fa-trash"></i></a>
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
                <h4 class="modal-title">Adding New Trip</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                    <form class="form" action="{{ route('storeTrip') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                    
                            <div class="row mb-3">
                                <div class="col-lg-8 col-sm-12">
                                    <label for="title" class="form-label">Trip Title</label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Eg: Heading" required>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="image" class="form-label">Cover Image</label>
                                    <input type="file" name="image" class="form-control" id="image">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label for="tripDescription" class="form-label">Trip Description</label>
                                    <textarea id="tripDescription" rows="5" class="form-control" name="description" placeholder="Brief description of the trip"></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4 col-sm-12">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" name="location" class="form-control" id="location" placeholder="Eg: Location" required>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="duration" class="form-label">Duration</label>
                                    <input type="text" name="duration" class="form-control" id="duration" placeholder="Eg: 7 Days" required>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="languages" class="form-label">Languages</label>
                                    <input type="text" name="languages" class="form-control" id="languages" placeholder="Eg: English, Spanish">
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <div class="col-lg-4 col-sm-12">
                                    <label for="currency" class="form-label">Currency</label>
                                    <input type="text" name="currency" class="form-control" id="currency" placeholder="Eg: USD">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="maxPeople" class="form-label">Max People</label>
                                    <input type="text" name="maxPeople" class="form-control" id="maxPeople" placeholder="Eg: 50">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="minAge" class="form-label">Min Age</label>
                                    <input type="text" name="minAge" class="form-control" id="minAge" placeholder="Eg: 18">
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <div class="col-lg-4 col-sm-12">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" name="price" class="form-control" id="price" placeholder="Eg: 1000" required>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="couplePrice" class="form-label">Couple Price</label>
                                    <input type="number" name="couplePrice" class="form-control" id="couplePrice" placeholder="Eg: 1800">
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label for="itinerary" class="form-label">Itinerary</label>
                                    <textarea id="itinerary" rows="5" class="form-control" name="itinerary"></textarea>
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label for="expectations" class="form-label">Expectations</label>
                                    <textarea id="expectations" rows="5" class="form-control" name="expectations"></textarea>
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label for="recommendations" class="form-label">Recommendations</label>
                                    <textarea id="recommendations" rows="5" class="form-control" name="recommendations"></textarea>
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label for="inclusions" class="form-label">Inclusions</label>
                                    <textarea id="inclusions" rows="5" class="form-control" name="inclusions"></textarea>
                                </div>
                            </div>
                    
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label for="exclusions" class="form-label">Exclusions</label>
                                    <textarea id="exclusions" rows="5" class="form-control" name="exclusions"></textarea>
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