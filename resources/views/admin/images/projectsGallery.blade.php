@extends('layouts.adminWindow')

@section('title', 'Images')

@section('content')

<div id="layoutSidenav">

    <div id="layoutSidenav_content">
        <main>
                    <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Images for <strong>{{$project->title}}</strong></h1>
                        <div class="card">
                            <div class="card-header">
                                <form class="form" action="{{ route('savProjectImage',['pid' =>$project->id]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            {{-- <div class="col-lg-6 col-sm-12">
                                                    <label for="projectinput1">Caption</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Caption if any" name="caption">
                                                </div> --}}

                                                <div class="col-lg-6 col-sm-12">
                                                    <label><span style="color: red">(This Image should compressed to no longer than 600KB pixels)</span></label>
                                                    <label id="projectinput7" class="file center-block">
                                                        <input type="file" id="image" name="image"
                                                            required="">
                                                        <span class="file-custom"></span>
                                                    </label>
                                                </div>
                                        </div>

                                    </div>

                                    <div class="form-actions mt-3 text-black">
                                        <button type="submit" class="btn btn-primary text-black">
                                            <i class="fa fa-save"></i> Upload
                                        </button>

                                    </div>
                                </form>

                            </div>
                            <!-- ./card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>PID</th>
                                            {{-- <th>Caption</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($images as $imag)
                                        <td><img src="{{ asset('storage/images/projects') . $imag->image }}"
                                            alt="" width="120"></td>
                                            <td>{{ $imag->project_id }}</td>
                                            {{-- <td>{{ $imag->caption }}</td> --}}
                                            <td>
                                                <div class="btn-btn-group">
                                                    {{-- <a type="button" href="{{ route('editImage', ['pid' =>$tours->id, 'id' =>$imag->id]) }}"
                                                        class="btn btn-primary">Edit</a> --}}
                                                    <a type="button" href="{{ route('destroyProjectImage', ['pid' =>$imag->id, 'id' =>$imag->id]) }}"
                                                        class="btn btn-danger" onclick="return confirm('Deleting !! Are you sure ?')">Delete</a>
                                                </div>
                                            </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
        </main>


    </div>
</div>

@endsection

@section('scripts')


@endsection
