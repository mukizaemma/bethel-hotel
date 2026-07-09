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


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
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
                
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-1">Visits today</p>
                                <h6 class="mb-0">{{ number_format($todayVisits ?? 0) }}</h6>
                                <small class="text-muted">Unique: {{ number_format($todayUniqueVisitors ?? 0) }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-1">Visits this week</p>
                                <h6 class="mb-0">{{ number_format($weekVisits ?? 0) }}</h6>
                                <small class="text-muted">Month: {{ number_format($monthVisits ?? 0) }}</small>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fas fa-thumbs-up fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Product Reviews</p>
                                <h6 class="mb-0">{{ $productCommetsCount }}</h6>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fas fa-eye fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-1">All-time visits</p>
                                <h6 class="mb-0">{{ number_format($totalVisits ?? 0) }}</h6>
                                @php $gaReportsUrl = $data->ga4_reports_url ?? null; @endphp
                                @if(filled($gaReportsUrl))
                                    <small><a href="{{ $gaReportsUrl }}" class="text-decoration-underline" target="_blank" rel="noopener noreferrer">Open GA4 reports</a></small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-bed fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Rooms</p>
                                <h6 class="mb-0">{{ $rooms }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->

            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-xl-8">
                        <div class="bg-light rounded p-4 h-100">
                            <h6 class="mb-3">Most visited pages (last 30 days)</h6>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Page</th>
                                            <th class="text-end">Visits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse(($topVisitedPages ?? []) as $page)
                                            <tr>
                                                <td><code>{{ $page->path }}</code></td>
                                                <td class="text-end">{{ number_format($page->visits) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-muted">No visit data yet. Browse the public website to generate stats.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="bg-light rounded p-4 h-100">
                            <h6 class="mb-3">Top visitor countries (header-based)</h6>
                            <ul class="list-group list-group-flush">
                                @forelse(($topVisitorCountries ?? []) as $country)
                                    <li class="list-group-item bg-light d-flex justify-content-between px-0">
                                        <span>{{ $country->country_code }}</span>
                                        <strong>{{ number_format($country->visits) }}</strong>
                                    </li>
                                @empty
                                    <li class="list-group-item bg-light text-muted px-0">
                                        Country data not available yet. Use GA4 for accurate geo insights.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Chart Start -->
     


            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Room & Facility Bookings</h6>
                        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search here" class="form-control" style="width: 200px;">
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">Date</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Names</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Check-in</th>
                                    <th scope="col">Check-out</th>
                                    <th scope="col">Adults</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $rs)
                                <tr>
                                    <td>{{ $rs->created_at ? $rs->created_at->format('Y-m-d H:i') : '' }}</td>
                                    <td><span class="badge {{ ($rs->reservation_type ?? 'room') === 'facility' ? 'bg-info' : (($rs->reservation_type ?? '') === 'tour_activity' ? 'bg-success' : 'bg-primary') }}">{{ ($rs->reservation_type ?? 'room') === 'tour_activity' ? 'Tour Activity' : ucfirst(str_replace('_', ' ', $rs->reservation_type ?? 'room')) }}</span></td>
                                    <td>{{ $rs->names ?? '' }}</td>
                                    <td>{{ $rs->email ?? '' }}</td>
                                    <td>{{ $rs->checkin_date ? $rs->checkin_date->format('Y-m-d') : ($rs->checkin ?? '') }}</td>
                                    <td>{{ $rs->checkout_date ? $rs->checkout_date->format('Y-m-d') : ($rs->checkout ?? '') }}</td>
                                    <td>{{ $rs->adults ?? '' }}</td>
                                    <td>{!! Str::words($rs->message ?? '', 15, '...') !!}</td>
                                    <td><span class="badge bg-{{ $rs->status === 'confirmed' ? 'success' : ($rs->status === 'cancelled' ? 'danger' : 'warning') }}">{{ ucfirst($rs->status ?? 'pending') }}</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#replyBookingModal" onclick="setReplyBookingId({{ $rs->id }})">Reply</button>
                                            <a href="{{ route('destroyBooking', $rs->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure to delete this booking?')">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Reply to Booking Modal -->
            <div class="modal fade" id="replyBookingModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reply to Reservation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form id="replyBookingForm" method="POST" action="">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control" required>
                                        <option value="confirmed">Confirm</option>
                                        <option value="cancelled">Reject</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Message to guest <span class="text-danger">*</span></label>
                                    <textarea name="admin_reply" class="form-control" rows="4" required placeholder="This message will be sent to the guest's email."></textarea>
                                    <small class="text-muted">The guest will be notified at their reservation email.</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Send reply</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
            function setReplyBookingId(id) {
                var base = '{{ route("replyBooking", ["id" => "__ID__"]) }}';
                document.getElementById('replyBookingForm').action = base.replace('__ID__', id);
            }
            </script>

            <script>
                function searchTable() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("searchInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementsByClassName("table")[0];
                    tr = table.getElementsByTagName("tr");
            
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[2]; // Change index to match the column you want to search
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            </script>
            
            <!-- Recent Sales End -->



            <!-- Footer Start -->
            @include('admin.includes.footer')
            <!-- Footer End -->
        </div>
        <!-- Content End -->



 @endsection