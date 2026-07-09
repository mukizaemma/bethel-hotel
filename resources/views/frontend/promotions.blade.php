<div class="public-livewire-page">

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => 'Our Current Promotions',
    'defaultDescription' => 'Special offers and packages',
])
<section class="room padding-top padding-bottom">
    <div class="container">
      <div class="room__wrapper">
        <div class="row g-4">
          @foreach($promotions as $promotion)
          <div class="col-xl-6 col-md-6">
            <div class="room__item room__item--style3 bg--section-color">
              <div class="room__item-inner">
                <div class="room__item-thumb">
                  <img src="{{ asset('storage/images/promotions/' .$promotion->image) }}" 
                       alt="Special Promotion" 
                       style="height:400px; object-fit:contain; cursor:pointer;" 
                       class="img-modal-trigger"
                       data-img="{{ asset('storage/images/promotions/' .$promotion->image) }}">
                </div>
                <div class="room__item-content" style="text-align:center">
                  <h3><a href="{{ $setting?->linktree ?? '' }}" target="_blank">{{$promotion->title}}</a></h3>
                  <div class="room__item-body" style="padding-top:10px">
                    <a href="{{ $setting?->linktree ?? '' }}" target="_blank" class="custom-btn custom-btn--bordered"><span>Booking Now</span></a>
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

  <!-- Image Modal -->
<div id="imgModal" style="display:none; position:fixed; z-index:1050; left:0; top:0; width:100%; height:100%; overflow:auto; background-color: rgba(0,0,0,0.8);">
  <span id="closeModal" style="position:absolute; top:20px; right:35px; color:white; font-size:40px; font-weight:bold; cursor:pointer;">&times;</span>
  <div style="display:flex; justify-content:center; align-items:center; height:100%;">
    <img id="modalImage" src="" style="max-width:90%; max-height:90%; border-radius:10px;">
  </div>
</div>


@endsection

<script>
  // Trigger modal
  document.querySelectorAll('.img-modal-trigger').forEach(img => {
    img.addEventListener('click', function () {
      const modal = document.getElementById('imgModal');
      const modalImg = document.getElementById('modalImage');
      modalImg.src = this.dataset.img;
      modal.style.display = "block";
    });
  });

  // Close modal
  document.getElementById('closeModal').addEventListener('click', function () {
    document.getElementById('imgModal').style.display = "none";
  });

  // Optional: Close when clicking outside image
  document.getElementById('imgModal').addEventListener('click', function (e) {
    if (e.target === this) this.style.display = "none";
  });
</script>

@include('frontend.includes.page-booking-cta')
</div>
