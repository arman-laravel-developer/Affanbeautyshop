@extends('front.master')

@section('title')
    {{$generalSettingView->site_name}} - Online Store
@endsection

@section('meta_data')
    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="{{$generalSettingView->site_name}}">
    <meta property="og:description" content="{{$generalSettingView->site_name}}">
    <meta property="og:image" content="{{asset($generalSettingView->header_logo)}}">
    <meta property="og:url" content="{{route('home')}}">
    <meta property="og:type" content="website">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{route('home')}}">

    <!-- Twitter Card Meta Tags (For Social Sharing) -->
    <meta name="twitter:card" content="summary_large_image"> <!-- Use "summary" for smaller images -->
    <meta name="twitter:title" content="{{$generalSettingView->site_name}}">
    <meta name="twitter:description" content="{{$generalSettingView->site_name}}">
    <meta name="twitter:image" content="{{asset($generalSettingView->header_logo)}}">
    <meta name="twitter:site" content="@YourTwitterHandle">

    <meta property="og:url" content="{{route('home')}}" />
    <meta property="og:type" content="E-commerce" />
    <meta property="og:title" content="{{$generalSettingView->site_name}}" />
    <meta property="og:description" content="{{$generalSettingView->site_name}}" />
    <meta property="og:image" content="{{asset($generalSettingView->header_logo)}}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:secure_url" content="{{asset($generalSettingView->header_logo)}}" />
    <link rel="image_src" href="{{asset($generalSettingView->header_logo)}}" title="{{$generalSettingView->site_name}}">
@endsection

@section('body')
<!-- Include Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<div class="container-fluid">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
                <div class="swiper-slide">
                    <div class="banner banner-big banner-overlay">
                        <a href="{{$slider->title}}">
                            <img src="{{ asset($slider->image) }}" alt="{{$slider->title}}">
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            autoplay: {
                delay: 3000, // 3 seconds
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                768: {
                    slidesPerView: 1,
                },
                1200: {
                    slidesPerView: 1,
                }
            }
        });
    </script>
