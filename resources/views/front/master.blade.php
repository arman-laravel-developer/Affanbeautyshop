 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title')</title>
    <meta name="keywords" content="t-shirt">
    <meta name="description" content="{{$generalSettingView->site_name}}">
    <meta name="author" content="{{$generalSettingView->site_name}}">
    <!-- Robots - tells search engines whether to index/follow links -->
    <meta name="robots" content="all">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset($generalSettingView->favicon)}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset($generalSettingView->favicon)}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset($generalSettingView->favicon)}}">
    <link rel="manifest" href="{{asset('/')}}front/assets/images/icons/site.webmanifest">
    <link rel="mask-icon" href="{{asset($generalSettingView->favicon)}}" color="#666666">
    <link rel="shortcut icon" href="{{asset($generalSettingView->favicon)}}">
    <meta name="apple-mobile-web-app-title" content="{{$generalSettingView->site_name}}">
    <meta name="application-name" content="{{$generalSettingView->site_name}}">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="{{asset('/')}}front/assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    @yield('meta_data')


    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{asset('/')}}front/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/')}}front/assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="{{asset('/')}}front/assets/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="{{asset('/')}}front/assets/css/plugins/jquery.countdown.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{asset('/')}}front/assets/css/style.css">
{{--    <link rel="stylesheet" href="{{asset('/')}}front/assets/css/skins/skin-demo-7.css">--}}
{{--    <link rel="stylesheet" href="{{asset('/')}}front/assets/css/demos/demo-7.css">--}}
    <link rel="stylesheet" href="{{asset('/')}}front/assets/css/plugins/nouislider/nouislider.css">
    <!-- Include Toastr CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;700&display=swap" rel="stylesheet">


@if(optional($googleAnalytic)->tag_manager_status == 1)
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{optional($googleAnalytic)->tag_manager}}');</script>
    <!-- End Google Tag Manager -->
    @endif

    @if(optional($googleAnalytic)->google_analytics_status == 1)
    <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{optional($googleAnalytic)->google_analytics}}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{optional($googleAnalytic)->google_analytics}}');
        </script>
        <!-- End Google Analytics -->
    @endif

    @if(optional($googleAnalytic)->facebook_pixel_status == 1)
    <!-- Meta Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{optional($googleAnalytic)->facebook_pixel}}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                       src="https://www.facebook.com/tr?id={{optional($googleAnalytic)->facebook_pixel}}&ev=PageView&noscript=1"
            /></noscript>
        <!-- End Meta Pixel Code -->
    @endif
<meta name="facebook-domain-verification" content="72r3tegqu510ac5ke5ssgbdy4mnlih" />
    <style>
        #suggestions {
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ddd;
            z-index: 1000;
            list-style-type: none;
            padding-left: 0;
            margin-top: 0;
        }
        #suggestions li {
            padding: 10px;
            cursor: pointer;
        }
        #suggestions li:hover {
            background-color: #f0f0f0;
        }

        .fixed_whats a {
            width: 42px;
            height: 42px;
            background: #049704;
            text-align: center;
            line-height: 42px;
            font-size: 25px;
            position: fixed;
            bottom: 68px;
            right: 34px;
            border-radius: 50px;
            color: #fff;
            z-index: 9999;
        }
    </style>



</head>

