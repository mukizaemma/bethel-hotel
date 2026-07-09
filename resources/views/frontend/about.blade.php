<div class="public-livewire-page">

<!-- About Us Hero Section -->
@php
    $heroImage = '';
    $heroCaption = 'About Us';
    $heroDescription = 'Discover our story, values, and commitment to excellence';
    
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
<div class="rts__section page__hero__height page__hero__bg" style="background-image: url({{ $heroImage }}); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 300px; display: flex; align-items: center; position: relative;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(3, 86, 183, 0.3) 0%, rgba(2, 61, 122, 0.342) 100%); z-index: 1;"></div>
        <div class="container" style="position: relative; z-index: 2;">
            <div class="row align-items-center justify-content-center">
            <div class="col-lg-12 text-center">
                    <div class="page__hero__content">
                    <h1 class="wow fadeInUp" style="color: white; font-size: clamp(2.5rem, 5vw, 4rem); margin-bottom: 15px;">{{ $heroCaption }}</h1>
                    <p class="wow fadeInUp font-sm" style="color: rgba(255,255,255,0.9); font-size: 1.1rem;">{{ $heroDescription }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Us Main Section -->
<div class="rts__section section__padding" style="background: #ffffff;">
        <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 wow fadeInLeft">
                <div class="about__images" style="position: relative;">
                    @php
                        $aboutImage1 = '';
                        if ($about && $about?->image1) {
                            // New format from ContentManagementController: 'abouts/filename.jpg'
                            if (strpos($about?->image1, '/') !== false || strpos($about?->image1, 'abouts') === 0) {
                                $aboutImage1 = asset('storage/' . $about?->image1);
                            } 
                            // Old format from SettingsController: just 'filename.jpg'
                            else {
                                $aboutImage1 = asset('storage/images/about/' . $about?->image1);
                            }
                        } else {
                            $aboutImage1 = asset('storage/images/about/default.jpg');
                        }
                    @endphp
                    <div class="image__left" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                        <img src="{{ $aboutImage1 }}" alt="About Us" style="width: 100%; height: auto; display: block;" loading="eager">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight">
                    <div class="about__content">
                    <h2 class="font-xl" style="font-size: clamp(2rem, 4vw, 2.5rem); margin-bottom: 25px; color: #1a1a1a; font-family: 'Gilda Display', serif;">
                        Welcome To {{ $setting?->company ?? 'Our Hotel' }}
                    </h2>
                    <div class="font-sm mt-30" style="font-size: 1.05rem; line-height: 1.9; color: #4a5568;">
                        {!! $about?->founderDescription ?? 'Bethel Hotel is a 2-star hotel in Rubengera, Karongi — perfectly suited for workshops, seminars, and comfortable stays in Western Rwanda.' !!}
                    </div>
                    @if($about?->mission || $about?->vision)
                    <div class="row g-4 mt-40">
                        @if($about?->mission)
                        <div class="col-md-6">
                            <div style="background: #f8f9fa; padding: 25px; border-radius: 10px; border-left: 4px solid #228b22;">
                                <h5 style="color: #228b22; margin-bottom: 15px; font-weight: 600;">Our Mission</h5>
                                <p style="color: #666; margin: 0; line-height: 1.7;">{!! Str::words($about?->mission, 25, '...') !!}</p>
                            </div>
                        </div>
                        @endif
                        @if($about?->vision)
                        <div class="col-md-6">
                            <div style="background: #f8f9fa; padding: 25px; border-radius: 10px; border-left: 4px solid #0048ff;">
                                <h5 style="color: #0048ff; margin-bottom: 15px; font-weight: 600;">Our Vision</h5>
                                <p style="color: #666; margin: 0; line-height: 1.7;">{!! Str::words($about?->vision, 25, '...') !!}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Team Section -->
<div class="rts__section section__padding" style="background: #ffffff;">
    <div class="container">
        <div class="row position-relative justify-content-center text-center mb-60">
            <div class="col-lg-6 wow fadeInUp">
                <div class="section__topbar">
                    <h2 class="section__title">Our Team</h2>
                    <p class="font-sm">Meet the dedicated professionals who make your stay memorable</p>
                </div>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-12 text-center">
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); padding: 60px 40px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08);">
                    <div style="max-width: 700px; margin: 0 auto;">
                        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #0048ff 0%, #228b22 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; box-shadow: 0 8px 20px rgba(0, 72, 255, 0.25);">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M20.59 22C20.59 18.13 16.74 15 12 15C7.26 15 3.41 18.13 3.41 22" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3 style="font-size: 1.8rem; margin-bottom: 15px; color: #1a1a1a; font-family: 'Gilda Display', serif;">Our Dedicated Team</h3>
                        <p style="font-size: 1.05rem; line-height: 1.8; color: #666; margin-bottom: 0;">
                            Our team of experienced hospitality professionals is committed to providing you with exceptional service and creating unforgettable experiences during your stay. From our front desk staff to our housekeeping team, every member is dedicated to ensuring your comfort and satisfaction.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map + booking (same layout as home) -->
<x-booking-cta
    :rooms="$allRooms"
    :show-children-field="true"
    eyebrow="Visit & stay"
    title="Find us & book your stay"
    lead="Visit us in person or reserve your room — we’ll confirm your request shortly."
    heading-id="about-booking-cta"
    id-suffix="-about"
/>
</div>
