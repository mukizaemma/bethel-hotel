<div class="public-livewire-page">

<!-- Terms & Conditions Hero Section -->
@php
    $heroImage = '';
    $heroCaption = 'Terms & Conditions';
    $heroDescription = 'Please read our terms and conditions carefully';
    
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
<div class="rts__section page__hero__height page__hero__bg" style="background-image: url({{ $heroImage }}); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 250px; display: flex; align-items: center; position: relative;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(3, 86, 183, 0.3) 0%, rgba(2, 61, 122, 0.342) 100%); z-index: 1;"></div>
    <div class="container" style="position: relative; z-index: 2;">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="page__hero__content">
                    <h1 class="wow fadeInUp" style="color: white; font-size: clamp(2.5rem, 5vw, 3.5rem); margin-bottom: 15px; font-family: 'Gilda Display', serif;">{{ $heroCaption }}</h1>
                    <p class="wow fadeInUp font-sm" style="color: rgba(255,255,255,0.9); font-size: 1.1rem;">{{ $heroDescription }}</p>
                </div>
            </div>
      </div>
    </div>
</div>

<!-- Terms & Conditions Content Section -->
<div class="rts__section section__padding" style="background: #ffffff; padding-top: 80px; padding-bottom: 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div style="background: white; border-radius: 20px; padding: 60px 50px; box-shadow: 0 10px 40px rgba(0,0,0,0.08), 0 2px 10px rgba(0,0,0,0.05); position: relative; overflow: hidden;">
                    <!-- Decorative Accent Line -->
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, #0048ff 0%, #0036c9 50%, #0048ff 100%);"></div>
                    
                    <!-- Content -->
                    <div class="terms-content" style="max-width: 100%;">
                        @if($terms && $terms->content)
                            <div class="terms-content-inner" style="font-size: 1.05rem; line-height: 1.9; color: #4a5568;">
                                {!! terms_content_html($terms->content) !!}
                            </div>
                        @elseif($about && $about?->storyDescription)
                            <div style="font-size: 1.05rem; line-height: 1.9; color: #4a5568;">
                                {!! $about?->storyDescription !!}
                            </div>
                        @else
                            <div style="text-align: center; padding: 40px 20px;">
                                <div style="width: 80px; height: 80px; background: #f0f4f8; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="#0048ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14 2V8H20" stroke="#0048ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16 13H8" stroke="#0048ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16 17H8" stroke="#0048ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10 9H9H8" stroke="#0048ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h3 style="font-size: 1.5rem; margin-bottom: 15px; color: #1a1a1a; font-family: 'Gilda Display', serif;">Terms & Conditions</h3>
                                <p style="color: #666; line-height: 1.8;">
                                    Terms and conditions content will be displayed here once it's been added by the administrator.
                                </p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Decorative Corner Elements -->
                    <div style="position: absolute; top: 20px; right: 20px; width: 100px; height: 100px; border-top: 2px solid rgba(3, 86, 183, 0.1); border-right: 2px solid rgba(3, 86, 183, 0.1); border-radius: 0 20px 0 0;"></div>
                    <div style="position: absolute; bottom: 20px; left: 20px; width: 100px; height: 100px; border-bottom: 2px solid rgba(3, 86, 183, 0.1); border-left: 2px solid rgba(3, 86, 183, 0.1); border-radius: 0 0 0 20px;"></div>
                </div>
              </div>
            </div>
    </div>
          </div>

<!-- Contact Information Section -->
<div class="rts__section section__padding" style="background: #f9f9f9; padding-top: 60px; padding-bottom: 60px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h3 style="font-size: 1.8rem; margin-bottom: 20px; color: #1a1a1a; font-family: 'Gilda Display', serif;">Questions About Our Terms?</h3>
                <p style="font-size: 1.05rem; line-height: 1.8; color: #666; margin-bottom: 30px;">
                    If you have any questions regarding our terms and conditions, please don't hesitate to contact us.
                </p>
                <div class="row g-4 justify-content-center">
                    @if($setting && $setting?->phone)
                    <div class="col-md-4">
                        <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.08);">
                            <div style="width: 50px; height: 50px; background: #0048ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                <i class="fa fa-phone" style="color: white; font-size: 20px;"></i>
                            </div>
                            <h6 style="font-weight: 600; margin-bottom: 8px; color: #1a1a1a;">Phone</h6>
                            <p style="color: #666; margin: 0; font-size: 0.95rem;">{{ $setting?->phone }}</p>
                        </div>
                    </div>
                    @endif
                    @if($setting && $setting?->email)
                    <div class="col-md-4">
                        <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.08);">
                            <div style="width: 50px; height: 50px; background: #0048ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                <i class="fa fa-envelope" style="color: white; font-size: 20px;"></i>
                            </div>
                            <h6 style="font-weight: 600; margin-bottom: 8px; color: #1a1a1a;">Email</h6>
                            <p style="color: #666; margin: 0; font-size: 0.95rem;">{{ $setting?->email }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-4">
                        <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.08);">
                            <div style="width: 50px; height: 50px; background: #0048ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                <i class="fa fa-map-marker-alt" style="color: white; font-size: 20px;"></i>
                    </div>
                            <h6 style="font-weight: 600; margin-bottom: 8px; color: #1a1a1a;">Address</h6>
                            <p style="color: #666; margin: 0; font-size: 0.95rem;">{{ $setting?->address ?? 'Visit our contact page for details' }}</p>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 40px;">
                    <a wire:navigate href="{{ route('contact') }}" class="theme-btn btn-style fill" style="display: inline-block; padding: 15px 40px; font-size: 16px; font-weight: 600;">
                        <span>Contact Us</span>
                    </a>
        </div>
        </div>
      </div>
    </div>
</div>

<style>
/* Terms Content Styling */
.terms-content h1,
.terms-content h2,
.terms-content h3,
.terms-content h4,
.terms-content h5,
.terms-content h6 {
    font-family: 'Gilda Display', serif;
    color: #1a1a1a;
    margin-top: 30px;
    margin-bottom: 15px;
    font-weight: 600;
}

.terms-content h1 { font-size: 2rem; }
.terms-content h2 { font-size: 1.75rem; }
.terms-content h3 { font-size: 1.5rem; }
.terms-content h4 { font-size: 1.25rem; }

.terms-content p {
    margin-bottom: 20px;
    line-height: 1.9;
    color: #4a5568;
}

.terms-content ul,
.terms-content ol {
    margin-bottom: 20px;
    padding-left: 30px;
    color: #4a5568;
}

.terms-content li {
    margin-bottom: 10px;
    line-height: 1.8;
}

.terms-content strong {
    color: #0048ff;
    font-weight: 600;
}

.terms-content a {
    color: #0048ff;
    text-decoration: underline;
    transition: color 0.3s ease;
}

.terms-content a:hover {
    color: #0036c9;
}

.terms-content blockquote {
    border-left: 4px solid #0048ff;
    padding-left: 20px;
    margin: 20px 0;
    font-style: italic;
    color: #666;
}

/* Responsive Design */
@media (max-width: 768px) {
    .terms-content {
        padding: 40px 30px !important;
    }
    
    .terms-content h1 { font-size: 1.75rem; }
    .terms-content h2 { font-size: 1.5rem; }
    .terms-content h3 { font-size: 1.25rem; }
}
</style>

@include('frontend.includes.page-booking-cta')
</div>
