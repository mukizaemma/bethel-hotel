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

                <ul class="nav mt-10">
                    <li class="nav-item mr-20 ">
                        <a href="{{ route('eventsPage') }}" class="btn btn-dark">Back</a>
                    </li>
                    <li class="nav-item ">
                        
                    <li class="breadcrumb-item active">Updating <strong> {{$data->title}}</strong></li>

                    </li>
                </ul>

                <div class="container-fluid px-4">

                    <div class="card mb-4">

                        <div class="card-body">
                            <form class="form" action="{{ route('saveEvent',$data->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" name="title" class="form-control"
                                                id="title" value="{{$data->title}}">
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="summernote" class="form-label">Events Description</label>
                                            <textarea id="eventDescription" rows="5" class="form-control" name="description">{!!$data->description!!}</textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="eventDetails" class="form-label">Details &amp; logistics</label>
                                            <textarea id="eventDetails" rows="5" class="form-control" name="details">{!!$data->details!!}</textarea>
                                        </div>
                                    </div>

                                    {{-- <div  class="row mt-3">
                                        <div class="col-lg-4 col-sm-12">
                                            <label for="image" class="form-label">Cover Image</label>
                                            <img src="{{ asset('storage/images/events/' . $data->image) }}" alt="" width="120px">
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label for="image" class="form-label">Change Cover Image</label>
                                            <div class="input-group">

                                                <input type="file" name="image" class="form-control" id="image">

                                            </div>
                                        </div>

                                    </div> --}}


                                </div>

                                <div class="form-actions mt-5">
                                    <button type="submit" class="btn btn-primary text-black">
                                        <i class="fa fa-save"></i> Update Event Page
                                    </button>

                                    <a href="{{ route('eventsPage') }}" class="btn btn-light">Back</a>


                                </div>
                            </form>
                        </div>
                    </div>

                        {{-- Main page gallery removed: photos are managed per meeting room below. --}}

                        @php
                            $meetingRooms = $meetingRooms ?? collect();
                        @endphp

                        <div class="card mt-5">
                            <div class="card-header bg-dark text-white d-flex align-items-center flex-wrap gap-2">
                                <h5 class="mb-0">Meeting rooms</h5>
                                <span class="text-white-50 small">Cover image, short description, and optional gallery per room</span>
                                <button type="button" class="btn btn-sm btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#addMeetingRoomModal">
                                    Add room
                                </button>
                            </div>
                            <div class="card-body">
                                @forelse($meetingRooms as $room)
                                    <div class="border rounded p-3 mb-4 bg-light">
                                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                                            <h6 class="mb-0">{{ $room->title }} <span class="badge bg-secondary">max {{ $room->max_persons }}</span></h6>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDeleteRoom('{{ route('deleteMeetingRoom', $room->id) }}')">Remove room</button>
                                        </div>
                                        <form action="{{ route('saveMeetingRoom', $room->id) }}" method="POST" enctype="multipart/form-data" class="mb-3">
                                            @csrf
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Room name</label>
                                                    <input type="text" name="title" class="form-control" value="{{ old('title', $room->title) }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Maximum guests</label>
                                                    <input type="number" name="max_persons" class="form-control" min="1" max="10000" value="{{ old('max_persons', $room->max_persons) }}" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Cover image</label>
                                                    @if($room->image)
                                                        <div class="mb-2">
                                                            <img src="{{ asset('storage/images/meeting-rooms/covers/' . $room->image) }}" alt="" class="rounded" style="width: 120px; height: 80px; object-fit: cover;">
                                                        </div>
                                                    @endif
                                                    <input type="file" name="cover_image" class="form-control" accept="image/*">
                                                    <small class="text-muted">Optional — main photo for this room on the public site.</small>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Description</label>
                                                    <textarea id="meetingRoomDesc{{ $room->id }}" name="description" class="form-control" rows="6">{!! old('description', $room->description) !!}</textarea>
                                                    <small class="text-muted">Shown in full on the room page. Listing cards use a short excerpt (first {{ \App\Models\MeetingRoom::GRID_EXCERPT_MAX_CHARS }} characters) automatically.</small>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save room</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="mt-3 pt-3 border-top">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong class="small">Gallery for this room</strong>
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addMeetingRoomImageModal{{ $room->id }}">Add images</button>
                                            </div>
                                            @if($room->images->isEmpty())
                                                <p class="text-muted small mb-0">No gallery images yet.</p>
                                            @else
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered align-middle mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th style="width:90px;">Preview</th>
                                                                <th>Caption</th>
                                                                <th style="width:100px;">Order</th>
                                                                <th style="width:160px;">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($room->images as $mimg)
                                                                <tr>
                                                                    <td>
                                                                        <img src="{{ asset('storage/images/meeting-rooms/gallery/' . $mimg->image) }}" alt="" class="rounded" style="width: 72px; height: 48px; object-fit: cover;">
                                                                    </td>
                                                                    <td>
                                                                        <form action="{{ route('updateMeetingRoomImage', $mimg->id) }}" method="POST" class="d-flex flex-column gap-1">
                                                                            @csrf
                                                                            <input type="text" name="caption" value="{{ old('caption', $mimg->caption) }}" class="form-control form-control-sm" placeholder="Optional caption">
                                                                            <button type="submit" class="btn btn-sm btn-primary align-self-start">Save caption</button>
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <form action="{{ route('reorderMeetingRoomImage', $mimg->id) }}" method="POST" class="d-inline">@csrf
                                                                            <input type="hidden" name="direction" value="up">
                                                                            <button type="submit" class="btn btn-sm btn-outline-secondary">↑</button>
                                                                        </form>
                                                                        <form action="{{ route('reorderMeetingRoomImage', $mimg->id) }}" method="POST" class="d-inline">@csrf
                                                                            <input type="hidden" name="direction" value="down">
                                                                            <button type="submit" class="btn btn-sm btn-outline-secondary">↓</button>
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-sm btn-outline-primary mb-1" data-bs-toggle="modal" data-bs-target="#replaceMeetingRoomImageModal" data-mr-image-id="{{ $mimg->id }}">Replace</button>
                                                                        <br>
                                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('{{ route('deleteMeetingRoomImage', $mimg->id) }}')">Delete</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="modal fade" id="addMeetingRoomImageModal{{ $room->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add images — {{ $room->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('addMeetingRoomImage') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="meeting_room_id" value="{{ $room->id }}">
                                                        <label class="form-label">Images</label>
                                                        <input type="file" name="image[]" class="form-control" multiple accept="image/*" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted mb-0">No meeting rooms yet. Run migration or click &quot;Add room&quot;.</p>
                                @endforelse
                            </div>
                        </div>

                
                </div>



            </div>

        </div>
        <!-- Content End -->

        @include('admin.includes.footer')

        <div class="modal fade" id="addMeetingRoomModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add meeting room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('addMeetingRoom') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="eventpage_id" value="{{ $data->id }}">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Maximum guests</label>
                                <input type="number" name="max_persons" class="form-control" min="1" max="10000" value="50" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmDeleteRoomModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Remove meeting room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">Delete this room and all of its gallery images? This cannot be undone.</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="#" id="deleteMeetingRoomConfirmBtn" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="replaceMeetingRoomImageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Replace gallery image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="replaceMeetingRoomImageForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <label class="form-label">New image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this image? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="" id="deleteConfirmBtn" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl) {
        document.getElementById('deleteConfirmBtn').setAttribute('href', deleteUrl);
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        confirmModal.show();
    }

    function confirmDeleteRoom(deleteUrl) {
        document.getElementById('deleteMeetingRoomConfirmBtn').setAttribute('href', deleteUrl);
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteRoomModal'));
        confirmModal.show();
    }

    (function () {
        var el = document.getElementById('replaceMeetingRoomImageModal');
        if (!el) return;
        el.addEventListener('show.bs.modal', function (event) {
            var btn = event.relatedTarget;
            var id = btn && btn.getAttribute('data-mr-image-id');
            var form = document.getElementById('replaceMeetingRoomImageForm');
            if (form && id) {
                form.action = "{{ url('/updateMeetingRoomImage') }}/" + id;
            }
        });
    })();
</script>
<script>
    $(document).ready(function () {
        @foreach($meetingRooms as $room)
        $('#meetingRoomDesc{{ $room->id }}').summernote({
            placeholder: 'Short description for this room (shown on the public page)',
            tabsize: 2,
            height: 180,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
        @endforeach
    });
</script>

 @endsection