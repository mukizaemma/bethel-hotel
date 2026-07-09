<div class="public-livewire-page">

<!-- Updates/Blogs Hero Section -->
@php
    $heroImage = '';
    $heroCaption = 'Latest Updates';
    $heroDescription = 'Stay updated with our latest news, events, and stories';
    
    if ($pageHero && !empty($pageHero->background_image)) {
        $heroImage = asset('storage/' . $pageHero->background_image);
        $heroCaption = $pageHero->caption ?? $heroCaption;
        $heroDescription = $pageHero->description ?? $heroDescription;
    } elseif ($about && $about?->image2) {
        if (strpos($about?->image2, '/') !== false || strpos($about?->image2, 'abouts') === 0) {
            $heroImage = asset('storage/' . $about?->image2);
        } else {
            $heroImage = asset('storage/images/about/' . $about?->image2);
        }
    } else {
        $heroImage = asset('storage/images/about/default.jpg');
    }
@endphp
<div class="rts__section page__hero__height page__hero__bg" style="background-image: url({{ $heroImage }}); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-12">
                <div class="page__hero__content">
                    <h1 class="wow fadeInUp">{{ $heroCaption }}</h1>
                    <p class="wow fadeInUp font-sm">{{ $heroDescription }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="rts__section section__padding">
        <div class="container">
            <div class="row g-30 sticky-wrap">
                <div class="col-lg-7 col-xl-8">
                    <div class="blog__list__item ">
                        <!-- single blog item -->
                        @foreach ($blogs as $blog)
                        <div class="single__blog">
                            <div class="single__blog__thumb">
                                <a href="blog-details.html">
                                    <img src="{{ asset('storage/images/blogs/'.$blog->image) }}" height="490" width="760" alt="">
                                </a>
                            </div>
                            <div class="single__blog__meta">
                                {{-- <a href="#" class="category">{{ $blog->title }}</a> --}}
                                <a href="" class="h5">{{ $blog->title }}</a>
                                <p>In today's ever-evolving business landscape, staying ahead of the curve is essential for success. Whether you're a seasoned entrepreneur or just starting out, the key to thriving in this dynamic environment lies in adaptability and innovation.</p>
                                <div class="single__blog__meta__main">
                                    <div class="author__meta">
                                        <a href="#"><img src="{{ asset('storage/images') . $setting?->logo }}" height="40" width="40" alt="">ST Paul</a>
                                        <span><img src="assets/images/icon/clock.svg" alt=""> 2 Min Read</span>
                                    </div>
                                    <div class="readmore">
                                        <a wire:navigate href="{{ route('update',['slug'=>$blog->slug]) }}">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- single blog item end -->
   

                        {{-- <div class="load__more__link">
                            <a href="#">Load More</a>
                        </div> --}}
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 sticky-item">
                    <div class="blog__sidebar__section  ">
                        <h6 class="mb-4">Our Rooms</h6>
                        <div class="latest__post mb-30">

                            @foreach ($rooms as $room)
                                <div class="single__post">
                                <div class="single__post__thumb">
                                    <a wire:navigate href="{{ route('room',['slug'=>$room->slug]) }}">
                                        <img src="{{ $room->publicThumbnailUrl() }}" height="106" width="110" alt="{{ $room->title }}">
                                    </a>
                                </div>
                                <div class="single__post__meta">
                                    <a wire:navigate href="{{ route('room',['slug'=>$room->slug]) }}" class="font-sm">{{ $room->title }}</a>
                                    <span>{{ hotel_price($room->price ?? 0, $setting) }}<span class="text-lowercase">/night</span></span>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('frontend.includes.page-booking-cta')
</div>
