@extends('front.master')

@section('title')
    {{$generalSettingView->site_name}} - {{$product->name}}
@endsection

@section('meta_data')
    @php
        // Get the category name from the product (Example: 't-shirt male')
        $categoryName = $product->name;

        // Replace hyphens and spaces with underscores
        $convertedName = str_replace(['-', ' '], '_', $categoryName);
        $discountPrice = $product->sell_price;
        if ($product->discount > 0) {
            if ($product->discount_type == 2) {
                $discountPrice = $product->sell_price - ($product->sell_price * ($product->discount / 100));
            } else {
                $discountPrice = $product->sell_price - $product->discount;
            }
        }
    @endphp
    <meta property="og:title" content="{{$product->name}}">
    <meta property="og:description" content="{{strip_tags($product->description)}}">
    <meta property="og:url" content="{{request()->url()}}">
    <meta property="og:image" content="{{asset($product->thumbnail_img)}}">
    <meta property="product:brand" content="{{$product->brand->name ?? 'Dreamynightwear' }}">
    @if($product->stock != 0)
        <meta property="product:availability" content="in stock">
    @else
        <meta property="product:availability" content="Out of stock">
    @endif
    <meta property="product:condition" content="new">
    <meta property="product:price:amount" content="{{$product->sell_price}}">
    @if($product->discount > 0)
    <meta property="product:sale_price:amount" content="{{$discountPrice}}">
    @endif
    <meta property="product:price:currency" content="BDT">
    <meta property="product:retailer_item_id" content="{{$product->id}}">

{{--    <meta property="product:retailer_item_id" content="{{ $convertedName }}_{{$product->id}}">--}}
    <meta property="product:item_group_id" id="variantName" content="{{ $convertedName }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{request()->url()}}">
@endsection

@section('body')

    <style>
        .size-buttons .btn-size {
            margin: 3px !important; /* Small margin between buttons */
            padding: 5px 10px !important; /* Compact padding */
            font-size: 12px !important; /* Smaller font size */
            max-width: 60px !important; /* Fixed small width */
            text-align: center !important; /* Center-align text */
            border: 1px solid #ddd !important; /* Border for visibility */
            border-radius: 3px !important; /* Rounded corners */
            background-color: #f9f9f9 !important; /* Light background */
            cursor: pointer !important; /* Pointer cursor */
            transition: all 0.3s ease !important; /* Smooth hover effect */
        }

        .size-buttons .btn-size.active {
            border-color: #c96 !important; /* Highlight active button */
            background-color: #c96 !important; /* Blue background for active */
            color: #fff !important; /* White text for active */
        }

        .size-buttons .btn-size:hover {
            background-color: #c96 !important; /* Blue background on hover */
            color: #fff !important; /* White text on hover */
        }

        .size-buttons {
            display: flex !important; /* Arrange buttons in a row */
            flex-wrap: wrap !important; /* Allow wrapping if there are many buttons */
            gap: 5px !important; /* Add spacing between buttons */
        }
        @media only screen and (max-width: 767px) {
            .mobile-sticky-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: #fff;
                z-index: 9999;
                padding: 10px;
                box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
                border-top: 1px solid #eee;
            }

            .mobile-sticky-footer form,
            .mobile-sticky-footer .details-action-wrapper {
                flex-direction: row;
                justify-content: space-between;
                gap: 10px;
            }

            .mobile-sticky-footer .btn-product {
                flex: 1;
                text-align: center;
            }
        }
    </style>

    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('category.product', ['id' => $product->category_id])}}">{{$product->category->category_name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <style>
        /* Hide desktop content on small screens */
        .desktop-view {
            display: none;
        }

        /* Show desktop content on screens larger than 768px */
        @media (min-width: 768px) {
            .desktop-view {
                display: block;
            }
            .mobile-view {
                display: none;
            }
        }
    </style>

    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <!-- Mobile Version -->
                    <div class="col-md-6 mobile-view">
                        <div class="product-gallery product-gallery-vertical">
                            <figure class="product-main-image">
                                <img src="{{ asset($product->thumbnail_img) }}" data-zoom-image="{{ asset($product->thumbnail_img) }}" alt="product image">

