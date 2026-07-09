<div class="public-livewire-page">

<!-- Page Header -->
@php
    $heroImage2 = '';
    if ($about && $about?->image2) {
        if (strpos($about?->image2, '/') !== false || strpos($about?->image2, 'abouts') === 0) {
            $heroImage2 = asset('storage/' . $about?->image2);
        } else {
            $heroImage2 = asset('storage/images/about/' . $about?->image2);
        }
    } else {
        $heroImage2 = asset('storage/images/about/default.jpg');
    }
@endphp
<div class="rts__section page__hero__height page__hero__bg" style="background-image: url({{ $heroImage2 }}); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-12">
                <div class="page__hero__content">
                    <h1 class="wow fadeInUp">Review Details</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Review Detail Section -->
<div class="rts__section section__padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="review__detail" style="background: white; padding: 40px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
                        <div>
                            <h3 style="margin-bottom: 10px;">{{ $review->names }}</h3>
                            <div style="display: flex; gap: 5px; margin-bottom: 10px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 20px;"></i>
                                @endfor
                                <span class="ms-2" style="color: #666;">({{ $review->rating }}/5)</span>
                            </div>
                            @if($review->website)
                            <a href="{{ $review->website }}" target="_blank" class="font-sm" style="color: #0048ff;">
                                <i class="fas fa-globe me-1"></i>{{ $review->website }}
                            </a>
                            @endif
                        </div>
                        <span class="font-sm" style="color: #999;">{{ $review->created_at->format('F d, Y') }}</span>
                    </div>
                    <div style="color: #666; line-height: 1.8; font-size: 16px;">
                        {!! nl2br(e($review->testimony)) !!}
                    </div>
                    <div class="mt-40 text-center">
                        <a wire:navigate href="{{ route('reviews') }}" class="theme-btn btn-style border">
                            <span>Back to All Reviews</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other Reviews -->
        @if($reviews->count() > 0)
        <div class="row mt-60">
            <div class="col-12">
                <h3 class="text-center mb-40">Other Reviews</h3>
            </div>
            @foreach($reviews as $otherReview)
            <div class="col-lg-6 mb-30">
                <div style="background: #f9f9f9; padding: 25px; border-radius: 10px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <h5>{{ $otherReview->names }}</h5>
                        <div style="display: flex; gap: 3px;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $otherReview->rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <p style="color: #666; margin-bottom: 15px;">
                        {{ Str::words($otherReview->testimony, 30, '...') }}
                    </p>
                    <a wire:navigate href="{{ route('review', ['id' => $otherReview->id]) }}" class="theme-btn btn-style sm-btn border">
                        <span>Read More</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
<!-- Review Detail End -->

@include('frontend.includes.page-booking-cta')
</div>
