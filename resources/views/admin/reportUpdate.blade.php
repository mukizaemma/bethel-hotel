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
                        <a href="{{ route('getReports') }}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ route('updateReport', $report->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-lg-6 col-sm-12">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" name="title" class="form-control" id="title" value="{{ $report->title }}">
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label for="url" class="form-label">PDF Link</label>
                                        <input type="text" name="url" class="form-control" id="url" value="{{ $report->url }}">
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
        <!-- Content End -->

        @include('admin.includes.footer')
 @endsection