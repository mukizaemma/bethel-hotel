<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($slides as $key => $slide)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img class="w-100" src="{{ asset('storage/images/slides/' . $slide->image) }}" alt="{{ $slide->title }}" >
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-7">
                                    <h1 class="display-2 mb-5 animated slideInDown" style="color:#fff">Welcome to Centre ST Paul</h1>
                                    <h4 class="animated fadeInUp" style="color:#fff">{{ $slide->heading }}</h4>
                                    @if ($slide->button_text && $slide->button_url)
                                        <a href="{{ $slide->button_url ?? '' }}" class="btn btn-primary rounded-pill py-sm-3 px-sm-5">
                                            {{ $slide->button_text }}
                                        </a>
                                    @endif
                                    @if ($slide->button2_text && $slide->button2_url)
                                        <a href="{{ $slide->button2_url ?? '' }}" class="btn btn-secondary rounded-pill py-sm-3 px-sm-5 ms-3">
                                            {{ $slide->button2_text }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button> --}}
    </div>
</div>