</div><!-- End .container-fluid -->

    @if(count($featuredProducts) > 0)
    <div class="bg-light-2 pt-6 pb-3 featured">
        <div class="container-fluid">
            <div class="heading heading-center mb-3">
                <h2 class="title">FEATURED PRODUCTS</h2><!-- End .title -->
            </div><!-- End .heading -->
            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                 data-owl-options='{
                                    "nav": false,
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
                                    "responsive": {
                                        "0": {
                                            "items":2
                                        },
                                        "480": {
                                            "items":2
                                        },
                                        "768": {
                                            "items":3
                                        },
                                        "992": {
                                            "items":4
                                        },
                                        "1200": {
                                            "items":5,
                                            "nav": true
                                        }
                                    }
                                }'>
                @foreach($featuredProducts as $featuredProduct)
                <div class="product product-7 text-center">
                    <figure class="product-media">
                        <a href="{{route('product.show', ['id' => $featuredProduct->id, 'slug' => $featuredProduct->slug])}}" class="product-link">
                            <img src="{{asset($featuredProduct->thumbnail_img)}}" alt="{{$featuredProduct->name}}" class="product-image">
                            <img src="{{asset($featuredProduct->thumbnail_img)}}" alt="{{$featuredProduct->name}}" class="product-image-hover">
                        </a>
{{--                        <div class="product-action">--}}
{{--                            <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>--}}
{{--                        </div><!-- End .product-action -->--}}
                    </figure><!-- End .product-media -->

                    <div class="product-body">
                        <h3 class="product-title"><a href="{{route('product.show', ['id' => $featuredProduct->id, 'slug' => $featuredProduct->slug])}}">{{\Illuminate\Support\Str::limit($featuredProduct->name, 40)}}</a></h3><!-- End .product-title -->
                        <div class="product-price">
                            <span class="new-price">&#2547;{{ number_format(discounted_price($featuredProduct), 2) }}</span>
                            @if(discounted_active($featuredProduct))
                                <span class="old-price">&#2547;{{ number_format($featuredProduct->sell_price, 2) }}</span>
                            @endif
                        </div><!-- End .product-price -->
                        <div class="ratings-container mt-2">
                            <div class="d-flex w-100 " style="gap: 5%">
                                @if(isset($featuredProduct->variants) && $featuredProduct->variants->isNotEmpty())
                                    <a href="{{route('product.show', ['id' => $featuredProduct->id, 'slug' => $featuredProduct->slug])}}" class="btn-outline-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 38px; border: #cc9966; background-color: whitesmoke">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>

                                    <a href="{{route('product.show', ['id' => $featuredProduct->id, 'slug' => $featuredProduct->slug])}}"
                                       class=" btn-primary text-white d-flex justify-content-center align-items-center flex-fill" style="height: 38px;color: white; background-color: #c14196;">
                                        <i class="fa fa-bolt"></i><span class="text-white">&nbsp;Buy Now</span>
                                    </a>
                                @else
                                    <form id="buyNowForm{{ $featuredProduct->id }}" action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $featuredProduct->id }}">
                                        <input type="hidden" name="quantity" value="{{ $featuredProduct->minimum_purchase_qty }}">
                                        <input type="hidden" name="price" value="{{ discounted_price($featuredProduct) }}">
                                        <input type="hidden" name="discount" value="{{ $featuredProduct->discount }}">
                                        <input type="hidden" name="discountType" value="{{ $featuredProduct->discount_type }}">
                                        <input type="hidden" name="thumbnail_image" value="{{ asset($featuredProduct->thumbnail_img) }}">

                                        <!-- Hidden button value field -->
                                        <input type="hidden" name="button" id="submitButtonValue{{ $featuredProduct->id }}">
                                    </form>
                                    <button type="button"
                                            onclick="addToCart({{ $featuredProduct->id }})"
                                            data-product-id="{{ $featuredProduct->id }}"
                                            data-product-title="{{ $featuredProduct->name }}"
                                            data-product-price="{{ discounted_price($featuredProduct) }}"
                                            data-product-image="{{ asset($featuredProduct->thumbnail_img) }}"
                                            class="btn-outline-primary d-flex align-items-center justify-content-center me-2"
                                            style="width: 42px; height: 38px; border: 0px; background-color: whitesmoke;">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>

                                    <a href="javascript:void(0);"
                                       onclick="
                                           document.getElementById('submitButtonValue{{ $featuredProduct->id }}').value = '2';
                                           document.getElementById('buyNowForm{{ $featuredProduct->id }}').submit();
                                           "
                                       class="btn-primary text-white d-flex justify-content-center align-items-center flex-fill"
                                       style="height: 38px;color: white; background-color: #c14196;">
                                        <i class="fa fa-bolt"></i><span class="text-white">&nbsp;Buy Now</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div><!-- End .product-body -->
                </div><!-- End .product -->
                @endforeach
            </div><!-- End .owl-carousel -->
        </div><!-- End .container-fluid -->
    </div><!-- End .bg-light-2 pt-4 pb-4 -->
    @endif