<body>
<div class="page-wrapper">

    <header class="header header-7">
        <div class="header-top">
            <div class="container-fluid">
                <div class="header-left">
                    <div class="header-dropdown">
                        <a href="javascript:void(0)">BDT</a>
                        <div class="header-menu">
                            <ul>
                                <li><a href="javascript:void(0)">USD</a></li>
                                <li><a href="javascript:void(0)">BDT</a></li>
                            </ul>
                        </div><!-- End .header-menu -->
                    </div><!-- End .header-dropdown -->

                    <div class="header-dropdown">
                        <a href="javascript:void(0)">Eng</a>
                        <div class="header-menu">
                            <ul>
                                <li><a href="javascript:void(0)">English</a></li>
                                <li><a href="javascript:void(0)">Bangla</a></li>
                                <li><a href="javascript:void(0)">Spanish</a></li>
                            </ul>
                        </div><!-- End .header-menu -->
                    </div><!-- End .header-dropdown -->
                </div><!-- End .header-left -->

                <div class="header-right">
                    <ul class="top-menu">
                        <li>
                            <a href="#">Links</a>
                            <ul>
                                <li><a href="tel:{{$generalSettingView->mobile}}"><i class="icon-phone"></i>Call: {{$generalSettingView->mobile}}</a></li>
                                {{-- <li><a href="wishlist.html"><i class="icon-heart-o"></i>My Wishlist <span>(3)</span></a></li> --}}
                                <li><a href="{{route('about.us')}}">About Us</a></li>
                                <li><a href="{{route('contact.us')}}">Contact Us</a></li>
                                <li><a href="{{route('all.products')}}">Products</a></li>
                                @if(Session::get('customer_id'))
                                    <li><a href="{{route('customer.dashboard')}}"><i class="icon-user"></i>Dashboard</a></li>
                                @else
                                    <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user"></i>Login</a></li>
                                @endif
                            </ul>
                        @else
                            <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user"></i>Login</a></li>
                        @endif
                    </ul>
                    <div class="header-middle sticky-header">
                        <div class="container-fluid">
                            <div class="header-left">
                                <button class="mobile-menu-toggler">
                                    <span class="sr-only">Toggle mobile menu</span>
                                    <i class="icon-bars"></i>
                                </button>

                                <a href="{{route('home')}}" class="logo">
                                    <img src="{{asset($generalSettingView->header_logo)}}" alt="{{$generalSettingView->site_name}} Logo" width="161" height="25">
                                </a>

                                <nav class="main-nav">
                                    <ul class="menu sf-arrows">
                                        <li class="megamenu-container active">
                                            <a href="{{route('home')}}" class="">Home</a>
                                        </li>
                                        @foreach($menuCategories as $menuCategory)
                                            <li>
                                                <a href="{{route('category.product', ['id' => $menuCategory->id])}}" class="">{{$menuCategory->category_name}}</a>
                                                @if(count($menuCategory->subCategories) > 0)
                                                    <div class="megamenu megamenu-sm">
                                                        <div class="row no-gutters">
                                                            <div class="col-md-12">
                                                                <div class="menu-col">
                                                                    <ul>
                                                                        @foreach($menuCategory->subCategories as $subCategory)
                                                                            <li class="menu-title">
                                                                                <a href="{{route('category.product', ['id' => $subCategory->id])}}">{{$subCategory->category_name}}</a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div><!-- End .menu-col -->
                                                            </div><!-- End .col-md-12 -->
                                                        </div><!-- End .row -->
                                                    </div><!-- End .megamenu megamenu-sm -->
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul><!-- End .menu -->
                                </nav><!-- End .main-nav -->
                            </div><!-- End .header-left -->

                            <div class="header-right">
                                <div class="header-search header-search-extended header-search-visible">
                                    <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                                    <form action="{{ route('product.search') }}" method="get">
                                        <div class="header-search-wrapper search-wrapper-wide">
                                            <label for="q" class="sr-only">Search</label>
                                            <input type="search" class="form-control" name="q" id="q" placeholder="Search products..." autocomplete="off" required>
                                            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                                        </div><!-- End .header-search-wrapper -->
                                        <!-- Suggestions list -->
                                        <ul id="suggestions" class="list-group" style="display: none;"></ul>
                                    </form>
                                </div><!-- End .header-search -->

                                <style>
                                    .dropdown-menu {
                                        width: 300px; /* Adjust width as needed */
                                        max-height: 400px; /* Set a fixed height */
                                        overflow: hidden;
                                        display: flex;
                                        flex-direction: column;
                                    }

                                    .dropdown-cart-products {
                                        max-height: 250px; /* Height for scrollable area */
                                        overflow-y: auto;
                                        padding: 10px;
                                    }

                                    .dropdown-cart-bottom {
                                        position: sticky;
                                        bottom: 0;
                                        background: #fff;
                                        padding: 10px;
                                        border-top: 1px solid #ddd;
                                    }
                                </style>

                                <div class="dropdown cart-dropdown">
                                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                        <i class="icon-shopping-cart"></i>
                                        <span class="cart-count">{{count($cartProducts)}}</span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-cart-products">
                                            @foreach($cartProducts as $cartProduct)
                                                @php
                                                    $product = \App\Models\Product::find($cartProduct->attributes->product_id);
                                                @endphp
                                                <div class="product">
                                                    <div class="product-cart-details">
                                                        <h4 class="product-title">
                                                            <a href="{{route('product.show', ['id' => $cartProduct->attributes->product_id, 'slug' => $product->slug])}}">{{$cartProduct->name}}</a>
                                                        </h4>
                                                        <span class="cart-product-info">
                                        <span class="cart-product-qty">{{$cartProduct->quantity}}</span>
                                        x &#2547;{{number_format($cartProduct->price)}}
                                    </span>
                                                    </div>
                                                    <figure class="product-image-container">
                                                        <a href="{{route('product.show', ['id' => $cartProduct->attributes->product_id, 'slug' => $product->slug])}}" class="product-image">
                                                            <img src="{{asset($cartProduct->attributes->thumbnail_image)}}" alt="product">
                                                        </a>
                                                    </figure>
                                                    <a href="#" class="btn-remove" title="Remove Product" data-product-id="{{$cartProduct->id}}">
                                                        <i class="icon-close"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="dropdown-cart-bottom">
                                            <div class="dropdown-cart-total">
                                                <span>Total</span>
                                                @php($total = Cart::getTotal())
                                                <span class="cart-total-price">&#2547;{{number_format($total)}}</span>
                                            </div>

                                            <div class="dropdown-cart-action">
                                                <a href="{{route('cart.index')}}" class="btn btn-primary" style="margin-right: 2%">View Cart</a>
                                                <a href="{{route('checkout')}}" class="btn btn-outline-primary-2">
                                                    <span>Checkout</span><i class="icon-long-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End .header-right -->
                        </div><!-- End .container-fluid -->
                    </div><!-- End .header-middle -->
    </header><!-- End .header -->
    <main class="main">
        @yield('body')
    </main><!-- End .main -->
    <footer class="footer footer-dark">
    <div class="footer-middle">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-4">
                    <div class="widget widget-about">
                        <img src="{{asset($generalSettingView->footer_logo)}}" class="footer-logo" alt="Footer Logo" width="161" height="25">
                        <p>{{$generalSettingView->about_us_short}}</p>

                        <div class="widget-about-info">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <span class="widget-about-title text-light">Have questions? Call 24/7</span>
                                    <a href="tel:{{$generalSettingView->mobile}}" style="font-size: 85%;">{{$generalSettingView->mobile}}</a>
                                </div>
                                <div class="col-sm-6 col-md-8">
                                    <span class="widget-about-title text-light">Payment Methods</span>
                                    <figure class="footer-payments">
                                        <img src="{{asset($generalSettingView->payment_method_image)}}" alt="Payment methods" style="width: 60%; margin-left: -5%;">
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 col-lg-2">
                    <div class="widget">
                        <h4 class="widget-title">Useful Links</h4>
                        <ul class="widget-list">
                            <li><a href="{{route('about.us')}}">About {{$generalSettingView->site_name}}</a></li>
                            <li><a href="#">How to Shop</a></li>
                            <li><a href="{{route('contact.us')}}">Contact Us</a></li>
                            @if(Session::get('customer_id'))
                                <li><a href="{{route('customer.dashboard')}}">Dashboard</a></li>
                            @else
                                <li><a href="#signin-modal" data-toggle="modal">Login</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-sm-4 col-lg-2">
                    <div class="widget">
                        <h4 class="widget-title">Customer Service</h4>
                        <ul class="widget-list">
                            <li><a href="{{route('condition.page')}}">Terms & Conditions</a></li>
                            <li><a href="{{route('privacy.page')}}">Privacy Policy</a></li>
                            <li><a href="{{route('return.view')}}">Return & Refund Policy</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-4 col-lg-2">
                    <div class="widget">
                        <h4 class="widget-title">My Account</h4>
                        <ul class="widget-list">
                            @if(Session::get('customer_id'))
                                <li><a href="{{route('customer.dashboard')}}">Dashboard</a></li>
                            @else
                                <li><a href="#signin-modal" data-toggle="modal">Sign In</a></li>
                            @endif
                            <li><a href="{{route('cart.index')}}">View Cart</a></li>
                            <li><a href="{{route('track.order')}}">Track Order</a></li>
                            <li><a href="{{route('contact.us')}}">Help</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-2">
                    <div class="widget widget-newsletter">
                        <h4 class="widget-title">Subscribe to Newsletter</h4>
                        <form action="#">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Enter your email" aria-label="Email Address" required>
                                <div class="input-group-append">
                                    <button class="btn btn-dark" type="submit"><i class="icon-long-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container-fluid">
            <p class="footer-copyright">Copyright © {{date('Y')}} {{$generalSettingView->site_name}}. All rights reserved. Designed and developed by <a href="https://armanalibd.com" target="_blank"><b>Md Arman Ali</b></a></p>

            <div class="social-icons social-icons-color">
                <span class="social-label">Social Media</span>
                <a href="{{$generalSettingView->facebook_url}}" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                <a href="{{$generalSettingView->twitter_url}}" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                <a href="{{$generalSettingView->instagram_url}}" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                <a href="{{$generalSettingView->youtube_url}}" class="social-icon social-youtube" title="YouTube" target="_blank"><i class="icon-youtube"></i></a>
            </div>
        </div>
    </div>
