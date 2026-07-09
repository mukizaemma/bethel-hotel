    <div class="rts__section facilities__area has__background has__shape py-90">
        <div class="section__shape">
            <img src="assets/images/shape/facility-1.svg" alt="">
        </div>
        <div class="container">
            <div class="row justify-content-center text-center mb-40">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                    <div class="section__topbar">
                        <h2 class="section__title">Our Services</h2>
                    </div>
                </div>
            </div>

            <div class="row g-4 wow fadeInUp" data-wow-delay=".5s">
                @if(isset($services) && $services->count() > 0)
                    @foreach($services as $service)
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card rts__card no-border is__home radius-6" style="height: 100%;">
                            <div class="card-body">
                                @if($service->cover_image)
                                <div class="service__image mb-3" style="height: 150px; overflow: hidden; border-radius: 8px;">
                                    <img src="{{ asset('storage/' . $service->cover_image) }}" 
                                         alt="{{ $service->title }}" 
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                @endif
                                <h6 class="card-title h6 mb-15">{{ $service->title }}</h6>
                                <p class="card-text">{{ Str::words($service->description ?? '', 20, '...') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Fallback static content if no services -->
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card rts__card no-border is__home radius-6">
                            <div class="card-body">
                                <div class="icon"><img src="assets/images/icon/bed.svg" alt=""></div>
                                <h6 class="card-title h6 mb-15">Rooms and Suites</h6>
                                <p class="card-text">Varied types of rooms, from standard to luxury suites, equipped with essentials like beds.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card rts__card no-border is__home radius-6">
                            <div class="card-body">
                                <div class="icon"><img src="assets/images/icon/security.svg" alt=""></div>
                                <h6 class="card-title h6 mb-15">24-Hour Security</h6>
                                <p class="card-text">On-site security personnel and best surveillance. Secure storage for valuables.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card rts__card no-border is__home radius-6">
                            <div class="card-body">
                                <div class="icon"><img src="assets/images/icon/gym.svg" alt=""></div>
                                <h6 class="card-title h6 mb-15">Fitness Center</h6>
                                <p class="card-text">Equipped with exercise machines and weights. Offering massages, facials, and other treatments.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card rts__card no-border is__home radius-6">
                            <div class="card-body">
                                <div class="icon"><img src="assets/images/icon/swimming-pool.svg" alt=""></div>
                                <h6 class="card-title h6 mb-15">Swimming Pool</h6>
                                <p class="card-text">Indoor or outdoor pools for leisure or exercise. Offering massages, facials, and other treatments</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>