@foreach($categoryWiseHomeViews as $categoryWiseHomeView)
    <div class="bg-lighter" style="padding: 1%">
        <div class="container-fluid">
            <div class="heading heading-center mb-3">
                <h2 class="title">{{ $categoryWiseHomeView->category_name }}</h2><!-- End .title -->
            </div><!-- End .heading -->
            <div class="products">
                <div class="row justify-content-center">

                    @php
                        // Get all subcategory IDs including the parent category
                        $categoryIds = \App\Models\Category::where('id', $categoryWiseHomeView->id)
                            ->orWhere('parent_id', $categoryWiseHomeView->id)
                            ->pluck('id');

                        // Fetch products from these categories
                        $categoryWiseProducts = \App\Models\Product::where('status',1)->whereIn('category_id', $categoryIds)
                            ->take(4)->orderBy('id', 'asc')->get();
                    @endphp

                    @foreach($categoryWiseProducts as $categoryWiseProduct)
                        <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                            <div class="product product-7 text-center">
                                <figure class="product-media">
                                    @php
                                        $isNew = \Carbon\Carbon::parse($categoryWiseProduct->created_at)->gt(\Carbon\Carbon::now()->subDays(14));
                                    @endphp

                                    @if($isNew)
                                        <span class="product-label label-new">New</span>
                                    @endif
                                    <a href="{{ route('product.show', ['id' => $categoryWiseProduct->id, 'slug' => $categoryWiseProduct->slug]) }}" class="product-link">
                                        <img src="{{ asset($categoryWiseProduct->thumbnail_img) }}" alt="Product image" class="product-image">
                                        <img src="{{ asset($categoryWiseProduct->thumbnail_img) }}" alt="Product image" class="product-image-hover">
                                    </a>
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <h3 class="product-title">
                                        <a href="{{ route('product.show', ['id' => $categoryWiseProduct->id, 'slug' => $categoryWiseProduct->slug]) }}">
                                            {{ \Illuminate\Support\Str::limit($categoryWiseProduct->name, 40) }}
                                        </a>
                                    </h3><!-- End .product-title -->

                                    <div class="product-price">
                                        <span class="new-price">&#2547;{{ number_format(discounted_price($categoryWiseProduct), 2) }}</span>

                                        @if(discounted_active($categoryWiseProduct))
                                            <span class="old-price">&#2547;{{ number_format($categoryWiseProduct->sell_price, 2) }}</span>
                                        @endif
                                    </div><!-- End .product-price -->

                                    <div class="ratings-container mt-2">
                                        <div class="d-flex w-100 " style="gap: 5%">
                                            @if(isset($categoryWiseProduct->variants) && $categoryWiseProduct->variants->isNotEmpty())
                                                <a href="{{route('product.show', ['id' => $categoryWiseProduct->id, 'slug' => $categoryWiseProduct->slug])}}" class="btn-outline-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 38px; border: #cc9966; background-color: whitesmoke">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </a>

                                                <a href="{{route('product.show', ['id' => $categoryWiseProduct->id, 'slug' => $categoryWiseProduct->slug])}}"
                                                   class=" btn-primary text-white d-flex justify-content-center align-items-center flex-fill" style="height: 38px;color: white; background-color: #c14196;">
                                                    <i class="fa fa-bolt"></i><span class="text-white">&nbsp;Buy Now</span>
                                                </a>
                                            @else
                                                <form id="buyNowForm{{ $categoryWiseProduct->id }}" action="{{ route('cart.add') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $categoryWiseProduct->id }}">
                                                    <input type="hidden" name="quantity" value="{{ $categoryWiseProduct->minimum_purchase_qty }}">
                                                    <input type="hidden" name="price" value="{{ discounted_price($categoryWiseProduct) }}">
                                                    <input type="hidden" name="discount" value="{{ $categoryWiseProduct->discount }}">
                                                    <input type="hidden" name="discountType" value="{{ $categoryWiseProduct->discount_type }}">
                                                    <input type="hidden" name="thumbnail_image" value="{{ asset($categoryWiseProduct->thumbnail_img) }}">

                                                    <!-- Hidden button value field -->
                                                    <input type="hidden" name="button" id="submitButtonValue{{ $categoryWiseProduct->id }}">
                                                </form>
                                                <button type="button"
                                                        onclick="addToCart({{ $categoryWiseProduct->id }})"
                                                        data-product-id="{{ $categoryWiseProduct->id }}"
                                                        data-product-title="{{ $categoryWiseProduct->name }}"
                                                        data-product-price="{{ discounted_price($categoryWiseProduct) }}"
                                                        data-product-image="{{ asset($categoryWiseProduct->thumbnail_img) }}"
                                                        class="btn-outline-primary d-flex align-items-center justify-content-center me-2"
                                                        style="width: 42px; height: 38px; border: 0px; background-color: whitesmoke;">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </button>

                                                <a href="javascript:void(0);"
                                                   onclick="
                                                       document.getElementById('submitButtonValue{{ $categoryWiseProduct->id }}').value = '2';
                                                       document.getElementById('buyNowForm{{ $categoryWiseProduct->id }}').submit();
                                                       "
                                                   class="btn-primary text-white d-flex justify-content-center align-items-center flex-fill"
                                                   style="height: 38px;color: white; background-color: #c14196;">
                                                    <i class="fa fa-bolt"></i><span class="text-white">&nbsp;Buy Now</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="ratings">--}}
{{--                                            <div class="ratings-val" style="width: 100%;"></div><!-- End .ratings-val -->--}}
{{--                                        </div><!-- End .ratings -->--}}
{{--                                        <span class="ratings-text">( 4 Reviews )</span>--}}
{{--                                    </div><!-- End .ratings-container -->--}}
                                </div><!-- End .product-body -->
                            </div><!-- End .product -->
                        </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                    @endforeach
                </div><!-- End .row -->
            </div><!-- End .products -->

            <div class="text-center mt-2">
                <a href="{{ route('category.product', ['id' => $categoryWiseHomeView->id ]) }}" style="font-size: 2rem">
                    <span>More Products</span>
                    <i class="icon-long-arrow-right"></i>
                </a>
            </div><!-- End .more-container -->
        </div><!-- End .container-fluid -->
    </div><!-- End .bg-light-2 pt-4 pb-4 -->