</footer><!-- End .footer -->
</div><!-- End .page-wrapper -->
@if(!Route::is('product.show'))
<div class="fixed_whats">
    <a href="https://api.whatsapp.com/send/?phone={{$generalSettingView->pinterest_url}}" target="_blank"><i class="icon-whatsapp"></i></a>
</div>
@endif

<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

<!-- Mobile Menu -->
<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

<div class="mobile-menu-container">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-close"></i></span>

        <form action="{{ route('product.search') }}" method="get" class="mobile-search">
            <label for="mobile-search" class="sr-only">Search</label>
            <input type="search" class="form-control" name="q" id="mobile-search" placeholder="Search here..." required>
            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
        </form>

        <nav class="mobile-nav">
            <ul class="mobile-menu">
                <li class="active">
                    <a href="{{route('home')}}">Home</a>
                </li>
                @foreach($menuCategories as $menuCategory)
                <li>
                    <a href="{{route('category.product', ['id' => $menuCategory->id])}}">{{$menuCategory->category_name}}</a>
                    @if(count($menuCategory->subCategories) > 0)
                    <ul>
                        @foreach($menuCategory->subCategories as $subCategory)
                        <li><a href="{{route('category.product', ['id' => $subCategory->id])}}">{{$subCategory->category_name}}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach

                <li class="active">
                    <a href="{{route('all.products')}}">All Products</a>
                </li>
            </ul>
        </nav><!-- End .mobile-nav -->

        <div class="social-icons">
            <a href="{{$generalSettingView->facebook_url}}" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
            <a href="{{$generalSettingView->twitter_url}}" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
            <a href="{{$generalSettingView->instagram_url}}" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
            <a href="{{$generalSettingView->youtube_url}}" class="social-icon" target="_blank" title="YouTube"><i class="icon-youtube"></i></a>
        </div><!-- End .social-icons -->
    </div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->

