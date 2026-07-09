<div class="public-livewire-page">


<section class="page-header bg--cover" style="background-image: url(images/slider-1.jpg)">
    <div class="container">
      <div class="page-header__content text-center">
        <h2>{{ $room->title ?? '' }}</h2>

      </div>
    </div>
  </section>

  <section class="room padding-top padding-bottom">
    <div class="container">
      <div class="room__wrapper">
        <div class="row g-5">
          <div class="col-lg-8">
            <div class="room__details">
              <div class="room__details-image">
                  <div class="wrapper-full">
                    <div class="widget-carousel">
                      <div id="wrapper">
                        <div class="callbacks_container">
                          <ul class="rslides" id="slider1">            
                            <li><img src="{{ asset('storage/images/rooms/' .$room->image) }}" alt="{{$room->caption}}"  style="height:550px"></li>
                            @foreach($images as $image)
                                <li><img src="{{ asset('storage/images/rooms/' .$image->image) }}" alt="{{$image->caption}}" style="height:550px"></li>
                            @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>                
                  </div>
              </div>
              <div class="room__details-content">
                <h3>{{$room->title}}</h3>
                {{-- <span style="font-size: 16px; font-weight: bold; color: #007bff; margin-bottom: 10px;">$120/night</span> --}}
                <div class="room__details-text">
                  {{-- <h4>Description</h4> --}}
                  <p>
                    {!! $room->description !!}
                  </p>
                </div>
                <div class="room__amenities" style="margin-top:45px">
                  <div class="room__amenities-content room__amenities-content1"  style="width: 100%">
                    <ul class="room__amenities-list">
                        @foreach ($amenities as $amenity)
                        <li class="room__amenities-item"><span><i class="fa-regular fa-circle-check"></i></span>{{ $amenity->title }}</li>
                        @endforeach
                      </ul>
                    </div>
                  
                  {{-- <div class="room__amenities-content room__amenities-content1">
                    <ul class="room__amenities-list">
                      <li class="room__amenities-item"><span><i class="fa-regular fa-circle-check"></i></span> Desk</li>
                      <li class="room__amenities-item"><span><i class="fa-regular fa-circle-check"></i></span> Dining table</li>
                      <li class="room__amenities-item"><span><i class="fa-regular fa-circle-check"></i></span> Towels</li>
                      <li class="room__amenities-item"><span><i class="fa-regular fa-circle-check"></i></span> Hand sanitiser</li>
                    </ul>
                    </div>
                    <div class="room__amenities-content room__amenities-content1">
                    <ul class="room__amenities-list">
                      <li class="room__amenities-item"><span><i class="fa-regular fa-circle-check"></i></span> Mosquito net</li>
                      <li class="room__amenities-item"><span><i class="fa-regular fa-circle-check"></i></span> Bed linen</li>
                      <li class="room__amenities-item"><span><i class="fa-regular fa-circle-check"></i></span> Resting area</li>
                      <li class="room__amenities-item"><span><i class="fa-regular fa-circle-check"></i></span> Clothes rack</li>
                    </ul>
                    </div> --}}
                </div>

                <div class="room__details-text">
                  <p>
                    Book your stay now for a peaceful retreat amidst nature!
                  </p>
                  <a href="{{ $setting?->linktree ?? '' }}" target="_blank" class="custom-btn"><span>check availability</span></a>
                </div>
              </div>
            </div>
            
          </div>

          <div class="col-lg-4 col-md-8" style="padding: 20px; background-color: #f9f9f9; border-radius: 8px;">
            <h2 style="font-size: 24px; color: #333; margin-bottom: 20px;">Other Rooms</h2>
            <ul style="list-style-type: none; padding: 0;">
                @foreach ($allRooms as $rs )
                <li style="display: flex; align-items: center; margin-bottom: 15px; background-color: #fff; padding: 10px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <!-- Image on the left -->
                    <div style="flex-shrink: 0; margin-right: 15px;">
                        <a wire:navigate href="{{ route('room',['slug'=>$rs->slug]) }}">
                            <img src="{{ asset('storage/images/rooms/' .$rs->image) }}" alt="Single Room with Balcony" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </a>
                    </div>
                    <!-- Title and Price on the right -->
                    <div style="flex-grow: 1; display: flex; justify-content: space-between; align-items: left;">
                        <div>

                            <a wire:navigate href="{{ route('room',['slug'=>$rs->slug]) }}" style="font-size: 18px; color: #333; margin: 0;text-align: left;">{{ $rs->title }}</a>
                            {{-- <span style="font-size: 16px; font-weight: bold; color: #007bff;">$120/night</span> --}}
                        </div>

                    </div>
                </li>
                @endforeach

                <!-- Add more rooms here following the same structure -->
            </ul>
        </div>
        
        </div>
      </div>
    </div>
  </section>

</div>

@include('frontend.includes.page-booking-cta')
</div>
