<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('front-office.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <h4 class="mb-4">Sales Report</h4>
            
            <form method="GET" action="{{ route('front-office.reports.sales') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5>Total Sales</h5>
                            <h3>{{ number_format($totalSales, 2) }} RWF</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5>Total Paid</h5>
                            <h3>{{ number_format($totalPaid, 2) }} RWF</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5>Total Balance</h5>
                            <h3>{{ number_format($totalBalance, 2) }} RWF</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Guest Name</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Room</th>
                            <th>Total Amount</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->names }}</td>
                            <td>{{ $booking->checkin_date->format('Y-m-d') }}</td>
                            <td>{{ $booking->checkout_date->format('Y-m-d') }}</td>
                            <td>{{ $booking->assignedRoom->room_number ?? $booking->room->title ?? 'N/A' }}</td>
                            <td>{{ number_format($booking->total_amount, 2) }} RWF</td>
                            <td>{{ number_format($booking->paid_amount, 2) }} RWF</td>
                            <td>{{ number_format($booking->balance_amount, 2) }} RWF</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