<!-- Sign in / Register Modal -->
<div class="modal fade @if(!in_array(Route::currentRouteName(), ['set.password', 'checkout', 'customer.dashboard'])) @if ($errors->has('name') || $errors->has('email') || $errors->has('mobile') || $errors->has('password')) show @endif @endif"
     id="signin-modal"
     tabindex="-1"
     role="dialog"
     aria-hidden="true"
     @if(!in_array(Route::currentRouteName(), ['set.password', 'checkout', 'customer.dashboard'])) @if ($errors->has('name') || $errors->has('email') || $errors->has('mobile') || $errors->has('password')) style="display: block;" @endif @endif>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <div class="form-tab">
                        <ul class="nav nav-pills nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(!$errors->has('email') && !$errors->has('mobile') && !$errors->has('password')) active @endif" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($errors->has('name') || $errors->has('email') || $errors->has('mobile') || $errors->has('password')) active @endif" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tab-content-5">
                            <div class="tab-pane fade @if(!$errors->has('email') && !$errors->has('mobile') && !$errors->has('password')) show active @endif" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                <form action="{{route('customer.login')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="signin-email">Mobile or Email Address *</label>
                                        <input type="text" class="form-control" id="signin-email" name="email" required>
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="signin-password">Password *</label>
                                        <input type="password" class="form-control" id="signin-password" name="password" required>
                                    </div><!-- End .form-group -->

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>Sign In</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="signin-remember">
                                            <label class="custom-control-label" for="signin-remember">Remember Me</label>
                                        </div><!-- End .custom-checkbox -->

                                        <a href="{{route('forget.password')}}" class="forgot-link">Forgot Your Password?</a>
                                    </div><!-- End .form-footer -->
                                </form>
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade @if($errors->has('name') || $errors->has('email') || $errors->has('mobile') || $errors->has('password')) show active @endif" id="register" role="tabpanel" aria-labelledby="register-tab">
                                <form action="{{route('customer.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="register-name">Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="register-name" value="{{old('name')}}" name="name" required>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="register-email">Your Email Address *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="register-email" value="{{old('email')}}" name="email" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="register-mobile">Mobile *</label>
                                        <input type="tel" class="form-control @error('mobile') is-invalid @enderror" id="register-mobile" value="{{old('mobile')}}" name="mobile" required>
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="register-password">Password *</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="register-password" name="password" required>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div><!-- End .form-group -->

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>Sign Up</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="1" name="policy" id="register-policy" required>
                                            <label class="custom-control-label" for="register-policy">I agree to the <a href="#">Privacy Policy</a> *</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .form-footer -->
                                </form>
                            </div><!-- .End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .form-tab -->
                </div><!-- End .form-box -->
            </div><!-- End .modal-body -->
        </div><!-- End .modal-content -->
    </div><!-- End .modal-dialog -->
