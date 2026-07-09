@php
    $heroSlides = ($slides ?? collect())->filter(function ($slide) {
        if (($slide->media_type ?? 'image') === 'video') {
            return filled($slide->video_url) || filled($slide->video_file);
        }

        return filled($slide->imageUrl());
    });

    if ($heroSlides->isEmpty()) {
        $heroSlides = collect([
            (object) [
                'media_type' => 'image',
                'heading' => 'Welcome to Bethel Hotel',
                'subheading' => '2-star comfort in Rubengera — ideal for workshops, meetings & stays',
                'image_url' => asset('assets/images/banner/1.webp'),
                'link' => route('connect'),
            ],
            (object) [
                'media_type' => 'image',
                'heading' => 'Host workshops & meetings',
                'subheading' => 'Flexible spaces for trainings, seminars, and group events',
                'image_url' => asset('assets/images/banner/2.webp'),
                'link' => route('meetings-events'),
            ],
            (object) [
                'media_type' => 'image',
                'heading' => 'Comfortable rooms in Western Rwanda',
                'subheading' => 'Affordable accommodation near Lake Kivu',
                'image_url' => asset('assets/images/banner/banner-3.webp'),
                'link' => route('rooms'),
            ],
        ]);
    }
@endphp

<div class="rts__section banner__area is__home__one banner__height banner__center">
    <div class="banner__slider hero-banner-swiper overflow-hidden">
        <div class="swiper-wrapper">
            @foreach ($heroSlides as $index => $slide)
            @php
                $isFallback = isset($slide->image_url);
                $imageUrl = $isFallback ? $slide->image_url : $slide->imageUrl();
                $ctaLink = filled($slide->link ?? null) ? $slide->link : route('connect');
                $ctaLabel = filled($slide->button ?? null) ? $slide->button : 'Book Now';
            @endphp
            <div class="swiper-slide">
                <div class="banner__slider__image">
                    @if(!$isFallback && ($slide->media_type ?? 'image') === 'video')
                        @if($slide->video_url)
                            @php
                                $videoId = '';
                                $videoType = '';
                                if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/', $slide->video_url, $matches)) {
                                    $videoId = $matches[1];
                                    $videoType = 'youtube';
                                } elseif (preg_match('/vimeo\.com\/(\d+)/', $slide->video_url, $matches)) {
                                    $videoId = $matches[1];
                                    $videoType = 'vimeo';
                                }
                            @endphp
                            @if($videoType === 'youtube')
                                <iframe
                                    src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}&controls=0&showinfo=0&rel=0&iv_load_policy=3"
                                    frameborder="0"
                                    allow="autoplay; encrypted-media"
                                    allowfullscreen
                                    style="width: 100%; height: 100%; position: absolute; top: 0; left: 0; object-fit: cover;">
                                </iframe>
                            @elseif($videoType === 'vimeo')
                                <iframe
                                    src="https://player.vimeo.com/video/{{ $videoId }}?autoplay=1&muted=1&loop=1&background=1"
                                    frameborder="0"
                                    allow="autoplay; fullscreen; picture-in-picture"
                                    allowfullscreen
                                    style="width: 100%; height: 100%; position: absolute; top: 0; left: 0; object-fit: cover;">
                                </iframe>
                            @else
                                <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;">
                                    <source src="{{ $slide->video_url }}" type="video/mp4">
                                </video>
                            @endif
                        @elseif($slide->video_file)
                            <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;">
                                <source src="{{ asset('storage/' . ltrim($slide->video_file, '/')) }}" type="video/mp4">
                            </video>
                        @endif
                    @else
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $slide->heading ?? 'Bethel Hotel' }}"
                            loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                            decoding="async"
                            @if($index === 0) fetchpriority="high" @endif
                        >
                    @endif
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="banner__slide__content">
                                @if(filled($slide->heading ?? null))
                                    <h1>{{ $slide->heading }}</h1>
                                @endif
                                @if(filled($slide->subheading ?? null))
                                    <p class="sub__text">{{ $slide->subheading }}</p>
                                @endif
                                <a wire:navigate href="{{ $ctaLink }}" class="theme-btn btn-style fill no-border">
                                    <span>{{ $ctaLabel }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="hero-swiper-pagination swiper-pagination"></div>

        <div class="rts__slider__nav">
            <div class="rts__slide">
                <button type="button" class="next hero-swiper-next" aria-label="Next slide">
                    <svg width="40" height="22" viewBox="0 0 40 22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M1.255 9.75546H39.0404C39.7331 9.75546 40.2927 10.3151 40.2927 11.0078C40.2927 11.7005 39.7331 12.2601 39.0404 12.2601H4.28018L11.8803 19.8603C12.3695 20.3495 12.3695 21.1439 11.8803 21.6331C11.3911 22.1223 10.5967 22.1223 10.1075 21.6331L0.366619 11.8923C0.00657272 11.5322 -0.0990982 10.9961 0.0965805 10.5264C0.292259 10.0607 0.750149 9.75546 1.255 9.75546Z" fill="#F1F1F1" />
                        <path d="M11.0077 0.00274277C11.3286 0.00274277 11.6495 0.124063 11.8921 0.370618C12.3813 0.859813 12.3813 1.65426 11.8921 2.14346L2.13955 11.896C1.65036 12.3852 0.855906 12.3852 0.366712 11.896C-0.122483 11.4068 -0.122483 10.6124 0.366712 10.1232L10.1193 0.370618C10.3658 0.124063 10.6868 0.00274277 11.0077 0.00274277Z" fill="#F1F1F1" />
                    </svg>
                </button>
            </div>
            <div class="rts__slide">
                <button type="button" class="prev hero-swiper-prev" aria-label="Previous slide">
                    <svg width="40" height="22" viewBox="0 0 40 22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M39.0377 12.2445L1.25234 12.2445C0.559636 12.2445 -2.04305e-06 11.6849 -1.92194e-06 10.9922C-1.80082e-06 10.2995 0.559637 9.73987 1.25234 9.73987L36.0125 9.73987L28.4124 2.13974C27.9232 1.65055 27.9232 0.856096 28.4124 0.366901C28.9016 -0.122294 29.6961 -0.122293 30.1853 0.366901L39.9261 10.1077C40.2861 10.4678 40.3918 11.004 40.1961 11.4736C40.0005 11.9393 39.5426 12.2445 39.0377 12.2445Z" fill="#F1F1F1" />
                        <path d="M29.2852 21.9973C28.9643 21.9973 28.6433 21.8759 28.4007 21.6294C27.9115 21.1402 27.9115 20.3457 28.4007 19.8565L38.1533 10.104C38.6425 9.61476 39.4369 9.61476 39.9261 10.104C40.4153 10.5932 40.4153 11.3876 39.9261 11.8768L30.1736 21.6294C29.927 21.8759 29.6061 21.9973 29.2852 21.9973Z" fill="#F1F1F1" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
