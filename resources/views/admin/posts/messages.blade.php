@extends('layouts.adminBase')

@section('content')

@include('admin.includes.sidebar')

<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                <h6 class="mb-0">Website enquiries</h6>
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search subject or name" class="form-control" style="width: 220px;">
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">Date</th>
                            <th scope="col">Type</th>
                            <th scope="col">Subject / room</th>
                            <th scope="col">Names</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col" style="min-width:200px">Message</th>
                            <th scope="col">Reply</th>
                            <th scope="col" style="min-width:140px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $rs)
                        <tr>
                            <td>{{ $rs->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                @if(($rs->enquiry_type ?? 'general') === 'room')
                                    <span class="badge badge-info">Room</span>
                                @elseif(($rs->enquiry_type ?? '') === 'meetings')
                                    <span class="badge badge-primary">Meeting</span>
                                @elseif(($rs->enquiry_type ?? '') === 'dining')
                                    <span class="badge badge-success">Dining</span>
                                @elseif(($rs->enquiry_type ?? '') === 'proposal')
                                    <span class="badge badge-primary">Proposal</span>
                                @else
                                    <span class="badge badge-secondary">General</span>
                                @endif
                            </td>
                            <td>
                                @if(($rs->enquiry_type ?? 'general') === 'room' && $rs->room)
                                    {{ $rs->room->title }}
                                    <br><small class="text-muted">{{ $rs->checkin_date?->format('Y-m-d') }} → {{ $rs->checkout_date?->format('Y-m-d') }}</small>
                                @else
                                    {{ $rs->subject ?? '—' }}
                                @endif
                            </td>
                            <td>{{ $rs->names }}</td>
                            <td>{{ $rs->phone ?? '—' }}</td>
                            <td>{{ $rs->email ?? '—' }}</td>
                            <td><small>{{ \Illuminate\Support\Str::limit(strip_tags($rs->message ?? ''), 120) }}</small></td>
                            <td>
                                @if($rs->replied_at)
                                    <small class="text-success">{{ $rs->replied_at->format('Y-m-d') }}</small>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group-vertical btn-group-sm">
                                    <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#replyModal{{ $rs->id }}">Reply</button>
                                    <a href="{{ route('deleteMessages', $rs->id) }}" class="btn btn-danger text-white" onclick="return confirm('Delete this enquiry?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9">{{ $messages->links() }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($messages as $rs)
<div class="modal fade" id="replyModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('replyMessage', $rs->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reply to {{ $rs->names }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <p class="small text-muted mb-2">
                        @if($rs->email)
                            Email will be sent to: <strong>{{ $rs->email }}</strong>
                        @else
                            No email on file — your reply will be saved only.
                        @endif
                    </p>
                    <div class="mb-3 p-2 bg-light rounded small" style="max-height: 160px; overflow-y: auto;">
                        <strong>Original message</strong><br>
                        {{ $rs->message ?? '—' }}
                    </div>
                    <label for="reply_subject{{ $rs->id }}">Email subject / heading <span class="text-muted font-weight-normal">(optional)</span></label>
                    <input type="text" name="reply_subject" id="reply_subject{{ $rs->id }}" class="form-control mb-3" maxlength="255" value="{{ old('reply_subject', $rs->reply_subject) }}" placeholder="Shown as email subject and main heading; leave blank for default">
                    <label for="admin_reply{{ $rs->id }}">Your reply</label>
                    <textarea name="admin_reply" id="admin_reply{{ $rs->id }}" class="form-control" rows="6" required maxlength="5000">{{ old('admin_reply', $rs->admin_reply) }}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save reply</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
    function searchTable() {
        var input = document.getElementById('searchInput');
        var filter = input.value.toUpperCase();
        var table = document.getElementsByClassName('table')[0];
        var tr = table.getElementsByTagName('tr');

        for (var i = 1; i < tr.length; i++) {
            var row = tr[i];
            if (row.getElementsByTagName('th').length) continue;
            var tds = row.getElementsByTagName('td');
            if (!tds.length) continue;
            var blob = '';
            for (var j = 0; j < tds.length - 1; j++) {
                blob += (tds[j].textContent || tds[j].innerText) + ' ';
            }
            if (blob.toUpperCase().indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
</script>

@include('admin.includes.footer')

@endsection
