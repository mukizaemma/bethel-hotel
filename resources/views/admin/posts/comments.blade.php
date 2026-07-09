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
                        <h6 class="mb-0">Manage Comments</h6>
                    </div>
                
                    <!-- Tabs for Filters -->
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a class="nav-link {{ $filter === 'all' ? 'active' : '' }}" 
                               href="{{ route('blogsComment', ['filter' => 'all']) }}">All Comments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $filter === 'published' ? 'active' : '' }}" 
                               href="{{ route('blogsComment', ['filter' => 'published']) }}">Published Comments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $filter === 'unpublished' ? 'active' : '' }}" 
                               href="{{ route('blogsComment', ['filter' => 'unpublished']) }}">Unpublished Comments</a>
                        </li>
                    </ul>
                
                    <!-- Table Section -->
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">Date</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col">Publication</th>
                                    <th scope="col">Names</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" style="width:150px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comments as $comment)
                                <tr>
                                    <td>{{ $comment->created_at }}</td>
                                    <td>{!! \Illuminate\Support\Str::limit(strip_tags($comment->comment), 50) !!}</td>
                                    <td>{{ $comment->blog->title ?? '' }}</td>
                                    <td>{{ $comment->names ?? '' }}</td>
                                    <td>{{ $comment->email ?? '' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#comment_{{ $comment->id }}">
                                                {{ $comment->status === 'Unpublished' ? 'View' : 'Approved' }}
                                            </button>
                                            <a href="{{ route('destroyBlogComment', ['id' => $comment->id]) }}" 
                                               class="btn btn-warning btn-sm" 
                                               onclick="return confirm('Are you sure to do this?')"> 
                                               <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal" id="comment_{{ $comment->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Commented By: {{ $comment->names }}</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ $comment->comment }}</p>
                                                <form class="form" action="{{ route('commentApprove', ['comment' => $comment->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary text-black">
                                                        <i class="fa fa-save"></i> Approve
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="color:black">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div style="margin-top: 20px;">
                            {{ $comments->links('pagination::simple-bootstrap-4') }}
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- Recent Sales End -->



            <!-- Footer Start -->
          
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        @include('admin.includes.footer')

 @endsection