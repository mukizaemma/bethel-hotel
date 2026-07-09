    <!-- ===============  header area start =============== -->
   @php
       $data = App\Models\Setting::first();
   @endphp
    <header>
        <div class="header-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-2 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="logo d-flex justify-content-between align-items-left h-100">
                            <a href="{{route('home')}}"><img src="{{ asset('storage/images') . $data?->logo }}" alt="logo" width="120px"></a>

                            <div class="mobile-menu d-flex ">
                                <ul class="d-flex mobil-nav-icons align-items-center">
                                    <li class="search-icon global-top" ><a href="javascript:void(0)"><i class="flaticon-search-1"></i></a></li>
                                    <li><a href="dashboard.html"><i class="flaticon-user"></i></a></li>
                                    <li class="category-icon"><a href="javascript:void(0)"><i class="flaticon-menu"></i></a></li>
                                    <li class="cart-icon"><a href="javascript:void(0)"><i class="flaticon-shopping-cart"></i></a>
                                        <div class="has-count">12</div>
                                    </li>
                                </ul>
                                <a href="javascript:void(0)" class="hamburger d-block d-xl-none">
                                    <span class="h-top"></span>
                                    <span class="h-middle"></span>
                                    <span class="h-bottom"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-10 col-lg-10 col-md-8 col-sm-6 col-xs-6">

                        <nav class="main-nav">
                            <div class="inner-logo d-xl-none">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('storage/images') . $data?->logo }}" alt="" width="120px">
                                </a>
                            </div>
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>
                                {{-- <li><a href="">About Us</a></li> --}}
                                @foreach($menuData as $mainMenu)
                                <li class="has-child-menu">
                                    <a href="{{ route('getProductsByGender',['genderSlug'=>$mainMenu->slug]) }}">{{ $mainMenu->name }}</a>
                                    <i class="fl flaticon-plus">+</i>

                                    <ul class="sub-menu">
                                        @foreach($mainMenu->categories as $categ)
                                        <li><a href="{{ route('getProductsByCategory',['categorySlug'=>$categ->slug]) }}">{{ $categ->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                        
                                @endforeach
                                <li><a href="{{ route('getMenProducts') }}">Brands</a></li>
                                <li><a href="#">Updates</a></li>
                                <li><a href="#">Contact Us</a></li>
                            </ul>

                        </nav>
                    </div>

                    <div class="col-lg-2 d-none d-xl-block ">
                        <div class="nav-right h-100 d-flex align-items-center justify-content-end">
                            <ul class="d-flex nav-icons">
                                {{-- <li class="search-icon"><a href="javascript:void(0)"><i class="flaticon-search-1"></i></a></li>
                                <li><a href="{{ route('login') }}"><i class="flaticon-user"></i></a></li>
                                <li class="category-icon"><a href="javascript:void(0)"><i class="flaticon-menu"></i></a></li> --}}
                                <li class="cart-icon"><a href="javascript:void(0)"><i class="flaticon-shopping-cart"></i></a>
                                    <div class="has-count">{{ count((array) session('cart')) }}</div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <!-- ===============  header area end =============== -->
