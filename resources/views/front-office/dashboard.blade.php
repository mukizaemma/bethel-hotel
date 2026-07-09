<div class="admin-livewire-page d-flex w-100 align-items-stretch">
<!-- Sidebar Start -->
@include('front-office.includes.sidebar')
<!-- Sidebar End -->

<!-- Content Start -->
<div class="content">
    <!-- Navbar Start -->
    @include('admin.includes.navbar')
    <!-- Navbar End -->

    <div class="container-fluid pt-4 px-4">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(auth()->user()->isSuperAdmin())
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong><i class="fa fa-crown me-2"></i>Super Admin Mode:</strong> You have full access to all CRUD operations in this dashboard.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-bed fa-3x text-success"></i>
                    <div class="ms-3">
                        <p class="mb-2">Available Rooms</p>
                        <h6 class="mb-0">{{ $stats['available_rooms'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-bed fa-3x text-danger"></i>
                    <div class="ms-3">
                        <p class="mb-2">Occupied Rooms</p>
                        <h6 class="mb-0">{{ $stats['occupied_rooms'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-bed fa-3x text-warning"></i>
                    <div class="ms-3">
                        <p class="mb-2">Reserved Rooms</p>
                        <h6 class="mb-0">{{ $stats['reserved_rooms'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-users fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">In-House Guests</p>
                        <h6 class="mb-0">{{ $stats['inhouse_guests'] }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h4 class="mb-4">Quick Actions</h4>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('front-office.rooms') }}" class="btn btn-primary w-100">
                                <i class="fa fa-bed me-2"></i>Rooms Display
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('front-office.reservations.calendar') }}" class="btn btn-info w-100">
                                <i class="fa fa-calendar me-2"></i>Reservations Calendar
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('front-office.inhouse') }}" class="btn btn-success w-100">
                                <i class="fa fa-users me-2"></i>In-House List
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('front-office.reservations') }}" class="btn btn-warning w-100">
                                <i class="fa fa-list me-2"></i>View Reservations
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content End -->
</div>
