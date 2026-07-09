<div class="public-livewire-page">

<!-- Page Header -->
@php
    $roomHeroImage = '';
    if ($room && $room->cover_image) {
        $roomHeroImage = asset('storage/' . $room->cover_image);
    } elseif ($about && $about?->image2) {
        if (strpos($about?->image2, '/') !== false || strpos($about?->image2, 'abouts') === 0) {
            $roomHeroImage = asset('storage/' . $about?->image2);
        } else {
            $roomHeroImage = asset('storage/images/about/' . $about?->image2);
        }
    } else {
        $roomHeroImage = asset('storage/images/about/default.jpg');
    }
@endphp
<div class="rts__section page__hero__height page__hero__bg" style="background-image: url({{ $roomHeroImage }}); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-12">
                <div class="page__hero__content">
                    <h1 class="wow fadeInUp">{{ $room->title }}</h1>
                    <p class="wow fadeInUp font-sm">Comfortable, affordable accommodation in Rubengera</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Room Details Area -->
<div class="rts__section section__padding">
    <div class="container">
        <div class="row g-5 sticky-wrap">
            <!-- Room Images Carousel (Right Side) -->
            <div class="col-lg-7 order-2 order-lg-1 room-gallery-col">
                <div class="room__details">
                    @php
                        // Combine cover image with gallery images
                        $allImages = collect();
                        if ($room->cover_image) {
                            $allImages->push((object)['image' => $room->cover_image, 'is_cover' => true]);
                        }
                        if ($images && count($images) > 0) {
                            foreach ($images as $img) {
                                $allImages->push((object)['image' => $img->image, 'is_cover' => false]);
                            }
                        }
                    @endphp
                    @if($allImages->count() > 0)
                        <div class="image-gallery-wrapper mb-4">
                            <!-- Main Image Display -->
                            <div class="gallery-main-image">
                                <img id="roomMainImage" 
                                     src="{{ asset('storage/' . $allImages->first()->image) }}" 
                                     alt="{{ $room->title }} - Main Image"
                                     loading="eager"
                                     class="gallery-main-img">
                            </div>
                            
                            <!-- Thumbnail Gallery -->
                            @if($allImages->count() > 1)
                                <div class="gallery-thumbnails">
                                    @foreach($allImages as $key => $img)
                                        <div class="thumbnail-item {{ $key === 0 ? 'active' : '' }}" 
                                             data-image="{{ asset('storage/' . $img->image) }}"
                                             data-index="{{ $key }}">
                                            <img src="{{ asset('storage/' . $img->image) }}" 
                                                 alt="{{ $room->title }} - Thumbnail {{ $key + 1 }}"
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
                                 src="{{ asset('storage/' . ($room->cover_image ?? 'rooms/default.jpg')) }}" 
                                 alt="Main Room Image"
                                 loading="eager"
                                 style="width: 100%; height: 550px; object-fit: cover;">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Room Details (Left Side) -->
            <div class="col-lg-5 order-1 order-lg-2 room-details-col">
                <div class="room__details">
                    <div class="d-flex justify-content-between align-items-center mb-30">
                        <h2 class="room__title">{{ $room->title }}</h2>
                        <div class="text-end">
                            <span class="h4 price" style="color: #0048ff; font-weight: 600;">
                                {{ hotel_price($room->price ?? 0, $setting) }}<span class="h6 fw-normal">/night</span>
                            </span>
                            <p class="mb-0 small text-muted" style="max-width: 280px; margin-left: auto;">
                                Base rate covers up to <strong>{{ (int) ($room->guests_included_in_price ?? 2) }}</strong> guest(s).
                                @if($room->max_occupancy)
                                    Max {{ $room->max_occupancy }} guest(s).
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($room->extra_adult_price || $room->extra_child_price || $room->extra_bed_price)
                    <div class="mb-20 p-3" style="background: #eef6ff; border-radius: 8px; border: 1px solid #cfe2ff;">
                        <strong class="d-block mb-2" style="color: #0048ff;">Additional rates (per night)</strong>
                        <ul class="mb-0 ps-3 small">
                            @if($room->extra_adult_price)
                                <li>Extra adult (beyond included guests): <strong>{{ hotel_price($room->extra_adult_price, $setting) }}</strong></li>
                            @endif
                            @if($room->extra_child_price)
                                <li>Extra child (beyond included guests): <strong>{{ hotel_price($room->extra_child_price, $setting) }}</strong></li>
                            @endif
                            @if($room->extra_bed_price)
                                <li>Extra bed: <strong>{{ hotel_price($room->extra_bed_price, $setting) }}</strong></li>
                            @endif
                        </ul>
                    </div>
                    @endif

                    <!-- Room Info -->
                    <div class="mb-30" style="display: flex; gap: 30px; padding: 20px; background: #f9f9f9; border-radius: 8px;">
                        @if($room->max_occupancy)
                        <div>
                            <i class="fas fa-users" style="color: #0048ff; font-size: 20px;"></i>
                            <p class="mb-0 mt-2"><strong>Max Guests:</strong> {{ $room->max_occupancy }}</p>
                        </div>
                        @endif
                        @if($room->bed_count)
                        <div>
                            <i class="fas fa-bed" style="color: #0048ff; font-size: 20px;"></i>
                            <p class="mb-0 mt-2"><strong>Beds:</strong> {{ $room->bed_count }} {{ $room->bed_type ?? '' }}</p>
                        </div>
                        @endif
                        @if($room->room_number)
                        <div>
                            <i class="fas fa-door-open" style="color: #0048ff; font-size: 20px;"></i>
                            <p class="mb-0 mt-2"><strong>Room #:</strong> {{ $room->room_number }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Amenities + description moved below (below gallery, full width). -->
                </div>
            </div>
        </div>

        <!-- Room Description (full width, below gallery) -->
        <div class="row mt-30">
            <div class="col-12">
                <div class="mb-30">
                    <h4 class="mb-20">Description</h4>
                    <div style="line-height: 1.8; color: #666;">
                        {!! $room->description !!}
                    </div>
                </div>
            </div>
        </div>

        @php
            $hasAmenities = isset($amenities) && $amenities && $amenities->count() > 0;
        @endphp

        <!-- Amenities + Booking Form (same row) -->
        <div class="row mt-50 g-4" id="booking">
            @if($hasAmenities)
                <div class="col-lg-5">
                    <div class="mb-30">
                        <h4 class="mb-20">Room Amenities</h4>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                            @foreach($amenities as $amenity)
                                <div style="display: flex; align-items: center; padding: 8px; background: #f9f9f9; border-radius: 5px;">
                                    <span style="margin-right: 8px; color: #0048ff;">✓</span>
                                    {{ $amenity->title }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
            @else
                <div class="col-12">
            @endif
                <div class="rts__booking__form has__background" style="padding: 40px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); height: 100%;">
                    <div class="d-flex align-items-baseline justify-content-center gap-2 mb-30 flex-wrap text-center">
                        <h3 class="mb-0">‘<span style="color: #0048ff;">{{ $room->title }}</span>’</h3>
                        <span class="h5 mb-0" style="color: #0048ff; font-weight: 700;">
                            from {{ hotel_price($room->price ?? 0, $setting) }}/night
                        </span>
                    </div>
                    <p class="text-muted text-center small mb-4">
                        Book this room type on <strong>Booking.com</strong>. For questions about this room, use WhatsApp or email.
                    </p>
                    @include('frontend.includes.hotel-booking-channels', ['contextLabel' => ' Room: '.$room->title])
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Room Details End -->

<!-- Similar Rooms -->
@if($allRooms && $allRooms->count() > 0)
<div class="rts__section" style="padding: 80px 0; background-color: #f9f9f9;">
    <div class="container">
        <div class="row justify-content-center text-center mb-40">
            <div class="col-lg-6">
                <div class="section__topbar">
                    <h2>Other Rooms</h2>
                </div>
            </div>
        </div>
        <div class="row g-30">
            @foreach ($allRooms as $similarRoom)
            <div class="col-lg-4 col-md-6">
                <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1); transition: transform 0.3s;">
                    <div>
                        <a wire:navigate href="{{ route('room',['slug'=>$similarRoom->slug]) }}">
                            <img src="{{ $similarRoom->publicThumbnailUrl() }}"
                                 alt="{{ $similarRoom->title }}"
                                 style="width: 100%; height: 250px; object-fit: cover;"
                                 loading="lazy">
                        </a>
                    </div>
                    <div style="padding: 20px;">
                        <a wire:navigate href="{{ route('room',['slug'=>$similarRoom->slug]) }}" 
                           style="font-size: 20px; font-weight: 600; color: #222; text-decoration: none; display: block; margin-bottom: 10px;">
                            {{ $similarRoom->title }}
                        </a>
                        <div style="font-size: 18px; font-weight: bold; color: #0048ff; margin-bottom: 15px;">
                            {{ hotel_price($similarRoom->price, $setting) }}/Night
                        </div>
                        <a wire:navigate href="{{ route('room',['slug'=>$similarRoom->slug]) }}" 
                           class="theme-btn btn-style sm-btn fill" 
                           style="width: 100%; text-align: center;">
                            <span>View Details</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
<!-- Similar Rooms End -->

<script>
// Image Gallery Functionality
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('roomMainImage');
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

@media (min-width: 992px) {
    /* Exact 60/40 split for the room gallery vs details section */
    .room-gallery-col {
        flex: 0 0 60%;
        max-width: 60%;
    }
    .room-details-col {
        flex: 0 0 40%;
        max-width: 40%;
    }
}
</style>

@include('frontend.includes.page-booking-cta')
</div>