</div><!-- End .modal -->



@if(!in_array(Route::currentRouteName(), ['set.password', 'checkout', 'customer.dashboard']))
    <script>
        $(document).ready(function () {
            // Check if any validation errors exist and show the modal if necessary
            @if ($errors->any())
            $('#signin-modal').modal('show');
            @endif
        });
    </script>
@endif
<!-- Bootstrap Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-3" style="border-radius: 10px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title w-100" id="cartModalLabel" style="color: #3FA33F; font-weight: 700; font-size: 20px;">
                    <i class="fas fa-shopping-cart" style="font-size: 28px;"></i><br>
                    Item added to your cart!
                </h5>
                <button type="button" style="border: none" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
            </div>

            <div class="modal-body pt-0">
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <img id="modalImage" src="" alt="Product Image" style="width: 80px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                    <div style="text-align: left;">
                        <p id="modalProductTitle" class="mb-1" style="font-weight: 600; font-size: 15px;"></p>
                        <p class="mb-0" style="color: red; font-weight: bold;">৳<span id="modalProductPrice"></span></p>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 d-flex justify-content-between pt-3">
                <button type="button" class="btn btn-sm btn-success w-50 me-2" data-dismiss="modal" style="font-weight: 600; min-width: 50%;">Continue Shopping</button>
                <a href="{{ route('checkout') }}" class="btn btn-sm btn-danger w-50" style="font-weight: 600; min-width: 50%">Buy Now</a>
            </div>
        </div>
    </div>
