<div class="public-livewire-page">


    <div class="rts__section section__padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="blog__details">
                        <div class="blog__details__content">
                            <img class="rounded-3 my-4 img-fluid" width="870" height="500" src="{{ asset('storage/images/blogs/'.$blog->image) }}" alt="">

                            <p class="description">
                                {!! $blog->body !!}
                            </p>

                            {{-- <h6 class="mb-30">Comment</h6> --}}
                            {{-- <div class="comment__list">

                                <div class="comment__item">
                                    <div class="comment__item__author">
                                        <div class="author__img">
                                            <img class="rounded-1" src="assets/images/author/3.webp" width="60" height="60" alt="">
                                        </div>
                                        <div class="author__info">
                                            <h6 class="font-20 mb-0">Jonathon Doe</h6>
                                            <span>A week ago</span>
                                        </div>
                                    </div>
                                    <div class="comment__text">
                                        <p class="font-sm">I still have a lot of studying to do using this course and
                                            the other practice exams, but so far it's been great! I have not taken my
                                            Security+ exam as well, so I'll update this at a later time.</p>
                                        <a href="#"><img src="assets/images/icon/reply.svg" alt="">Reply</a>
                                    </div>
                                </div>
                                <div class="comment__item">
                                    <div class="comment__item__author">
                                        <div class="author__img">
                                            <img class="rounded-1" src="assets/images/author/4.webp" width="60" height="60" alt="">
                                        </div>
                                        <div class="author__info">
                                            <h6 class="font-20 mb-0">Michael Roy </h6>
                                            <span>A week ago</span>
                                        </div>
                                    </div>
                                    <div class="comment__text">
                                        <p class="font-sm">I still have a lot of studying to do using this course and
                                            the other practice exams, but so far it's been great! I have not taken my
                                            Security+ exam as well, so I'll update this at a later time.</p>
                                        <a href="#"><img src="assets/images/icon/reply.svg" alt="">Reply</a>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- comment form -->
                            {{-- <div class="comment__form mt-40">
                                <h6 class="mb-3">Leave a Comment</h6>
                                <form action="#" class="comment__form__content">
                                    <div class="input-group">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" name="name" class="form-control" placeholder="Your Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Your Email</label>
                                            <input type="email" id="email" name="email" class="form-control" placeholder="Your Email" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="msg">Your Comment</label>
                                        <textarea id="msg" name="msg" class="form-control" placeholder="Your message" required></textarea>
                                    </div>
                                    <button type="submit" class="theme-btn btn-style fill mt-4"><span>Submit
                                            Comment</span></button>
                                </form>
                            </div> --}}
                            <!-- comment form end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('frontend.includes.page-booking-cta')
</div>
