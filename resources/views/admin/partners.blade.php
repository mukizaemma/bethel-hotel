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
                <div class="bg-light text-center rounded p-4">
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
                    
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Our Partners</h6>
                        <div class="col-dm3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#slideImage">
                                Add New Partner
                              </button>
                        </div>
                        {{-- <a href="">Show All</a> --}}
                    </div>
                    <div class="table-responsive">

                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Name </th>
                                    <th>Website </th>
                                    <th>Logo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($partners as $rs)
                                <tr>
                                    <td><a href="{{ route('editPartner', $rs->id) }}">{{$rs->name}}</a></td>
                                    <td><a href="{{$rs->website}}" target="_blank">{{$rs->website}}</a> </td>
                                    <td>
                                        <a href="{{ route('editPartner', $rs->id) }}"><img src="{{asset('storage/images/partners/'.$rs->image)}}" alt="" width="150px"></a>
                                    
                                    </td>
                                    <td>  
                                        <div class="btn-btn-group d-flex">
                                        <a type="button" href="{{ route('editPartner', $rs->id) }}"
                                            class="btn btn-primary text-black">Edit</a>
                                        <a type="button" href="{{ route('destroyPartner', $rs->id) }}"
                                            class="btn btn-danger text-black" onclick="return confirm(`Are you sure to delete this item?`)">Delete</a>
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
        <div class="modal fade" id="slideImage">
            <div class="modal-dialog modal-lg">
            <form class="form" action="{{ route('savePartner') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
        
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Adding New Partner</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                        <div class="form-body">
                            <div class="row mb-4">
                                <div class="col-lg-6 col-sm-12">
                                        <label>Partner Logo</label>
                                        <label id="projectinput7" class="file center-block">
                                            <input type="file" id="image" name="image"
                                                required="">
                                            <span class="file-custom"></span>
                                        </label>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-6 col-sm-12">
                                    <label for="projectinput8">Company Name </label>
                                    <input type="text" class="form-control"
                                    placeholder="Image heading" name="name">
                            </div>

                                <div class="col-lg-6 col-sm-12">
                                    <label for="projectinput8">Website Url</label>
                                    <input type="text" class="form-control"
                                    placeholder="Eg: https://www.iremetech.com" name="website">
                            </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="summernote" class="form-label">Partnership Description</label>
                                    <textarea id="description" rows="5" class="form-control" name="description"></textarea>
                                </div>
                            </div>
                        </div>

                </div>
        
                <!-- Modal footer --> 
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-black">
                        <i class="fa fa-save"></i> Add New 
                    </button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
        
            </div>
            </form>
            </div>
        </div>
        @include('admin.includes.footer')
 @endsection