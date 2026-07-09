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


                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="btn btn-primary">About Us Page</h2>
                                    @if (session()->has('success'))
                                        <div class="arlert alert-success">
                                            <button class="close" type="button" data-dismiss="alert">X</button>
                                            {{ session()->get('success') }}
                                        </div>
                                    @endif

                                    <a href="{{ route('slides') }}" class="btn btn-primary">Sliding Images</a>
                                    {{-- <a href="{{ route('slides') }}" class="btn btn-primary">Our Core Values</a> --}}

                                </div>
                                <!-- ./card-header -->
                                <div class="card-body">
                                    <form class="form" action="{{ route('saveAbout', $data->id) }}" method="POST" enctype="multipart/form-data" style="padding: 20px; background: #f9f9f9; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                                        @csrf
                                        <div class="form-body">
                                            <!-- About Title -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <label for="projectinput4" style="font-weight: bold;">About Title</label>
                                                    <input type="text" class="form-control" value="{{ $data->title }}" name="title" style="padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
                                                </div>
                                            </div>
                                    
                                            <!-- Header Image + Description -->
                                            <div class="row mb-5" style="align-items: center;">
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label style="font-weight: bold;">Home About Image</label><br>
                                                    <img src="{{ asset('storage/images/about') . $data->image1 }}" alt="" width="150px" style="border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); margin-bottom: 10px;">
                                                    <br>
                                                    <label style="font-size: 14px; color: #333;">Click here to Change Header Image</label>
                                                    <input type="file" name="image1" style="margin-top: 10px;">
                                                </div>
                                    
                                                <div class="col-lg-6 col-sm-12">
                                                    <label for="welcomeMessage" class="form-label" style="font-weight: bold;">About Description</label>
                                                    <textarea id="welcomeMessage" rows="5" class="form-control" name="founderDescription" style="padding: 10px; border-radius: 8px;">{!! $data->founderDescription !!}</textarea>
                                                </div>
                                    

                                            </div>
                                    

                                            <div class="row mb-4">
                                                @foreach ([
                                                    ['label' => 'About us page Image', 'name' => 'image2', 'src' => $data->image2],
                                                    ['label' => 'Contact Top Image', 'name' => 'image3', 'src' => $data->image3],
                                                    ['label' => 'Contact Middle Image', 'name' => 'image4', 'src' => $data->image4],
                                                    ['label' => 'Bottom Image', 'name' => 'storyImage', 'src' => $data->storyImage]
                                                ] as $img)
                                                    <div class="col-lg-4 col-sm-12 mb-4 text-center">
                                                        <label style="font-weight: bold;">{{ $img['label'] }}</label><br>
                                                        <img src="{{ asset('storage/images/about') . $img['src'] }}" alt="" width="150px" style="border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); margin-bottom: 10px;">
                                                        <br>
                                                        <label style="font-size: 14px;">Change {{ strtolower($img['label']) }}</label>
                                                        <input type="file" name="{{ $img['name'] }}" style="margin-top: 10px;">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <!-- Values -->
                                            <div class="row d-flex flex-wrap mb-4" style="min-height: 300px;">
                                                <div class="col-lg-12 d-flex flex-column h-100">
                                                    <label style="font-weight: bold;">Our Moto</label>
                                                    <textarea rows="4" class="form-control flex-grow-1" name="mission" style="padding: 10px; border-radius: 8px;">{!! $data->mission !!}</textarea>
                                                </div>
                                                {{-- <div class="col-lg-6 col-sm-12 mb-3 d-flex flex-column h-100">
                                                    <label style="font-weight: bold;">Value 2</label>
                                                    <textarea rows="4" class="form-control flex-grow-1" name="vision" style="padding: 10px; border-radius: 8px;">{!! $data->vision !!}</textarea>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-3 d-flex flex-column h-100">
                                                    <label style="font-weight: bold;">Value 3</label>
                                                    <textarea rows="4" class="form-control flex-grow-1" name="subTitle" style="padding: 10px; border-radius: 8px;">{!! $data->subTitle !!}</textarea>
                                                </div> --}}
                                            </div>
                                            
                                    
                                            <!-- Middle Background Image -->
                                            {{-- <div class="row mb-4" style="background-color: #e0f7ff; padding: 15px; border-radius: 8px;">
                                                <div class="col-lg-6 col-sm-12 text-center">
                                                    <label style="font-weight: bold;">Middle Background Image</label><br>
                                                    <img src="{{ asset('storage/images/about') . $data->storyImage }}" alt="" width="150px" style="border-radius: 10px; margin-top: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                                </div>
                                                <div class="col-lg-6 col-sm-12">
                                                    <label style="font-weight: bold;">Change Middle Background Image</label><br>
                                                    <input type="file" name="storyImage" style="margin-top: 10px;">
                                                </div>
                                            </div> --}}

                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="welcomeMessage" class="form-label" style="font-weight: bold;">Terms and Conditions</label>
                                                    <textarea id="storyDescription" rows="5" class="form-control" name="storyDescription" style="padding: 10px; border-radius: 8px;">{!! $data->storyDescription !!}</textarea>
                                                </div>
                                            </div>
                                    
                                            <!-- Additional Images -->

                                    
                                            <!-- Submit Button -->
                                            <div class="form-actions mt-4 text-center">
                                                <button type="submit" class="btn btn-secondary" style="padding: 10px 20px; border-radius: 8px; font-size: 16px; background-color: #007bff; border: none;">
                                                    <i class="fa fa-save"></i> Update Changes
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->


                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->


        </div>
        <!-- Content End -->


        @include('admin.includes.footer')

 @endsection