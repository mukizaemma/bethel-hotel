<div class="admin-livewire-page d-flex w-100 align-items-stretch">
<!-- Sidebar Start -->
@include('content-management.includes.sidebar')
<!-- Sidebar End -->

<!-- Content Start -->
<div class="content">
    <!-- Navbar Start -->
    @include('admin.includes.navbar')
    <!-- Navbar End -->

    <!-- Sale & Revenue Start -->
    <div class="container-fluid pt-4 px-4">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(auth()->user()->isSuperAdmin())
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong><i class="fa fa-crown me-2"></i>Super Admin Mode:</strong> You are currently working in Website Content Management.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @elseif(auth()->user()->isContentManager())
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong><i class="fa fa-user-cog me-2"></i>Content Manager Dashboard:</strong> You have access to manage website content including services, rooms, facilities, gallery, and page settings.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-bed fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Rooms</p>
                        <h6 class="mb-0">{{ $stats['rooms'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-concierge-bell fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Services</p>
                        <h6 class="mb-0">{{ $stats['services'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-building fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Facilities</p>
                        <h6 class="mb-0">{{ $stats['facilities'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-users fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Users</p>
                        <h6 class="mb-0">{{ $stats['users'] }}</h6>
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
                            <a href="{{ route('content-management.rooms') }}" class="btn btn-primary w-100">
                                <i class="fa fa-bed me-2"></i>Manage Rooms
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('content-management.services') }}" class="btn btn-success w-100">
                                <i class="fa fa-concierge-bell me-2"></i>Manage Services
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('content-management.facilities') }}" class="btn btn-info w-100">
                                <i class="fa fa-building me-2"></i>Manage Facilities
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('content-management.amenities') }}" class="btn btn-warning w-100">
                                <i class="fa fa-list me-2"></i>Manage Amenities
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sale & Revenue End -->
</div>
<!-- Content End -->
</div>
