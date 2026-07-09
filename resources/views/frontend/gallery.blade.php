<div class="public-livewire-page">
<style>
    .gallery__link:hover img { opacity: 0.9; }
    .gallery__link:focus { outline: 2px solid rgba(0, 72, 255, 0.5); outline-offset: 2px; }
</style>
@php
    $heroImage = '';
    $heroCaption = 'Gallery';
    $heroDescription = 'A glimpse of comfortable rooms, meeting spaces, and life at Bethel Hotel in Rubengera';

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
    $galleryImageList = $galleryImages;
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
            <div class="row g-4" id="galleryImagesRow">
                @forelse ($galleryImages as $index => $image)
                    <div class="col-lg-4 col-md-6" wire:key="gallery-img-{{ $image['id'] }}">
                        <div class="gallery__item h-100">
                            <a href="{{ $image['url'] }}" class="gallery__link d-block rounded-2 overflow-hidden gallery-image-trigger" data-index="{{ $index }}" role="button" style="cursor: pointer;" title="View full size">
                                <img class="img-fluid w-100" src="{{ $image['url'] }}" alt="Gallery image" loading="lazy" decoding="async" style="height: 260px; object-fit: cover; transition: opacity 0.2s;">
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted mb-0">No images in the gallery yet. Add room, facility, or gallery photos from the admin.</p>
                    </div>
                @endforelse
            </div>

            @if($galleryHasMore)
                <div class="text-center mt-4 pt-2">
                    <button type="button" class="btn btn-outline-primary" wire:click="loadMoreGalleryImages" wire:loading.attr="disabled" wire:target="loadMoreGalleryImages">
                        <span wire:loading.remove wire:target="loadMoreGalleryImages">Load more images</span>
                        <span wire:loading wire:target="loadMoreGalleryImages">Loading…</span>
                    </button>
                </div>
                <div id="gallery-infinite-sentinel" class="py-1" wire:ignore.self aria-hidden="true"></div>
            @endif
        </div>
    </div>

    <div id="gallery-images-payload" class="d-none" aria-hidden="true">@json($galleryImageList)</div>

    <div class="modal fade" id="imageLightboxModal" tabindex="-1" aria-labelledby="imageLightboxLabel" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 shadow-lg rounded-3 overflow-hidden">
                <div class="modal-header border-0 py-2 px-3 bg-dark text-white d-flex justify-content-between align-items-center flex-nowrap">
                    <button type="button" class="btn btn-link text-white text-decoration-none p-2 gallery-lightbox-prev" aria-label="Previous image"><i class="fas fa-chevron-left fa-2x"></i></button>
                    <h5 class="modal-title mb-0 mx-2 text-nowrap" id="imageLightboxLabel">Image</h5>
                    <div class="d-flex align-items-center flex-nowrap">
                        <span class="gallery-lightbox-counter me-3 small"></span>
                        <button type="button" class="btn btn-link text-white text-decoration-none p-2 gallery-lightbox-close" aria-label="Close"><i class="fas fa-times fa-2x"></i></button>
                    </div>
                    <button type="button" class="btn btn-link text-white text-decoration-none p-2 gallery-lightbox-next" aria-label="Next image"><i class="fas fa-chevron-right fa-2x"></i></button>
                </div>
                <div class="modal-body p-0 bg-dark text-center position-relative">
                    <img class="gallery-lightbox-image img-fluid" src="" alt="" style="max-height: 80vh; width: auto; display: block; margin: 0 auto;">
                    <p class="gallery-lightbox-caption text-white small p-2 mb-0"></p>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.includes.page-booking-cta', ['headingId' => 'gallery-booking-cta'])

    <script>
    (function() {
        function getGalleryImages() {
            var el = document.getElementById('gallery-images-payload');
            if (!el) return [];
            try { return JSON.parse(el.textContent || '[]'); } catch (e) { return []; }
        }

        var currentImageIndex = 0;
        var imageModalEl = document.getElementById('imageLightboxModal');
        var imageModal = imageModalEl ? new bootstrap.Modal(imageModalEl) : null;

        function updateMainImage() {
            var galleryImages = getGalleryImages();
            var item = galleryImages[currentImageIndex];
            if (!item) return;
            var imgEl = document.querySelector('.gallery-lightbox-image');
            var capEl = document.querySelector('.gallery-lightbox-caption');
            var counterEl = document.querySelector('.gallery-lightbox-counter');
            if (imgEl) {
                imgEl.src = item.url;
                imgEl.alt = 'Gallery image';
            }
            if (capEl) capEl.textContent = '';
            if (counterEl) counterEl.textContent = (currentImageIndex + 1) + ' / ' + galleryImages.length;
        }

        function openImageLightbox(index) {
            var galleryImages = getGalleryImages();
            if (!galleryImages.length || !imageModal) return;
            currentImageIndex = (index + galleryImages.length) % galleryImages.length;
            updateMainImage();
            imageModal.show();
        }

        function showPrevImage() {
            var galleryImages = getGalleryImages();
            if (!galleryImages.length) return;
            currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            updateMainImage();
        }

        function showNextImage() {
            var galleryImages = getGalleryImages();
            if (!galleryImages.length) return;
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            updateMainImage();
        }

        document.addEventListener('click', function(e) {
            var trigger = e.target.closest('.gallery-image-trigger');
            if (!trigger) return;
            e.preventDefault();
            var index = parseInt(trigger.getAttribute('data-index'), 10);
            if (!isNaN(index)) openImageLightbox(index);
        }, true);

        var prevBtn = document.querySelector('.gallery-lightbox-prev');
        var nextBtn = document.querySelector('.gallery-lightbox-next');
        var closeBtn = document.querySelector('.gallery-lightbox-close');
        if (prevBtn) prevBtn.addEventListener('click', function(e) { e.preventDefault(); showPrevImage(); });
        if (nextBtn) nextBtn.addEventListener('click', function(e) { e.preventDefault(); showNextImage(); });
        if (closeBtn) closeBtn.addEventListener('click', function() { if (imageModal) imageModal.hide(); });

        if (imageModalEl) {
            imageModalEl.addEventListener('shown.bs.modal', function() {
                document.addEventListener('keydown', galleryKeydown);
            });
            imageModalEl.addEventListener('hidden.bs.modal', function() {
                document.removeEventListener('keydown', galleryKeydown);
            });
        }

        function galleryKeydown(e) {
            if (e.key === 'ArrowLeft') { e.preventDefault(); showPrevImage(); }
            if (e.key === 'ArrowRight') { e.preventDefault(); showNextImage(); }
        }

        var galleryScrollObserver = null;
        var morphDebounce = null;
        function setupGalleryInfiniteScroll() {
            var sentinel = document.getElementById('gallery-infinite-sentinel');
            if (!sentinel || !window.Livewire) return;
            var root = sentinel.closest('[wire\\:id]');
            if (!root) return;
            var wireId = root.getAttribute('wire:id');
            if (!wireId) return;
            if (galleryScrollObserver) {
                galleryScrollObserver.disconnect();
                galleryScrollObserver = null;
            }
            galleryScrollObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (!entry.isIntersecting) return;
                    var wire = window.Livewire.find(wireId);
                    if (wire && typeof wire.call === 'function') {
                        wire.call('loadMoreGalleryImages');
                    }
                });
            }, { rootMargin: '400px', threshold: 0 });
            galleryScrollObserver.observe(sentinel);
        }
        function registerMorphHook() {
            if (typeof Livewire === 'undefined' || typeof Livewire.hook !== 'function') return;
            Livewire.hook('morph.updated', function() {
                clearTimeout(morphDebounce);
                morphDebounce = setTimeout(setupGalleryInfiniteScroll, 120);
            });
        }
        if (typeof Livewire !== 'undefined' && Livewire.hook) {
            registerMorphHook();
        } else {
            document.addEventListener('livewire:init', registerMorphHook);
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupGalleryInfiniteScroll);
        } else {
            setupGalleryInfiniteScroll();
        }
    })();
    </script>
</div>