{{--                                <a href="#" id="btn-product-gallery" class="btn-product-gallery">--}}
{{--                                    <i class="icon-arrows"></i>--}}
{{--                                </a>--}}
                            </figure><!-- End .product-main-image -->

                            <div class="product-image-gallery">
                                <a class="product-gallery-item zoom-image" href="#"
                                   data-image="{{ asset($product->thumbnail_img) }}"
                                   data-zoom-image="{{ asset($product->thumbnail_img) }}">
                                    <img src="{{ asset($product->thumbnail_img) }}" alt="product side">
                                </a>
                                @if($product->variants->where('color_id', '!=', null)->unique('color_id')->count() > 0)
                                    @foreach($product->variants->where('color_id', '!=', null)->unique('color_id') as $variantImage)
                                        @if ($variantImage->image !== $product->thumbnail_img)
                                            <a class="product-gallery-item zoom-image" href="#" data-image="{{ asset($variantImage->image) }}" data-zoom-image="{{ asset($variantImage->image) }}">
                                                <img src="{{ asset($variantImage->image) }}" alt="product side">
                                            </a>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach($product->otherImages as $otherImage)
                                        @if ($otherImage->gellery_image !== $product->thumbnail_img)
                                            <a class="product-gallery-item zoom-image" href="#"
                                               data-image="{{ asset($otherImage->gellery_image) }}"
                                               data-zoom-image="{{ asset($otherImage->gellery_image) }}">
                                                <img src="{{ asset($otherImage->gellery_image) }}" alt="product side">
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div><!-- End .product-image-gallery -->
                        </div><!-- End .product-gallery -->

                        <!-- Add jQuery -->
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                        <!-- Add Script -->
                        <script>
                            $(document).ready(function () {
                                // Listen for clicks on gallery items
                                $('.zoom-image').on('click', function (e) {
                                    e.preventDefault();

                                    // Get the clicked image's data attributes
                                    let newImage = $(this).data('image');         // Image URL for the main display
                                    let zoomImage = $(this).data('zoom-image');   // Image URL for zoom effect

                                    // Update the main image and its zoom image
                                    $('.product-main-image img').attr('src', newImage);
                                    $('.product-main-image img').attr('data-zoom-image', zoomImage);

                                    // Remove "active" class from all gallery items
                                    $('.zoom-image').removeClass('active');

                                    // Add "active" class to the clicked item
                                    $(this).addClass('active');
                                });
                            });
                        </script>
                    </div><!-- End .col-md-6 -->

                    <!-- Desktop Version -->
                    <div class="col-md-6 desktop-view">
                        <div class="product-gallery product-gallery-vertical">
                            <figure class="product-main-image">
                                <img id="product-zoom" src="{{ asset($product->thumbnail_img) }}" data-zoom-image="{{ asset($product->thumbnail_img) }}" alt="product image">

                                <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                    <i class="icon-arrows"></i>
                                </a>
                            </figure><!-- End .product-main-image -->

                            <div id="product-zoom-gallery" class="product-image-gallery">
                                <a class="product-gallery-item" style="max-width: 20% !important;" href="#" data-image="{{ asset($product->thumbnail_img) }}" data-zoom-image="{{ asset($product->thumbnail_img) }}">
                                    <img src="{{ asset($product->thumbnail_img) }}" alt="product side">
                                </a>
                                @if($product->variants->where('color_id', '!=', null)->unique('color_id')->count() > 0)
                                    @foreach($product->variants->where('color_id', '!=', null)->unique('color_id') as $variantImage)
                                        @if ($variantImage->image !== $product->thumbnail_img)
                                            <a class="product-gallery-item zoom-image" style="max-width: 20% !important;" href="#" data-image="{{ asset($variantImage->image) }}" data-zoom-image="{{ asset($variantImage->image) }}">
                                                <img src="{{ asset($variantImage->image) }}" alt="product side">
                                            </a>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach($product->otherImages as $otherImage)
                                        @if ($otherImage->gellery_image !== $product->thumbnail_img)
                                            <a class="product-gallery-item" style="max-width: 20% !important;" href="#" data-image="{{ asset($otherImage->gellery_image) }}" data-zoom-image="{{ asset($otherImage->gellery_image) }}">
                                                <img src="{{ asset($otherImage->gellery_image) }}" alt="product side">
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div><!-- End .product-image-gallery -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <div class="product-details">
                            <h1 class="product-title-show" style="font-size: 2.6rem;">{{$product->name}}</h1><!-- End .product-title -->

                            <div class="product-price">
                                <span class="new-price">&#2547;{{ number_format(discounted_price($product), 2) }}</span>

                                @if(discounted_active($product))
                                    <span class="old-price" id="discountWithoutPrice">&#2547;{{ number_format($product->sell_price, 2) }}</span>
                                @endif
                            </div><!-- End .product-price -->