</div>


{{--<div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-10">--}}
{{--            <div class="row no-gutters bg-white newsletter-popup-content">--}}
{{--                <div class="col-xl-3-5col col-lg-7 banner-content-wrap">--}}
{{--                    <div class="banner-content text-center">--}}
{{--                        <img src="{{asset('/')}}front/assets/images/popup/newsletter/logo.png" class="logo" alt="logo" width="60" height="15">--}}
{{--                        <h2 class="banner-title">get <span>25<light>%</light></span> off</h2>--}}
{{--                        <p>Subscribe to the {{$generalSettingView->site_name}} eCommerce newsletter to receive timely updates from your favorite products.</p>--}}
{{--                        <form action="#">--}}
{{--                            <div class="input-group input-group-round">--}}
{{--                                <input type="email" class="form-control form-control-white" placeholder="Your Email Address" aria-label="Email Adress" required>--}}
{{--                                <div class="input-group-append">--}}
{{--                                    <button class="btn" type="submit"><span>go</span></button>--}}
{{--                                </div><!-- .End .input-group-append -->--}}
{{--                            </div><!-- .End .input-group -->--}}
{{--                        </form>--}}
{{--                        <div class="custom-control custom-checkbox">--}}
{{--                            <input type="checkbox" class="custom-control-input" id="register-policy-2" required>--}}
{{--                            <label class="custom-control-label" for="register-policy-2">Do not show this popup again</label>--}}
{{--                        </div><!-- End .custom-checkbox -->--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-xl-2-5col col-lg-5 ">--}}
{{--                    <img src="{{asset('/')}}front/assets/images/popup/newsletter/img-1.jpg" class="newsletter-img" alt="newsletter">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const removeUrl = "{{ route('cart.remove', ['productId' => 'PRODUCT_ID_PLACEHOLDER']) }}";

        document.querySelectorAll('.btn-remove').forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                const productId = this.getAttribute('data-product-id');
                const url = removeUrl.replace('PRODUCT_ID_PLACEHOLDER', productId);

                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the product from the DOM
                            this.closest('.product').remove();

                            // Update the cart total
                            document.querySelector('.cart-count').textContent = data.cartCount;
                            document.querySelector('.cart-total-price').textContent = '৳' + number_format(data.total);
                        } else {
                            alert('Error removing product from cart.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        // Helper function to format numbers (optional)
        function number_format(number) {
            return parseFloat(number).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
    });
</script>

@include('flash-toastr::message')

<style>
    /* Customize toastr text size */
    #toast-container > .toast {
        font-size: 16px; /* Adjust this to the desired size */
    }
</style>

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- jQuery (Toastr নির্ভর করে) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    // Toastr configuration options
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    // Display toastr based on session messages
    @if(session('success'))
    toastr.success("{{ session('success') }}");
    @elseif(session('error'))
    toastr.error("{{ session('error') }}");
    @elseif(session('info'))
    toastr.info("{{ session('info') }}");
    @elseif(session('warning'))
    toastr.warning("{{ session('warning') }}");
    @endif
</script>


@if(optional($googleAnalytic)->tag_manager_status == 1)
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{optional($googleAnalytic)->tag_manager}}"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@endif

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var debounceTimer;

        $('#q').on('keyup', function() {
            var query = $(this).val();

            clearTimeout(debounceTimer); // Clear the previous timer
            debounceTimer = setTimeout(function() { // Set a new timer
                if (query.length > 0) {
                    $.ajax({
                        url: "{{ route('product.ajaxSearch') }}",
                        type: 'GET',
                        data: {'q': query},
                        success: function(data) {
                            $('#suggestions').empty().show(); // Clear previous suggestions
                            if (data.length > 0) {
                                $.each(data, function(index, product) {
                                    var productUrl = "{{ route('product.show', [':id', ':slug']) }}"
                                        .replace(':id', product.id)
                                        .replace(':slug', product.slug); // Ensure `slug` is present here

                                    $('#suggestions').append(
                                        '<a href="' + productUrl + '">' +
                                        '<li class="list-group-item" role="option" data-product-id="' + product.id + '" data-product-slug="' + product.slug + '">' +
                                        product.name +
                                        '</li>' +
                                        '</a>'
                                    );
                                });
                            } else {
                                $('#suggestions').append('<li class="list-group-item">No results found</li>');
                            }
                        }
                    });
                } else {
                    $('#suggestions').empty().hide(); // Hide suggestions when input is empty
                }
            }, 300); // Debounce delay in milliseconds
        });

        // Handle click event on <li> elements (if needed to intercept the link click)
        $(document).on('click', '#suggestions li', function() {
            var productId = $(this).data('product-id');
            var productSlug = $(this).data('product-slug');
            if (productId && productSlug) {
                var url = "{{ route('product.show', [':id', ':slug']) }}"
                    .replace(':id', productId)
                    .replace(':slug', productSlug);

                window.location.href = url;
            }
        });

        // Hide suggestions when clicking outside the input field
        $(document).click(function(event) {
            if (!$(event.target).closest('#q, #suggestions').length) {
                $('#suggestions').empty().hide();
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const header = document.querySelector('.header-middle'); // Select the header

        window.addEventListener('scroll', function () {
            let scrollTop = window.scrollY || document.documentElement.scrollTop;

            if (scrollTop > 0) {
                // When not at the top of the page
                header.classList.add('fixed');
            } else {
                // At the top of the page
                header.classList.remove('fixed');
            }
        });
    });
</script>

<script>
    function addToCart(productId) {
        const form = document.getElementById(`buyNowForm${productId}`);
        const formData = new FormData(form);

        const button = document.querySelector(`button[data-product-id="${productId}"]`);
        const productTitle = button.getAttribute('data-product-title');
        const productPrice = button.getAttribute('data-product-price');
        const productImage = button.getAttribute('data-product-image');

        fetch("{{ route('cart.add') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                toastr.success(data.message);
                updateCartDropdown();

                // Populate modal
                document.getElementById('modalImage').src = productImage;
                document.getElementById('modalProductTitle').textContent = productTitle;
                document.getElementById('modalProductPrice').textContent = productPrice;

                // Show Bootstrap modal
                const myModal = new bootstrap.Modal(document.getElementById('cartModal'));
                myModal.show();
            })
            .catch(error => {
                console.error("Error adding to cart:", error);
                alert('কার্টে যুক্ত করতে সমস্যা হয়েছে!');
            });
    }
    function updateCartDropdown() {
        $.ajax({
            url: '{{ route('cart.dropdown') }}',
            method: 'GET',
            success: function(response) {
                $('.cart-dropdown').html(response); // Update the cart dropdown HTML
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>


<!-- Plugins JS File -->
<script src="{{asset('/')}}front/assets/js/jquery.min.js"></script>
<script src="{{asset('/')}}front/assets/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('/')}}front/assets/js/jquery.hoverIntent.min.js"></script>
<script src="{{asset('/')}}front/assets/js/jquery.waypoints.min.js"></script>
<script src="{{asset('/')}}front/assets/js/superfish.min.js"></script>
<script src="{{asset('/')}}front/assets/js/bootstrap-input-spinner.js"></script>
<script src="{{asset('/')}}front/assets/js/owl.carousel.min.js"></script>
<script src="{{asset('/')}}front/assets/js/jquery.plugin.min.js"></script>
<script src="{{asset('/')}}front/assets/js/jquery.magnific-popup.min.js"></script>
<script src="{{asset('/')}}front/assets/js/jquery.countdown.min.js"></script>
<!-- Main JS File -->
<script src="{{asset('/')}}front/assets/js/main.js"></script>
<script src="{{asset('/')}}front/assets/js/demos/demo-7.js"></script>

<script src="{{asset('/')}}front/assets/js/jquery.elevateZoom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>

</html>
