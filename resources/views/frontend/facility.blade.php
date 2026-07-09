<div class="public-livewire-page">


@php
    $facilityHeroImage = '';
    if ($facility && $facility->cover_image) {
        $facilityHeroImage = asset('storage/' . $facility->cover_image);
    } elseif ($about && $about?->image2) {
        if (strpos($about?->image2, '/') !== false || strpos($about?->image2, 'abouts') === 0) {
            $facilityHeroImage = asset('storage/' . $about?->image2);
        } else {
            $facilityHeroImage = asset('storage/images/about/' . $about?->image2);
        }
    } else {
        $facilityHeroImage = asset('storage/images/about/default.jpg');
    }
@endphp
    <div class="rts__section page__hero__height page__hero__bg" style="background-image: url({{ $facilityHeroImage }}); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-12">
                    <div class="page__hero__content">
                        <h1 class="wow fadeInUp">{{ $facility->title ?? '' }}</h1>
                        <p class="wow fadeInUp font-sm">
                            @if(!empty($facility->description))
                                {{ \Illuminate\Support\Str::words(strip_tags($facility->description), 22, '...') }}
                            @else
                                A step up from the standard room, often with better views, more space, and additional amenities.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- page header end -->

    <!-- room details area -->
    <div class="rts__section section__padding">
        <div class="container">
            <div class="row g-5 sticky-wrap">
                <!-- Left column: gallery + title + description -->
                <div class="col-lg-7">
                    <div class="room__details">

                        <div class="room__feature mb-10">
                        @php
                            // Combine cover image with gallery images
                            $allFacilityImages = collect();
                            if ($facility->cover_image) {
                                $allFacilityImages->push((object)['image' => $facility->cover_image, 'is_cover' => true]);
                            }
                            if ($images && count($images) > 0) {
                                foreach ($images as $img) {
                                    $allFacilityImages->push((object)['image' => $img->image, 'is_cover' => false]);
                                }
                            }
                        @endphp
                        @if($allFacilityImages->count() > 0)
                            <div class="image-gallery-wrapper mb-4">
                                <!-- Main Image Display -->
                                <div class="gallery-main-image">
                                    <img id="facilityMainImage" 
                                         src="{{ asset('storage/' . $allFacilityImages->first()->image) }}" 
                                         alt="{{ $facility->title }} - Main Image"
                                         loading="eager"
                                         class="gallery-main-img">
                                </div>
                                
                                <!-- Thumbnail Gallery -->
                                @if($allFacilityImages->count() > 1)
                                    <div class="gallery-thumbnails">
                                        @foreach($allFacilityImages as $key => $img)
                                            <div class="thumbnail-item {{ $key === 0 ? 'active' : '' }}" 
                                                 data-image="{{ asset('storage/' . $img->image) }}"
                                                 data-index="{{ $key }}">
                                                <img src="{{ asset('storage/' . $img->image) }}" 
                                                     alt="{{ $facility->title }} - Thumbnail {{ $key + 1 }}"
                                                     loading="lazy"
                                                     class="thumbnail-img">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="room__feature__image mb-10" style="border-radius: 10px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.15);">
                                <img class="rounded-2" 
                                     src="{{ asset('storage/' . ($facility->cover_image ?? 'facilities/default.jpg')) }}" 
                                     alt="Main Facility Image" 
                                     loading="eager"
                                     style="width: 100%; height: 550px; object-fit: cover;">
                            </div>
                        @endif


                            <div class="d-flex justify-content-between align-items-center">
                              <h2 class="room__title">{{ $facility->title }}</h2>
                            </div>
                        </div>
                        <p>{!! $facility->description !!}</p>
                        <div class="room__image__group row row-cols-md-2 row-cols-sm-1 mt-30 mb-50 gap-4 gap-md-0">
                        </div>

                    </div>
                </div>

                <!-- Right column: booking form -->
                <div class="col-lg-5" id="booking">
                    <div class="rts__booking__form has__background" style="padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <h3 class="mb-20 text-center">Book or enquire</h3>
                        <p class="text-muted small text-center mb-4">
                            Overnight stays: use <strong>Booking.com</strong>. For this facility or event space, message us on WhatsApp or email.
                        </p>
                        @include('frontend.includes.hotel-booking-channels', ['contextLabel' => ' Facility: '.$facility->title])
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- room details area end -->

     <!-- similar room area -->