{{--                            @if($product->is_short_description == 1)--}}
{{--                                <div class="product-content">--}}
{{--                                    <p>{!! \Illuminate\Support\Str::limit(strip_tags($product->short_description), 300) !!}</p>--}}
{{--                                </div><!-- End .product-content -->--}}
{{--                            @endif--}}

                            @if($product->is_variant == 1)
                                @if($product->variants->where('color_id', '!=', null)->unique('color_id')->count() > 0)
                                    <div class="details-filter-row details-row-size" style="margin-bottom: 1%!important;">
                                        <label>Select Color:</label>
                                        <div class="product-nav product-nav-thumbs">
                                            @foreach($product->variants->where('color_id', '!=', null)->unique('color_id') as $variant)
                                                <a class="zoom-image btn-color {{ $loop->first ? '' : '' }}"
                                                   data-color-id="{{ $variant->color_id }}" href="#"
                                                   data-image="{{ asset($variant->image) }}"
                                                   data-zoom-image="{{ asset($variant->image) }}"
                                                   data-price="{{$variant->price}}"
                                                   data-variant="{{$variant->variant}}"
                                                   data-quantity="{{$variant->qty}}"
                                                   data-discount="{{$variant->discount}}"
                                                   data-discount-type="{{$variant->discount_type}}"
                                                >
{{--                                                    <img src="{{ asset($variant->image) }}" alt="product side">--}}
                                                    <div style=" background-color: {{$variant->color->color_code}}; height: 100%; width: 100%;"></div>
                                                </a>
                                            @endforeach
                                        </div><!-- End .product-nav -->
                                    </div><!-- End .details-filter-row -->
                                    <div class="details-filter-row details-row-size" style="margin-bottom: 0 !important;">
                                        <label></label>
                                        <div id="colorError" class="error-message" style="color: red; display: none;">Please select a color.<i class="fa fa-arrow-up"></i> </div>
                                    </div>
                                @endif

                                @if($product->variants->where('size_id', '!=', null)->unique('size_id')->count() > 0)
                                <div class="details-filter-row details-row-size" style="margin-bottom: 0 !important;">
                                    <label>Select Size:</label>
                                    <div class="size-buttons">
                                        @foreach($product->variants->where('size_id', '!=', null)->unique('size_id') as $variant)
                                            <button
                                                type="button"
                                                class="btn-size"
                                                data-size-id="{{$variant->size_id}}"
                                                data-price="{{$variant->price}}"
                                                data-variant="{{$variant->variant}}"
                                                data-quantity="{{$variant->qty}}"
                                                data-discount="{{$variant->discount}}"
                                                data-discount-type="{{$variant->discount_type}}">
                                                {{$variant->size->name}}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="details-filter-row details-row-size">
                                    <label></label>
                                    <div id="sizeError" class="error-message" style="color: red; display: none;">Please select a size.<i class="fa fa-arrow-up"></i> </div>
                                </div>
                                @endif
                            @else

                            @endif

                            <div class="details-filter-row details-row-size">
                                <label for="qty">QTY:</label>
                                <div class="product-details-quantity">
                                    <input type="number"
                                           id="qty"
                                           class="form-control qtyValue"
                                           value="{{ $product->minimum_purchase_qty }}"
                                           min="{{ $product->minimum_purchase_qty }}"
                                           max="{{ $product->stock }}"
                                           step="1"
                                           data-decimals="0"
                                           inputmode="numeric"
                                           required readonly>
                                </div><!-- End .product-details-quantity -->

                                <!-- Message & WhatsApp button after Qty -->
                                <div style="margin-top: 10px; background-color: #e6f7ff; border-left: 5px solid #00b7c9; padding: 10px; border-radius: 5px;">
                                    <p style="margin: 0; font-family: 'Hind Siliguri', sans-serif; font-weight: 700; font-style: normal; color: #333;font-size: 1.7rem;">
                                        🔰 Confirm your order without any advance payment.
                                    </p>
                                </div>

                                <!-- WhatsApp Contact Button -->
                                <div class="text-center my-3">
                                    <a href="https://wa.me/{{ $generalSettingView->pinterest_url }}?text={{ urlencode('I am interested in this product: ' . route('product.show', ['id' => $product->id, 'slug' => $product->slug])) }}"
                                       target="_blank"
                                       class="btn-product d-inline-block"
                                       style="background-color: #25D366; color: white; line-height: 2; padding: 0.75rem 1.5rem; border-radius: 0.25rem; text-decoration: none;">
                                        <i class="fab fa-whatsapp"></i> Order on WhatsApp &nbsp;<span>{{ $generalSettingView->pinterest_url }}</span>
                                    </a>
                                </div>

                                <div class="product-details-action mobile-sticky-footer" style="margin-bottom: 0 !important; display: block">
                                    <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="{{$product->minimum_purchase_qty}}" id="productQuantity">
                                        <input type="hidden" name="size" value="" id="productSize">
                                        <input type="hidden" name="price" value="{{discounted_price($product)}}" id="productPrice">
                                        <input type="hidden" name="discount" value="{{$product->discount}}" id="discountProduct">
                                        <input type="hidden" name="discountType" value="{{$product->discount_type}}" id="discountType">
                                        <input type="hidden" name="color" value="" id="productColor">
                                        <input type="hidden" name="thumbnail_image" id="productThumbnailImage" value="{{ asset($product->thumbnail_img) }}">

                                        <div id="inStock" style="display: block;">
                                            @if($product->stock != 0)
                                                <div class="details-action-wrapper" style="gap: 5%">
                                                    <button type="button" id="addToCartBtn" class="btn btn-sm" style="min-width: 0;height: 50px; color: white; background-color: #00b7c9">
                                                        <i class="fa fa-cart-plus"></i><span>Add to Cart</span>
                                                    </button>
                                                    <button type="submit" id="addToBuyBtn" name="button" value="2" class="btn-product" style="height: 50px; text-decoration: none; color: white; background-color: #f89104; border: none">
                                                        <i class="fa fa-bolt"></i><span class="text-white">&nbsp;Buy Now</span>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="details-action-wrapper">
                                                    <button type="button" disabled class="btn-product btn-danger btn-cart" style="line-height: 2 !important; min-width: auto !important;">
                                                        <span>Out of Stock</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>

                                        <div style="display: none;" id="outStock">
                                            <div class="details-action-wrapper">
                                                <button type="button" disabled class="btn-product btn-danger btn-cart" style="line-height: 2 !important; min-width: auto !important;">
                                                    <span>Out of Stock</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="details-action-wrapper d-flex justify-content-end" style="margin-top: 10px;">
                                        <a href="tel:{{$generalSettingView->mobile}}"
                                        target="_blank"
                                        class="btn-product"
                                        style="background-color: #565656; color: #ffffff; line-height: 2 !important; padding: 0.75rem 1.5rem; border-radius: 0.25rem;text-decoration: none">
                                            Call Now &nbsp; <span style="color: #f89104"><i class="fa fa-phone"></i> &nbsp; {{$generalSettingView->mobile}}</span>
                                        </a>
                                    </div>
                                </div>

                            </div><!-- End .details-filter-row -->
                            <!-- End .product-details-action -->
                            <!-- Add this inside your Blade or HTML file -->

                            <style>
                                .tab-scroll-wrapper {
                                    overflow-x: auto;
                                    -ms-overflow-style: none; /* IE and Edge */
                                    scrollbar-width: none;    /* Firefox */
                                }

                                .tab-scroll-wrapper::-webkit-scrollbar {
                                    display: none; /* Chrome, Safari */
                                }

                                .nav-pills {
                                    white-space: nowrap;
                                    flex-wrap: nowrap;
                                }

                                .nav-item {
                                    display: inline-block;
                                    margin-right: 10px;
                                }

                                .nav-link {
                                    border-radius: 0;
                                    border-bottom: 2px solid transparent;
                                    color: #333;
                                }

                                .nav-link.active {
                                    border-bottom: 2px solid #2ECC71; /* Or your primary color */
                                    color: #2ECC71;
                                }

                                .product-desc-content p {
                                    margin-bottom: 1rem;
                                }
                            </style>

                            <div class="product-desc-content">
                                <div class="product-details-tab">
                                    <!-- Tab Navigation -->
                                    <div class="tab-scroll-wrapper">
                                        <ul class="nav nav-pills justify-content-start px-3" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Ingredients</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">How To Use</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Tab Content -->
                                    <div class="tab-content px-3 pt-3">
                                        <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                                            <div class="product-desc-content">
                                                <p>{!! $product->description !!}</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                                            <div class="product-desc-content">
                                                <p>{!! $product->ingredients !!}</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                                            <div class="product-desc-content">
                                                <p>{!! $product->how_to_use !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    @if($product->category->parentCategory)
                                        <a href="{{ route('category.product', ['id' => $product->category->parentCategory->id]) }}">
                                            {{ $product->category->parentCategory->category_name }}
                                        </a>,
                                        <a href="{{ route('category.product', ['id' => $product->category->id]) }}">
                                            {{ $product->category->category_name }}
                                        </a>
                                    @else
                                        <a href="{{ route('category.product', ['id' => $product->category->id]) }}">
                                            {{ $product->category->category_name }}
                                        </a>
                                    @endif
                                </div><!-- End .product-cat -->

                                <div class="social-icons social-icons-sm">
                                    <span class="social-label">Share:</span>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('product.show', ['id' => $product->id, 'slug' => $product->slug]) }}"
                                    class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>

                                    <a href="https://twitter.com/intent/tweet?url={{ route('product.show', ['id' => $product->id, 'slug' => $product->slug]) }}&text={{ urlencode($product->name) }}"
                                    class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>

                                    <a href="https://www.linkedin.com/shareArticle?url={{ route('product.show', ['id' => $product->id, 'slug' => $product->slug]) }}"
                                    class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>

                                    <a href="#" class="social-icon" title="WhatsApp" onclick="openWhatsApp()" target="_blank"><i class="icon-whatsapp"></i></a>
                                </div>

                                <!-- Hidden input to store the converted name -->
                                <input type="hidden" id="convertedName" value="{{ $convertedName }}">
                                <input type="hidden" id="productID" value="{{ $product->id }}">

                                <!-- Optional output display (commented out) -->
                                {{-- <div id="combinedNameDisplay"></div> --}}
                                {{-- <p>Group ID: {{ $convertedName }}</p> --}}
                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                    <!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

            <h2 class="title text-center mb-4">Releted Products</h2><!-- End .title text-center -->
            <div class="products mb-3">
                <div class="row justify-content-center">
                    @foreach($relatedProducts as $category_product)
                        <div class="col-6 col-md-2 col-lg-2 col-xl-2"> <!-- Changed from col-6, col-md-4, col-lg-4, col-xl-3 to col-2 -->
                            <div class="product product-7 text-center">
                                <figure class="product-media">
                                    @php
                                        $isNew = \Carbon\Carbon::parse($category_product->created_at)->gt(\Carbon\Carbon::now()->subDays(10));
                                    @endphp

                                    @if($isNew)
                                        <span class="product-label label-new">New</span>
                                    @endif

                                    <a href="{{route('product.show', ['id' => $category_product->id, 'slug' => $category_product->slug])}}">
                                        <img src="{{asset($category_product->thumbnail_img)}}" alt="Product image" class="product-image">
                                    </a>
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    {{-- <div class="product-cat">
                                        <a href="{{route('category.product', ['id' => $category_product->category_id])}}">{{$category_product->category->category_name}}</a>
                                    </div><!-- End .product-cat --> --}}
                                    <h3 class="product-title">
                                        <a href="{{route('product.show', ['id' => $category_product->id, 'slug' => $category_product->slug])}}">{{\Illuminate\Support\Str::limit($category_product->name, 40)}}</a></h3><!-- End .product-title -->
                                    <div class="product-price">
                                        <span class="new-price">&#2547;{{ number_format(discounted_price($category_product), 2) }}</span>

                                        @if(discounted_active($category_product))
                                            <span class="old-price">&#2547;{{ number_format(discounted_price($category_product), 2) }}</span>
                                        @endif
                                    </div><!-- End .product-price -->
                                    <div class="ratings-container mt-2">
                                        <div class="d-flex w-100 " style="gap: 5%">
                                            @if(isset($category_product->variants) && $category_product->variants->isNotEmpty())
                                                <a href="{{route('product.show', ['id' => $category_product->id, 'slug' => $category_product->slug])}}" class="btn-outline-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 38px; border: #cc9966; background-color: whitesmoke">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </a>

                                                <a href="{{route('product.show', ['id' => $category_product->id, 'slug' => $category_product->slug])}}"
                                                   class=" btn-primary text-white d-flex justify-content-center align-items-center flex-fill" style="height: 38px;color: white; background-color: #f89104;">
                                                    <i class="fa fa-bolt"></i><span class="text-white">&nbsp;Order Now</span>
                                                </a>
                                            @else
                                                <form id="buyNowForm{{ $category_product->id }}" action="{{ route('cart.add') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $category_product->id }}">
                                                    <input type="hidden" name="quantity" value="{{ $category_product->minimum_purchase_qty }}">
                                                    <input type="hidden" name="price" value="{{ discounted_price($category_product) }}">
                                                    <input type="hidden" name="discount" value="{{ $category_product->discount }}">
                                                    <input type="hidden" name="discountType" value="{{ $category_product->discount_type }}">
                                                    <input type="hidden" name="thumbnail_image" value="{{ asset($category_product->thumbnail_img) }}">

                                                    <!-- Hidden button value field -->
                                                    <input type="hidden" name="button" id="submitButtonValue{{ $category_product->id }}">
                                                </form>
                                                <button type="button"
                                                        onclick="addToCart({{ $category_product->id }})"
                                                        data-product-id="{{ $category_product->id }}"
                                                        data-product-title="{{ $category_product->name }}"
                                                        data-product-price="{{ discounted_price($category_product) }}"
                                                        data-product-image="{{ asset($category_product->thumbnail_img) }}"
                                                        class="btn-outline-primary d-flex align-items-center justify-content-center me-2"
                                                        style="width: 42px; height: 38px; border: 0px; background-color: whitesmoke;">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </button>

                                                <a href="javascript:void(0);"
                                                   onclick="
                                                       document.getElementById('submitButtonValue{{ $category_product->id }}').value = '2';
                                                       document.getElementById('buyNowForm{{ $category_product->id }}').submit();
                                                       "
                                                   class="btn-primary text-white d-flex justify-content-center align-items-center flex-fill"
                                                   style="height: 38px;color: white; background-color: #f89104;">
                                                    <i class="fa fa-bolt"></i><span class="text-white">&nbsp;Order Now</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="ratings">--}}
{{--                                            <div class="ratings-val" style="width: 100%;"></div><!-- End .ratings-val -->--}}
{{--                                        </div><!-- End .ratings -->--}}
{{--                                        <span class="ratings-text">( 2 Reviews )</span>--}}
{{--                                    </div><!-- End .rating-container -->--}}
                                </div><!-- End .product-body -->
                            </div><!-- End .product -->
                        </div><!-- End .col-2 -->
                    @endforeach
                </div><!-- End .row -->
            </div><!-- End .products -->

            <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
            <div class="products mb-3">
                <div class="row justify-content-center">
                    @foreach($featuredProducts as $featuredProduct)
                        <div class="col-6 col-md-2 col-lg-2 col-xl-2"> <!-- Changed from col-6, col-md-4, col-lg-4, col-xl-3 to col-2 -->
                            <div class="product product-7 text-center">
                                <figure class="product-media">
                                    @php
                                        $isNew = \Carbon\Carbon::parse($featuredProduct->created_at)->gt(\Carbon\Carbon::now()->subDays(10));
                                    @endphp

                                    @if($isNew)
                                        <span class="product-label label-new">New</span>
                                    @endif

                                    <a href="{{route('product.show', ['id' => $featuredProduct->id, 'slug' => $featuredProduct->slug])}}">
                                        <img src="{{asset($featuredProduct->thumbnail_img)}}" alt="Product image" class="product-image">
                                    </a>
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    {{-- <div class="product-cat">
                                        <a href="{{route('category.product', ['id' => $featuredProduct->category_id])}}">{{$featuredProduct->category->category_name}}</a>
                                    </div><!-- End .product-cat --> --}}
                                    <h3 class="product-title">
                                        <a href="{{route('product.show', ['id' => $featuredProduct->id, 'slug' => $featuredProduct->slug])}}">{{\Illuminate\Support\Str::limit($featuredProduct->name, 40)}}</a></h3><!-- End .product-title -->
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
                                                   class=" btn-primary text-white d-flex justify-content-center align-items-center flex-fill" style="height: 38px;color: white; background-color: #f89104;">
                                                    <i class="fa fa-bolt"></i><span class="text-white">&nbsp;Order Now</span>
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
                                                   style="height: 38px;color: white; background-color: #f89104;">
                                                    <i class="fa fa-bolt"></i><span class="text-white">&nbsp;Order Now</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="ratings">--}}
{{--                                            <div class="ratings-val" style="width: 100%;"></div><!-- End .ratings-val -->--}}
{{--                                        </div><!-- End .ratings -->--}}
{{--                                        <span class="ratings-text">( 2 Reviews )</span>--}}
{{--                                    </div><!-- End .rating-container -->--}}
                                </div><!-- End .product-body -->
                            </div><!-- End .product -->
                        </div><!-- End .col-2 -->
                    @endforeach
                </div><!-- End .row -->
            </div><!-- End .products -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->



    <script>
        function openWhatsApp() {
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

            if (isMobile) {
                const encodedTitle = encodeURIComponent("{{ $product->name }}");
                const encodedUrl = encodeURIComponent("{{ route('product.show', ['id' => $product->id, 'slug'=>$product->slug]) }}");
                const whatsappUrl = `whatsapp://send?text=${encodedTitle} - ${encodedUrl}`;

                window.location.href = whatsappUrl; // Open in WhatsApp app directly
            } else {
                const encodedTitle = encodeURIComponent("{{ $product->name }}");
                const encodedUrl = encodeURIComponent("{{ route('product.show', ['id' => $product->id, 'slug'=>$product->slug]) }}");
                const whatsappUrl = `https://web.whatsapp.com/send?text=${encodedTitle} - ${encodedUrl}`;

                // Adjust the width and height of the popup window as per your requirement
                const popupWidth = 800;
                const popupHeight = 400;
                const left = (screen.width - popupWidth) / 2;
                const top = (screen.height - popupHeight) / 2;
                const popupOptions = `width=${popupWidth},height=${popupHeight},left=${left},top=${top},scrollbars=yes`;

                window.open(whatsappUrl, '_blank', popupOptions); // Open in popup window
            }
        }
    </script>


    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            var addToCartBtn = document.getElementById('addToCartBtn');

            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function () {
                    @if($product->variants->where('size_id', '!=', null)->unique('size_id')->count() > 0)
                    if (!validateSizeSelection()) return;
                    @endif
                    @if($product->variants->where('color_id', '!=', null)->unique('color_id')->count() > 0)
                    if (!validateColorSelection()) return;
                    @endif

                    // Assuming `productData` is available and holds the product information
                    var productData = {
                        name: "{{ $product->name }}",
                        id: "{{ $product->id }}",
                        price: parseFloat("{{ discounted_price($product) }}"),
                        brand: {
                            name: "{{ $product->brand->name ?? '' }}"
                        },
                        category: {
                            category_name: "{{ $product->category->category_name ?? '' }}"
                        },
                        subCategory: {
                            category_name: "{{ $product->subCategory->category_name ?? '' }}"
                        },
                        stock: parseInt("{{ $product->stock }}", 10)
                    };

                    addToCartData(productData);
                });
            }
        });

        // Function to push data to the dataLayer
        function addToCartData(data) {
            console.log('Product data:', data);

            dataLayer.push({ ecommerce: null }); // Clear the previous ecommerce object.
            dataLayer.push({
                event: "add_to_cart",
                ecommerce: {
                    currency: "BDT",
                    value: data.price, // Use the fetched or calculated cart total here
                    items: [{
                        item_name: data.name, // Name or ID is required.
                        item_id: data.id,
                        price: data.price,
                        item_brand: data.brand?.name || "",
                        item_category: data.category?.category_name || "",
                        item_category2: data.subCategory?.category_name || "",
                        item_variant: "",
                        quantity: 1 // Assuming a quantity of 1
                    }]
                }
            });
        }
    </script>



    <script>
        dataLayer.push({ ecommerce: null }); // Clear the previous ecommerce object.
        dataLayer.push({
            event : "view_item",
            ecommerce: {
                currency: "BDT",
                value: {{discounted_price($product)}},
                items: [{
                    item_name : "{{$product->name}}", // Name or ID is required.
                    item_id : {{$product->id}},
                    price : {{$product->sell_price}},
                    item_brand : "{{$product->brand->name ?? ""}}",
                    item_category : "{{$product->category->category_name ?? ""}}",
                    item_category2 : "{{$product->subCategory->category_name ?? ""}}",
                    item_category3: "",
                    item_category4: "",
                    item_variant : "",
                    item_group_id: "",  // Unique group ID for this product line
                    retailer_item_id: "",  // Unique retailer item ID for the Small variant
                    item_list_name: "", // If associated with a list selection.
                    item_list_id : "", // If associated with a list selection.
                    index : 0, // If associated with a list selection.
                    quantity : {{$product->stock}},
                }]
            }
        });
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ensure no button is selected by default
            document.querySelectorAll('.btn-size').forEach(button => {
                button.classList.remove('active'); // Remove active class from all buttons
            });
            document.querySelectorAll('.product-nav-thumbs a').forEach(function(el) {
                el.classList.remove('active');
            });
        });

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

        @if($product->variants->where('size_id', '!=', null)->unique('size_id')->count() > 0)
        document.querySelectorAll('.btn-size').forEach(button => {
            button.addEventListener('click', function() {
                // Toggle the active class when a size button is clicked
                document.querySelectorAll('.btn-size').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('productSize').value = this.getAttribute('data-size-id');

                const basePrice = parseFloat(this.dataset.price);
                const discount = parseFloat(this.dataset.discount);
                const variantName = this.dataset.variant;
                const discountType = this.dataset.discountType;
                const variantQty = this.dataset.quantity;

                let withoutDiscountPrice = basePrice;
                let finalPrice = basePrice;
                if (discount > 0) {
                    finalPrice = discountType == 2 ? basePrice - (basePrice * (discount / 100)) : basePrice - discount;
                }

                // Update the hidden fields and displayed price
                document.getElementById('productPrice').value = finalPrice.toFixed(2);
                document.getElementById('discountWithoutPrice').textContent =  '৳' + withoutDiscountPrice.toFixed(2);
                document.getElementById('discountProduct').value = discount.toFixed(2);
                document.getElementById('discountType').value = discountType;
                document.querySelector('.new-price').textContent = '৳' + finalPrice.toFixed(2);
                document.getElementById('variantName').value = variantName;

                // Set the max value for qty input based on variant quantity
                const qtyInput = document.getElementById('qty');
                qtyInput.max = variantQty;
                qtyInput.value = Math.min(qtyInput.value, variantQty);

                // Toggle stock status based on variant quantity
                if (variantQty == 0) {
                    document.getElementById('inStock').style.display = 'none';
                    document.getElementById('outStock').style.display = 'block';
                } else {
                    document.getElementById('inStock').style.display = 'block';
                    document.getElementById('outStock').style.display = 'none';
                }

                // Hide size error message if a size has been selected
                document.getElementById('sizeError').style.display = 'none';
                document.getElementById('colorError').style.display = 'none';
            });
        });
        @endif

        @if($product->variants->where('color_id', '!=', null)->where('size_id', null)->unique('color_id')->count() > 0)
        document.querySelectorAll('.btn-color').forEach(button => {
            button.addEventListener('click', function() {
                // Toggle the active class when a size button is clicked
                document.querySelectorAll('.btn-color').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const basePrice = parseFloat(this.dataset.price);
                const discount = parseFloat(this.dataset.discount);
                const variantName = this.dataset.variant;
                const discountType = this.dataset.discountType;
                const variantQty = this.dataset.quantity;

                let withoutDiscountPrice = basePrice;
                let finalPrice = basePrice;
                if (discount > 0) {
                    finalPrice = discountType == 2 ? basePrice - (basePrice * (discount / 100)) : basePrice - discount;
                }

                // Update the hidden fields and displayed price
                document.getElementById('productPrice').value = finalPrice.toFixed(2);
                document.getElementById('discountWithoutPrice').textContent =  '৳' + withoutDiscountPrice.toFixed(2);
                document.getElementById('discountProduct').value = discount.toFixed(2);
                document.getElementById('discountType').value = discountType;
                document.querySelector('.new-price').textContent = '৳' + finalPrice.toFixed(2);
                document.getElementById('variantName').value = variantName;

                // Set the max value for qty input based on variant quantity
                const qtyInput = document.getElementById('qty');
                qtyInput.max = variantQty;
                qtyInput.value = Math.min(qtyInput.value, variantQty);

                // Toggle stock status based on variant quantity
                if (variantQty == 0) {
                    document.getElementById('inStock').style.display = 'none';
                    document.getElementById('outStock').style.display = 'block';
                } else {
                    document.getElementById('inStock').style.display = 'block';
                    document.getElementById('outStock').style.display = 'none';
                }

                // Hide size error message if a size has been selected
                document.getElementById('sizeError').style.display = 'none';
                document.getElementById('colorError').style.display = 'none';
            });
        });
        @endif

        // Color selection logic
        document.querySelectorAll('.product-nav-thumbs a').forEach(function(element) {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('productColor').value = this.getAttribute('data-color-id');

                document.querySelectorAll('.product-nav-thumbs a').forEach(function(el) {
                    el.classList.remove('active');
                });
                this.classList.add('active');
            });

            document.getElementById('colorError').style.display = 'none';
        });

        // Quantity validation logic
        document.getElementById('qty').addEventListener('input', function () {
            const maxQty = parseInt(this.max);
            let qty = parseInt(this.value);

            if (qty > maxQty) {
                qty = maxQty;
                this.value = qty;
            }

            document.getElementById('productQuantity').value = qty;
        });

        // Reset form after adding to cart
        function resetForm() {
            @if($product->variants->where('size_id', '!=', null)->unique('size_id')->count() > 0)
            document.getElementById('sizeError').style.display = 'none';
            @endif
            @if($product->variants->where('color_id', '!=', null)->unique('color_id')->count() > 0)
            document.getElementById('colorError').style.display = 'none';
            @endif
            document.getElementById('qty').value = {{$product->minimum_purchase_qty}};
            document.getElementById('productPrice').value = '';
            document.getElementById('discountProduct').value = 0;
            document.getElementById('discountType').value = 1;
            document.getElementById('productSize').value = '';
            document.getElementById('productQuantity').value = {{$product->minimum_purchase_qty}};
            document.getElementById('productColor').value = '';
            document.getElementById('productThumbnailImage').value = '{{ asset($product->thumbnail_img) }}';

            document.querySelectorAll('.product-nav-thumbs a').forEach(function(el) {
                el.classList.remove('active');
            });

            document.querySelectorAll('.btn-size').forEach(btn => btn.classList.remove('active'));
            this.classList.remove('active');
        }

        // Validate size selection with focus
        function validateSizeSelection() {
            const size = document.querySelector('.btn-size.active');
            const sizeError = document.getElementById('sizeError');

            if (!size) {
                sizeError.style.display = 'block';

                // Scroll to the size section smoothly
                const sizeContainer = document.querySelector('.size-buttons');
                if (sizeContainer) {
                    sizeContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }

                return false;
            }

            sizeError.style.display = 'none';
            return true;
        }

        // Validate color selection with focus
        function validateColorSelection() {
            const color = document.querySelector('.product-nav-thumbs a.active');
            const colorError = document.getElementById('colorError');

            if (!color) {
                colorError.style.display = 'block';

                // Scroll to the color section smoothly
                const colorContainer = document.querySelector('.product-nav-thumbs');
                if (colorContainer) {
                    colorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }

                return false;
            }

            colorError.style.display = 'none';
            return true;
        }


        // Add to cart logic
        document.getElementById('addToCartBtn').addEventListener('click', function () {
            @if($product->variants->where('size_id', '!=', null)->unique('size_id')->count() > 0)
            if (!validateSizeSelection()) return;
            @endif
            @if($product->variants->where('color_id', '!=', null)->unique('color_id')->count() > 0)
            if (!validateColorSelection()) return;
            @endif

            // Submit the form via AJAX request
            const formData = new FormData(document.getElementById('addToCartForm'));

            $.ajax({
                url: '{{ route('cart.add') }}', // Update with your route
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // Show success notification
                    toastr.success(response.message);
                    updateCartDropdown();

                    // Populate modal data
                    document.getElementById('modalImage').src = document.getElementById('productThumbnailImage').value; // Product image
                    document.getElementById('modalProductTitle').textContent = '{{ $product->name }}'; // Product title
                    document.getElementById('modalProductPrice').textContent = document.getElementById('productPrice').value; // Product price

                    // Show Bootstrap modal
                    const myModal = new bootstrap.Modal(document.getElementById('cartModal'));
                    myModal.show();

                    // Reset form
                    resetForm();
                },
                error: function (error) {
                    toastr.error('Error adding product to cart.');
                }
            });
        });


        document.getElementById("addToBuyBtn").addEventListener("click", function(event) {
            let isValid = true;

            @if($product->variants->where('size_id', '!=', null)->unique('size_id')->count() > 0)
            if (!validateSizeSelection()) {
                isValid = false;
            }
            @endif

                @if($product->variants->where('color_id', '!=', null)->unique('color_id')->count() > 0)
            if (!validateColorSelection()) {
                isValid = false;
            }
            @endif

            if (!isValid) {
                event.preventDefault(); // Prevent form submission
            }
        });



        // Close Modal
        document.getElementById('closeModal').addEventListener('click', function () {
            document.getElementById('cartModal').style.display = 'none';
            document.getElementById('modalOverlay').style.display = 'none';
        });
        // Close Modal
        document.getElementById('closeModalBack').addEventListener('click', function () {
            document.getElementById('cartModal').style.display = 'none';
            document.getElementById('modalOverlay').style.display = 'none';
        });

        document.getElementById('modalOverlay').addEventListener('click', function () {
            document.getElementById('cartModal').style.display = 'none';
            document.getElementById('modalOverlay').style.display = 'none';
        });


        // Prevent submitting if no size is selected
        document.querySelector('button[name="button"][value="2"]').addEventListener('click', function (e) {
            @if($product->variants->where('size_id', '!=', null)->unique('size_id')->count() > 0)
            if (!validateSizeSelection()) {
                e.preventDefault();
            }
            @endif
            @if($product->variants->where('color_id', '!=', null)->unique('color_id')->count() > 0)
            if (!validateColorSelection()) {
                e.preventDefault();
            }
            @endif
        });
    </script>



@endsection
