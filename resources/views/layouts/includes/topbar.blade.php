
@php
$data = App\Models\Setting::first();
@endphp
 <!-- ===============  mobil sidebar start =============== -->
    <div class="mobil-sidebar d-sm-none">
        <ul class="mobil-sidebar-icons">
            <li class="category-icon"><a href="#"><i class="flaticon-menu"></i></a></li>
            <li><a href="dashboard.html"><i class="flaticon-user"></i></a></li>
            <li><a href="#"><i class="flaticon-heart"></i></a></li>
            
            <li class="cart-icon">
                <a href="cart.html"><i class="flaticon-shopping-cart"></i></a>
                <div class="cart-count"><span>10</span></div>
            </li>
        </ul>
    </div>
    <!-- ===============  mobil sidebar end =============== -->
    
    <!-- ===============  Category sidebar start =============== -->
    <div class="category-sidebar">
        <div class="category-sidebar-wrapper ">
            <div class="category-seidebar-top">
                <h4>All category</h4>
                <div class="category-close">
                    <i class="flaticon-arrow-pointing-to-left"></i>
                </div>
            </div>
            <div class="accordion" id="categoryExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="categoryHeading1">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#categoryOne" aria-expanded="false" aria-controls="categoryOne">
                           <i class="flaticon-woman"></i> Woman Collection
                        </button>
                    </h2>
                    <div id="categoryOne" class="accordion-collapse collapse" aria-labelledby="categoryHeading1" data-bs-parent="#categoryExample" style="">
                        <div class="accordion-body">
                            <ul class="sb-category-list">
                                <li><a href="product.html">Man Casual Silk Shirt</a> <span class="product-amount">(10)</span></li>
                                <li><a href="product.html">Man Orange Shorts</a> <span class="product-amount">(22)</span></li>
                                <li><a href="product.html">Party Dress</a> <span class="product-amount">(08)</span></li>
                                <li><a href="product.html">T-Shirt</a> <span class="product-amount">(41)</span> </li>
                                <li><a href="product.html">Ghost Mannequin Black Hoodie</a> <span class="product-amount">(15)</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="categoryHeading2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#categoryTwo" aria-expanded="false" aria-controls="categoryTwo">
                            <i class="flaticon-children"></i> Kid’s Collection
                        </button>
                    </h2>
                    <div id="categoryTwo" class="accordion-collapse collapse" aria-labelledby="categoryHeading2" data-bs-parent="#categoryExample" style="">
                        <div class="accordion-body">
                            <ul class="sb-category-list">
                                <li><a href="product.html">Man Casual Silk Shirt</a> <span class="product-amount">(10)</span></li>
                                <li><a href="product.html">Man Orange Shorts</a> <span class="product-amount">(22)</span></li>
                                <li><a href="product.html">Party Dress</a> <span class="product-amount">(08)</span></li>
                                <li><a href="product.html">T-Shirt</a> <span class="product-amount">(41)</span> </li>
                                <li><a href="product.html">Ghost Mannequin Black Hoodie</a> <span class="product-amount">(15)</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="categoryHeading3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#categoryThree" aria-expanded="false" aria-controls="categoryThree">
                          <i class="flaticon-cosmetics"></i>  Health & Beauty
                        </button>
                    </h2>
                    <div id="categoryThree" class="accordion-collapse collapse" aria-labelledby="categoryHeading3" data-bs-parent="#categoryExample" style="">
                        <div class="accordion-body">
                            <ul class="sb-category-list">
                                <li><a href="product.html">Man Casual Silk Shirt</a> <span class="product-amount">(10)</span></li>
                                <li><a href="product.html">Man Orange Shorts</a> <span class="product-amount">(22)</span></li>
                                <li><a href="product.html">Party Dress</a> <span class="product-amount">(08)</span></li>
                                <li><a href="product.html">T-Shirt</a> <span class="product-amount">(41)</span> </li>
                                <li><a href="product.html">Ghost Mannequin Black Hoodie</a> <span class="product-amount">(15)</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="categoryHeading4">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#categoryFour" aria-expanded="false" aria-controls="categoryFour">
                          <i class="flaticon-man"></i>  Mens’s Collection
                        </button>
                    </h2>
                    <div id="categoryFour" class="accordion-collapse collapse" aria-labelledby="categoryHeading4" data-bs-parent="#categoryExample" style="">
                        <div class="accordion-body">
                            <ul class="sb-category-list">
                                <li><a href="product.html">Man Casual Silk Shirt</a> <span class="product-amount">(10)</span></li>
                                <li><a href="product.html">Man Orange Shorts</a> <span class="product-amount">(22)</span></li>
                                <li><a href="product.html">Party Dress</a> <span class="product-amount">(08)</span></li>
                                <li><a href="product.html">T-Shirt</a> <span class="product-amount">(41)</span> </li>
                                <li><a href="product.html">Ghost Mannequin Black Hoodie</a> <span class="product-amount">(15)</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="categoryHeading5">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#categoryFive" aria-expanded="false" aria-controls="categoryFive">
                           <i class="flaticon-necklace"></i> Women’s Jewellerty
                        </button>
                    </h2>
                    <div id="categoryFive" class="accordion-collapse collapse" aria-labelledby="categoryHeading5" data-bs-parent="#categoryExample" style="">
                        <div class="accordion-body">
                            <ul class="sb-category-list">
                                <li><a href="product.html">Man Casual Silk Shirt</a> <span class="product-amount">(10)</span></li>
                                <li><a href="product.html">Man Orange Shorts</a> <span class="product-amount">(22)</span></li>
                                <li><a href="product.html">Party Dress</a> <span class="product-amount">(08)</span></li>
                                <li><a href="product.html">T-Shirt</a> <span class="product-amount">(41)</span> </li>
                                <li><a href="product.html">Ghost Mannequin Black Hoodie</a> <span class="product-amount">(15)</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="categoryHeading6">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#categorySix" aria-expanded="false" aria-controls="categorySix">
                           <i class="flaticon-shoes"></i> Shoes Collection
                        </button>
                    </h2>
                    <div id="categorySix" class="accordion-collapse collapse" aria-labelledby="categoryHeading6" data-bs-parent="#categoryExample" style="">
                        <div class="accordion-body">
                            <ul class="sb-category-list">
                                <li><a href="product.html">Man Casual Silk Shirt</a> <span class="product-amount">(10)</span></li>
                                <li><a href="product.html">Man Orange Shorts</a> <span class="product-amount">(22)</span></li>
                                <li><a href="product.html">Party Dress</a> <span class="product-amount">(08)</span></li>
                                <li><a href="product.html">T-Shirt</a> <span class="product-amount">(41)</span> </li>
                                <li><a href="product.html">Ghost Mannequin Black Hoodie</a> <span class="product-amount">(15)</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="categoryHeading7">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#categorySeven" aria-expanded="false" aria-controls="categorySeven">
                           <i class="flaticon-watch"></i>  Men’s & Woman’s Watches
                        </button>
                    </h2>
                    <div id="categorySeven" class="accordion-collapse collapse" aria-labelledby="categoryHeading7" data-bs-parent="#categoryExample" style="">
                        <div class="accordion-body">
                            <ul class="sb-category-list">
                                <li><a href="product.html">Man Casual Silk Shirt</a> <span class="product-amount">(10)</span></li>
                                <li><a href="product.html">Man Orange Shorts</a> <span class="product-amount">(22)</span></li>
                                <li><a href="product.html">Party Dress</a> <span class="product-amount">(08)</span></li>
                                <li><a href="product.html">T-Shirt</a> <span class="product-amount">(41)</span> </li>
                                <li><a href="product.html">Ghost Mannequin Black Hoodie</a> <span class="product-amount">(15)</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="categoryHeading8">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#categoryEight" aria-expanded="false" aria-controls="categoryEight">
                           <i class="flaticon-sports"></i> Seasonal Wear 
                        </button>
                    </h2>
                    <div id="categoryEight" class="accordion-collapse collapse" aria-labelledby="categoryHeading8" data-bs-parent="#categoryExample" style="">
                        <div class="accordion-body">
                            <ul class="sb-category-list">
                                <li><a href="product.html">Man Casual Silk Shirt</a> <span class="product-amount">(10)</span></li>
                                <li><a href="product.html">Man Orange Shorts</a> <span class="product-amount">(22)</span></li>
                                <li><a href="product.html">Party Dress</a> <span class="product-amount">(08)</span></li>
                                <li><a href="product.html">T-Shirt</a> <span class="product-amount">(41)</span> </li>
                                <li><a href="product.html">Ghost Mannequin Black Hoodie</a> <span class="product-amount">(15)</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="categoryHeading9">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#categoryNine" aria-expanded="false" aria-controls="categoryNine">
                           <i class="flaticon-diamond"></i> Daimond 
                        </button>
                    </h2>
                    <div id="categoryNine" class="accordion-collapse collapse" aria-labelledby="categoryHeading9" data-bs-parent="#categoryExample" style="">
                        <div class="accordion-body">
                            <ul class="sb-category-list">
                                <li><a href="product.html">Man Casual Silk Shirt</a> <span class="product-amount">(10)</span></li>
                                <li><a href="product.html">Man Orange Shorts</a> <span class="product-amount">(22)</span></li>
                                <li><a href="product.html">Party Dress</a> <span class="product-amount">(08)</span></li>
                                <li><a href="product.html">T-Shirt</a> <span class="product-amount">(41)</span> </li>
                                <li><a href="product.html">Ghost Mannequin Black Hoodie</a> <span class="product-amount">(15)</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ===============  Category sidebar end =============== -->

    <!-- ============  main searchbar area start =========== -->
    <div class="main-searchbar">
        <div class="searchbar-wrap">
            <div class="container">
                <form action="#" method="POST" class="main-searchbar-form">
                    <h5>What are you lookking for?</h5>
                    <div class="searchbar-input">
                         <div class="input-wrap w-100 position-relative">
                            <input type="text" placeholder="Search Products, Category, Brands....">
                         </div>
                         <div class="search-close"><i class="flaticon-close"></i></div>
                     </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ============  main searchbar area end =========== -->

    <!-- =============== cart sidebar start=============== -->
    <div class="cart-sidebar-wrappper">
        <div class="main-cart-sidebar">
            <div class="cart-top">
                <div class="cart-close-icon">
                    <i class="flaticon-letter-x"></i>
                </div>
                <ul class="cart-product-grid">
                    @php $totalAmount = 0; @endphp
                    {{-- @foreach() --}}
                    <li class="single-cart-product">
                        <div class="cart-product-info d-flex align-items-center">
                            <div class="product-img"><img src="assets/images/product/cart-p1.png" alt=""
                                    class="img-fluid"></div>
                            <div class="product-info">
                                <a href="product-details.html"><h5 class="product-title">Men Casual Summer Sale</h5></a>
                                <ul class="product-rating d-flex">
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star"></i></li>
                                </ul>
                                <p class="product-price"><span >1</span>x <span class="p-price">$10.32</span>
                                </p>
                            </div>
                        </div>
                        <div class="cart-product-delete-btn">
                            <a href="javascript:void(0)"><i class="flaticon-letter-x"></i></a>
                        </div>
    
                    </li>
    
                </ul>
            </div>
            <div class="cart-bottom">
                <div class="cart-total d-flex justify-content-between">
                    <label>Subtotal :</label>
                    <span>$64.08</span>
                </div>
                <div class="cart-btns">
                    <a href="checkout.html" class="cart-btn checkout">CHECKOUT</a>
                    <a href="cart.html" class="cart-btn cart">VIEW CART</a>
                </div>
    
                <p class="cart-shipping-text"><strong>SHIPPING:</strong> Continue shopping up to $64.08 and receive free
                    shipping. stay with EG </p>
            </div>
        </div>
    </div>
    <!-- =============== cart sidebar end=============== -->

    <!-- ===============  Topbar area start =============== -->
    <div class="topbar-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 ">
                    <ul class="topbar-social-icons d-flex align-items-center">
                        <li class="follow-text">Follow Us</li>
                        @if(!empty($data?->facebook))
                            <li>
                                <a href="{{ $data->facebook }}" target="_blank" rel="noopener noreferrer">
                                    <i class="flaticon-facebook-app-symbol"></i>
                                </a>
                            </li>
                        @endif
                        @if(!empty($data?->twitter))
                            <li>
                                <a href="{{ $data->twitter }}" target="_blank" rel="noopener noreferrer">
                                    <i class="flaticon-twitter-1"></i>
                                </a>
                            </li>
                        @endif
                        @if(!empty($data?->instagram))
                            <li>
                                <a href="{{ $data->instagram }}" target="_blank" rel="noopener noreferrer">
                                    <i class="flaticon-instagram-2"></i>
                                </a>
                            </li>
                        @endif
                        @if(!empty($data?->youtube))
                            <li>
                                <a href="{{ $data->youtube }}" target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-youtube"></i>
                                </a>
                            </li>
                        @endif
                        @if(!empty($data?->linkedin))
                            <li>
                                <a href="{{ $data->linkedin }}" target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 d-flex justify-content-lg-center">
                    <div class="topbar-mobil-contact">
                        <a href="tel:{{ $data?->phone ?? '' }}">Tel : {{ $data?->phone ?? '' }}</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    {{-- <ul class="topbar-right d-flex align-items-center justify-content-end">
                        <li class="order-track">
                           <a href="#"><i class="flaticon-pin"></i> Track Order</a>
                        </li>
                        <li>
                            <select class="languege-select" aria-label="Default select example">
                                <option selected>USD</option>
                                <option value="1">URU</option>
                                <option value="2">CSD</option>
                              </select>
                        </li>
                    </ul> --}}

                    @if ($cart)
                    <a href="{{ route('showCart') }}" class="btn btn-primary">View Cart</a>
                     @endif

                </div>
            </div>
        </div>
    </div>
    <!-- ===============  Topbar area end =============== -->