<!-- similar room area -->
<div class="rts__section" style="padding-bottom: 120px; background-color: #f9f9f9;">
    <div class="container" style="margin-bottom: 40px;">
        <div class="row justify-content-center text-center" style="margin-bottom: 40px;">
            <div class="col-lg-6">
                <div class="section__topbar">
                    <h2 style="font-size: 28px; font-weight: bold;">Other Facilities</h2>
                </div>
            </div>
        </div>
        <div class="row" style="gap: 20px; justify-content: center;">
            @foreach ($allFacilities as $facility )
            <div class="col-lg-4 col-md-6" style="flex: 0 0 auto;">
                <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.05); transition: all 0.3s ease;">
                    <div>
                        <a wire:navigate href="{{ route('facility',['slug'=>$facility->slug]) }}">
                            <img src="{{ asset('storage/' . ($facility->cover_image ?? 'facilities/default.jpg')) }}" alt="{{ $facility->title }}" loading="lazy" style="width: 100%; height: 210px; object-fit: cover;">
                        </a>
                    </div>
                    <div style="padding: 15px;">
                        <a wire:navigate href="{{ route('facility',['slug'=>$facility->slug]) }}" style="font-size: 20px; font-weight: 600; color: #222; text-decoration: none;">{{ $facility->title }}</a>
                        <p class="font-sm">{!! Str::words($facility->description, 20, '...') !!}</p>
                        <a wire:navigate href="{{ route('facility',['slug'=>$facility->slug]) }}" style="display: inline-block; margin-top: 10px; font-size: 14px; color: #0048ff; text-decoration: underline;">Discover More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

    <!-- similar room area end -->

<script>
// Image Gallery Functionality for Facility
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('facilityMainImage');
    const thumbnails = document.querySelectorAll('.gallery-thumbnails .thumbnail-item');
    
    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                const newImageSrc = this.getAttribute('data-image');
                
                // Remove active class from all thumbnails
                thumbnails.forEach(thumb => thumb.classList.remove('active'));
                
                // Add active class to clicked thumbnail
                this.classList.add('active');
                
                // Fade out main image
                mainImage.style.opacity = '0';
                
                // After fade out, change image and fade in
                setTimeout(() => {
                    mainImage.src = newImageSrc;
                    mainImage.style.opacity = '1';
                }, 200);
            });
        });
    }
});
</script>

<style>
/* Image Gallery Styles */
.image-gallery-wrapper {
    width: 100%;
}

.gallery-main-image {
    width: 100%;
    margin-bottom: 15px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    background: #f8f9fa;
    position: relative;
    aspect-ratio: 16/10;
}

.gallery-main-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: opacity 0.4s ease-in-out;
    opacity: 1;
}

.gallery-thumbnails {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    padding: 5px 0;
    scrollbar-width: thin;
    scrollbar-color: rgba(0, 0, 0, 0.3) transparent;
}

.gallery-thumbnails::-webkit-scrollbar {
    height: 6px;
}

.gallery-thumbnails::-webkit-scrollbar-track {
    background: transparent;
}

.gallery-thumbnails::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.3);
    border-radius: 3px;
}

.thumbnail-item {
    flex: 0 0 auto;
    width: 100px;
    height: 100px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.3s ease;
    position: relative;
    background: #f8f9fa;
}

.thumbnail-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.thumbnail-item.active {
    border-color: #0048ff;
    box-shadow: 0 0 0 2px rgba(3, 86, 183, 0.2), 0 4px 12px rgba(3, 86, 183, 0.3);
}

.thumbnail-item.active::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(3, 86, 183, 0.1);
    pointer-events: none;
}

.thumbnail-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.thumbnail-item:hover .thumbnail-img {
    transform: scale(1.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .gallery-main-image {
        aspect-ratio: 4/3;
    }
    
    .thumbnail-item {
        width: 80px;
        height: 80px;
    }
    
    .gallery-thumbnails {
        gap: 8px;
    }
}

@media (max-width: 576px) {
    .thumbnail-item {
        width: 70px;
        height: 70px;
    }
}
</style>

@include('frontend.includes.page-booking-cta')
</div>