@endforeach


{{--    <div class="container-fluid">--}}
{{--        <div class="heading heading-center mb-3">--}}
{{--            <h2 class="title">NEW ARRIVALS</h2><!-- End .title -->--}}
{{--        </div><!-- End .heading -->--}}
{{--        <div class="products">--}}
{{--            <div class="row justify-content-center">--}}
{{--                @foreach($newArrivals as $newArrival)--}}
{{--                <div class="col-6 col-md-4 col-lg-3 col-xl-5col">--}}
{{--                    <div class="product product-7 text-center">--}}
{{--                        <figure class="product-media">--}}
{{--                            @php--}}
{{--                                $isNew = \Carbon\Carbon::parse($newArrival->created_at)->gt(\Carbon\Carbon::now()->subDays(14));--}}
{{--                            @endphp--}}

{{--                            @if($isNew)--}}
{{--                                <span class="product-label label-new">New</span>--}}
{{--                            @endif--}}
{{--                            <a href="{{route('product.show', ['id' => $newArrival->id])}}" class="product-link">--}}
{{--                                <img src="{{asset($newArrival->thumbnail_img)}}" alt="Product image" class="product-image">--}}
{{--                                <img src="{{asset($newArrival->thumbnail_img)}}" alt="Product image" class="product-image-hover">--}}
{{--                            </a>--}}
{{--                        </figure><!-- End .product-media -->--}}

{{--                        <div class="product-body">--}}
{{--                            <h3 class="product-title"><a href="{{route('product.show', ['id' => $newArrival->id])}}">{{\Illuminate\Support\Str::limit($newArrival->name, 40)}}</a></h3><!-- End .product-title -->--}}
{{--                            <div class="product-price">--}}
{{--                                @php--}}
{{--                                    $newPrice = $newArrival->sell_price;--}}

