{{-- Swiper main + thumbs; expects $galleryImages (collection), $storageSubfolder (restaurant|events), $galleryKey (unique) --}}
@php
    $galleryImages = $galleryImages ?? collect();
    $storageSubfolder = $storageSubfolder ?? 'restaurant';
    $galleryKey = $galleryKey ?? 'gallery';
@endphp

@if($galleryImages->isNotEmpty())
    <div class="page-gallery-root mb-4 mb-lg-5" data-gallery-id="{{ $galleryKey }}">
        <div class="swiper page-gallery-main page-gallery-main--{{ $galleryKey }}">
            <div class="swiper-wrapper">
                @foreach($galleryImages as $img)
                    <div class="swiper-slide">
                        <figure class="page-gallery-figure mb-0">
                            <img
                                src="{{ asset('storage/images/' . $storageSubfolder . '/' . $img->image) }}"
                                alt="{{ $img->caption ?: '' }}"
                                loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                width="1200"
                                height="675"
                            >
                            @if(filled($img->caption))
                                <figcaption class="page-gallery-figcaption">{{ $img->caption }}</figcaption>
                            @endif
                        </figure>
                    </div>
                @endforeach
            </div>
        </div>

        @if($galleryImages->count() > 1)
            <div class="swiper page-gallery-thumbs page-gallery-thumbs--{{ $galleryKey }} mt-3">
                <div class="swiper-wrapper">
                    @foreach($galleryImages as $img)
                        <div class="swiper-slide">
                            <img
                                src="{{ asset('storage/images/' . $storageSubfolder . '/' . $img->image) }}"
                                alt=""
                                loading="lazy"
                                width="200"
                                height="120"
                            >
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="page-gallery-toolbar d-flex align-items-center justify-content-between gap-3 mt-3 flex-wrap">
                <div class="page-gallery-nav d-flex align-items-center gap-2">
                    <button type="button" class="page-gallery-btn page-gallery-prev--{{ $galleryKey }}" aria-label="Previous image">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button type="button" class="page-gallery-btn page-gallery-next--{{ $galleryKey }}" aria-label="Next image">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
                <div class="page-gallery-pagination page-gallery-pagination--{{ $galleryKey }}"></div>
            </div>
        @endif
    </div>
@else
    <div class="page-gallery-root page-gallery-root--empty mb-4 mb-lg-5 rounded-4 d-flex align-items-center justify-content-center">
        <p class="text-muted mb-0 small">Gallery images can be added in the admin (e.g. Dining page or each meeting room).</p>
    </div>
@endif
