<div class="public-livewire-page">

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => 'Our Tours',
    'defaultDescription' => 'Explore with us',
])

<section class="room padding-top padding-bottom">
    <div class="container">
      <div class="room__wrapper">
        <div class="row g-4">

          @foreach($tours as $tour)
          <div class="col-xl-4 col-md-6">
            <div class="room__item room__item--style3 bg--section-color h-100" style="text-align:center">
              <div class="room__item-inner">
                <div class="room__item-thumb">
                 <a wire:navigate href="{{ route('tour',['slug'=>$tour->slug])}}"><img src="{{ asset('storage/images/trips/' .$tour->image) }}" alt="1 Day Golden trekking"></a>
                </div>
                <div class="room__item-content">
                      <h3><a wire:navigate href="{{ route('tour',['slug'=>$tour->slug])}}">{{$tour->title}}</a></h3>
                  <div class="room__item-body" style="padding-top:10px">
                    <a wire:navigate href="{{ route('tour',['slug'=>$tour->slug])}}" class="custom-btn custom-btn--bordered"><span>More Details</span></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          


        </div>
      </div>
    </div>
  </section>

@include('frontend.includes.page-booking-cta')
</div>