{{--                                    if ($newArrival->discount > 0) {--}}
{{--                                        if ($newArrival->discount_type == 2) {--}}
{{--                                            $newPrice = $newArrival->sell_price - ($newArrival->sell_price * ($newArrival->discount / 100));--}}
{{--                                        } else {--}}
{{--                                            $newPrice = $newArrival->sell_price - $newArrival->discount;--}}
{{--                                        }--}}
{{--                                    }--}}
{{--                                @endphp--}}
{{--                                <span class="new-price">&#2547;{{ number_format($newPrice, 2) }}</span>--}}

{{--                                @if($newArrival->discount > 0)--}}
{{--                                    <span class="old-price">&#2547;{{ number_format($newArrival->sell_price, 2) }}</span>--}}
{{--                                    @if($newArrival->discount_type == 'percent')--}}
{{--                                        <span class="discount">-{{ $newArrival->discount }}%</span>--}}
{{--                                    @else--}}
{{--                                        <span class="discount">-&#2547;{{ number_format($newArrival->discount, 2) }}</span>--}}
{{--                                    @endif--}}
{{--                                @endif--}}
{{--                            </div><!-- End .product-price -->--}}
{{--                            <div class="ratings-container">--}}
{{--                                <div class="ratings">--}}
{{--                                    <div class="ratings-val" style="width: 100%;"></div><!-- End .ratings-val -->--}}
{{--                                </div><!-- End .ratings -->--}}
{{--                                <span class="ratings-text">( 4 Reviews )</span>--}}
{{--                            </div><!-- End .rating-container -->--}}
{{--                        </div><!-- End .product-body -->--}}
{{--                    </div><!-- End .product -->--}}
{{--                </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->--}}
{{--                @endforeach--}}
{{--            </div><!-- End .row -->--}}
{{--        </div><!-- End .products -->--}}

{{--        <div class="more-container text-center mt-2">--}}
{{--            <button id="load-more-btn" class="btn btn-outline-dark-3 btn-more">--}}
{{--                <span>Load more</span>--}}
{{--                <i class="icon-long-arrow-right"></i>--}}
{{--            </button>--}}
{{--        </div><!-- End .more-container -->--}}
{{--    </div><!-- End .container-fluid -->--}}

{{--    <div class="brands-border owl-carousel owl-simple" data-toggle="owl"--}}
{{--         data-owl-options='{--}}
{{--                    "nav": false,--}}
{{--                    "dots": false,--}}
{{--                    "margin": 0,--}}
{{--                    "loop": false,--}}
{{--                    "responsive": {--}}
{{--                        "0": {--}}
{{--                            "items":2--}}
{{--                        },--}}
{{--                        "420": {--}}
{{--                            "items":3--}}
{{--                        },--}}
{{--                        "600": {--}}
{{--                            "items":4--}}
{{--                        },--}}
{{--                        "900": {--}}
{{--                            "items":5--}}
{{--                        },--}}
{{--                        "1024": {--}}
{{--                            "items":6--}}
{{--                        },--}}
{{--                        "1360": {--}}
{{--                            "items":7--}}
{{--                        }--}}
{{--                    }--}}
{{--                }'>--}}
{{--        <a href="#" class="brand">--}}
{{--            <img src="{{asset('/')}}front/assets/images/brands/1.png" alt="Brand Name">--}}
{{--        </a>--}}

{{--        <a href="#" class="brand">--}}
{{--            <img src="{{asset('/')}}front/assets/images/brands/2.png" alt="Brand Name">--}}
{{--        </a>--}}

{{--        <a href="#" class="brand">--}}
{{--            <img src="{{asset('/')}}front/assets/images/brands/3.png" alt="Brand Name">--}}
{{--        </a>--}}

{{--        <a href="#" class="brand">--}}
{{--            <img src="{{asset('/')}}front/assets/images/brands/4.png" alt="Brand Name">--}}
{{--        </a>--}}

{{--        <a href="#" class="brand">--}}
{{--            <img src="{{asset('/')}}front/assets/images/brands/5.png" alt="Brand Name">--}}
{{--        </a>--}}

{{--        <a href="#" class="brand">--}}
{{--            <img src="{{asset('/')}}front/assets/images/brands/6.png" alt="Brand Name">--}}
{{--        </a>--}}

{{--        <a href="#" class="brand">--}}
{{--            <img src="{{asset('/')}}front/assets/images/brands/7.png" alt="Brand Name">--}}
{{--        </a>--}}
{{--    </div><!-- End .owl-carousel -->--}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var page = 2; // Start from the second page as the first is already loaded

        $('#load-more-btn').click(function() {
            $.ajax({
                url: '{{ route("home") }}' + '?page=' + page,
                type: 'GET',
                beforeSend: function() {
                    $('#load-more-btn').text('Loading...').prop('disabled', true);
                },
                success: function(data) {
                    if (data.html) {
                        $('.products .row').append(data.html); // Append new products to the row
                        page++; // Increment page number for the next request
                        $('#load-more-btn').text('Load more').prop('disabled', false);
                    } else {
                        $('#load-more-btn').text('No more products').prop('disabled', true);
                    }
                },
                error: function() {
                    alert('Failed to load more products. Please try again.');
                    $('#load-more-btn').text('Load more').prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection
