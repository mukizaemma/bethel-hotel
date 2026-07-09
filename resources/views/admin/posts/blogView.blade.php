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
                    <li class="breadcrumb-item active">{{$post->title}}</li>
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

                <div class="container-fluid px-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <!-- Blog Details -->
                            <form class="form" action="{{ route('updateBlog',$post->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <!-- Blog Title -->
                                    <div class="row mb-4">
                                        <div class="col-lg-6 col-sm-12">
                                            <h3 class="form-label">Blog Title</h3>
                                            <input type="text" name="title" class="form-control bg-light text-dark border-0"
                                                id="title" value="{{$post->title}}" readonly>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <h5 class="form-label">Cover Image</h5>
                                            <img src="{{ asset('storage/images/blogs/' . $post->image) }}" alt="Blog Cover Image" class="img-fluid rounded shadow" width="120px">
                                        </div>
                                    </div>
                
                                    <!-- Blog Description -->
                                    <div class="row mb-4">
                                        <div class="col-lg-12">
                                            <h4 class="form-label">Description</h4>
                                            <textarea id="Blogs" rows="5" class="form-control bg-light text-dark border-0" name="description" readonly>{!!$post->description!!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                
                    <!-- Comments Section -->
                    <div class="card mt-5">
                        <div class="card-header bg-light text-white">
                            <h5><span style="color: yellow">{{ $totalComments }}</span> Comments</h5>
                        </div>
                        <div class="card-body">
                            @if($comments->count() == 0)
                                <p class="text-muted">No comments yet.</p>
                            @else
                                @foreach($comments as $comment)
                                    <div class="mb-4">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $comment->names }}</h6>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <p class="mt-2 mb-0">{{ $comment->comment }}</p>
                
                                        <!-- Reply Button -->
                                        {{-- <button type="button" class="btn btn-link text-primary p-0 mt-2" data-bs-toggle="modal" data-bs-target="#replyModal-{{ $comment->id }}">
                                            <i class="fa fa-reply"></i> Reply
                                        </button> --}}
                
                                        <hr>
                                    </div>
                
                                    <!-- Reply Modal -->
                                    {{-- <div class="modal fade" id="replyModal-{{ $comment->id }}" tabindex="-1" aria-labelledby="replyModalLabel-{{ $comment->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="replyModalLabel-{{ $comment->id }}">Reply to {{ $comment->visitor_name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('replyComment', $comment->id) }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <textarea class="form-control" name="reply" rows="4" placeholder="Write your reply here..." required></textarea>
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-success px-4 py-2">Send Reply</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                

            </div>

        </div>
        <!-- Content End -->

        @include('admin.includes.footer')
 @endsection