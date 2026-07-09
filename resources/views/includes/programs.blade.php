<div class="container-xxl py-5">
    <div class="container">
        <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <h1 class="display-5 mb-3">Available Programs</h1>
            <p></p>
        </div>
        <div class="row g-4">
            @foreach ($programs as $program )
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <img class="img-fluid" src="{{ asset('storage/images/programs/' .$program->image) }}" alt="" style="height:300px; object-fit:contain">
                <div class="bg-light p-4">
                    <a class="d-block h5 lh-base mb-4" href="{{ route('categoryPrograms',['slug'=>$program->slug]) }}">{{ $program->title }}</a>
                    <div class="text-muted border-top pt-4">
                        <p>{!! $program->description !!}</p>
                    </div>
                    <a class="btn btn-lg btn-secondary rounded-pill py-3 px-5" href="{{ route('categoryPrograms',['slug'=>$program->slug]) }}">View Details</a>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>