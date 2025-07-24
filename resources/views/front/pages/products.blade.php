@extends('front.master')

@section('title')
{{$generalSettingView->site_name}} - All Products
@endsection

@section('body')
    <div class="page-header text-center" style="background-image: url('{{asset('/')}}front/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">All Products</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Products</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="toolbox">
                        <div class="toolbox-left">
                            <div class="toolbox-info">
                                Showing <span>{{ $products->firstItem() }} - {{ $products->lastItem() }}</span> of
                                  <span>{{ $products->total() }}</span> Products
                            </div><!-- End .toolbox-info -->
                        </div><!-- End .toolbox-left -->

                        <div class="toolbox-right">
                            <div class="toolbox-sort">
                                <label for="sortby">Sort by:</label>
                                <div class="select-custom">
                                    <select name="sortby" id="sortby" class="form-control">
                                        <option value="popularity">Most Popular</option>
                                        <option value="date" selected="selected">Date</option>
                                    </select>
                                </div>
                            </div><!-- End .toolbox-sort -->
{{--                            <div class="toolbox-layout">--}}
{{--                                <a href="category-list.html" class="btn-layout">--}}
{{--                                    <svg width="16" height="10">--}}
{{--                                        <rect x="0" y="0" width="4" height="4" />--}}
{{--                                        <rect x="6" y="0" width="10" height="4" />--}}
{{--                                        <rect x="0" y="6" width="4" height="4" />--}}
{{--                                        <rect x="6" y="6" width="10" height="4" />--}}
{{--                                    </svg>--}}
{{--                                </a>--}}

{{--                                <a href="category-2cols.html" class="btn-layout">--}}
{{--                                    <svg width="10" height="10">--}}
{{--                                        <rect x="0" y="0" width="4" height="4" />--}}
{{--                                        <rect x="6" y="0" width="4" height="4" />--}}
{{--                                        <rect x="0" y="6" width="4" height="4" />--}}
{{--                                        <rect x="6" y="6" width="4" height="4" />--}}
{{--                                    </svg>--}}
{{--                                </a>--}}

{{--                                <a href="category.html" class="btn-layout">--}}
{{--                                    <svg width="16" height="10">--}}
{{--                                        <rect x="0" y="0" width="4" height="4" />--}}
{{--                                        <rect x="6" y="0" width="4" height="4" />--}}
{{--                                        <rect x="12" y="0" width="4" height="4" />--}}
{{--                                        <rect x="0" y="6" width="4" height="4" />--}}
{{--                                        <rect x="6" y="6" width="4" height="4" />--}}
{{--                                        <rect x="12" y="6" width="4" height="4" />--}}
{{--                                    </svg>--}}
{{--                                </a>--}}

{{--                                <a href="category-4cols.html" class="btn-layout active">--}}
{{--                                    <svg width="22" height="10">--}}
{{--                                        <rect x="0" y="0" width="4" height="4" />--}}
{{--                                        <rect x="6" y="0" width="4" height="4" />--}}
{{--                                        <rect x="12" y="0" width="4" height="4" />--}}
{{--                                        <rect x="18" y="0" width="4" height="4" />--}}
{{--                                        <rect x="0" y="6" width="4" height="4" />--}}
{{--                                        <rect x="6" y="6" width="4" height="4" />--}}
{{--                                        <rect x="12" y="6" width="4" height="4" />--}}
{{--                                        <rect x="18" y="6" width="4" height="4" />--}}
{{--                                    </svg>--}}
{{--                                </a>--}}
{{--                            </div><!-- End .toolbox-layout -->--}}
                        </div><!-- End .toolbox-right -->
                    </div><!-- End .toolbox -->

                    <div class="products mb-3">
                        <div class="row justify-content-center">
                            @foreach($products as $product)
                                <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                                    <div class="product product-7 text-center">
                                        <figure class="product-media">
                                            @php
                                                $isNew = \Carbon\Carbon::parse($product->created_at)->gt(\Carbon\Carbon::now()->subDays(10));
                                            @endphp

                                            @if($isNew)
                                                <span class="product-label label-new">New</span>
                                            @endif

                                            <a href="{{route('product.show', ['id' => $product->id, 'slug' => $product->slug])}}">
                                                <img src="{{asset($product->thumbnail_img)}}" alt="Product image" class="product-image">
                                            </a>
                                        </figure><!-- End .product-media -->

                                        <div class="product-body">
                                            {{-- <div class="product-cat">
                                                <a href="{{route('category.product', ['id' => $product->category_id])}}">{{$product->category->category_name}}</a>
                                            </div><!-- End .product-cat --> --}}
                                            <h3 class="product-title">
                                                <a href="{{route('product.show', ['id' => $product->id, 'slug' => $product->slug])}}">{{\Illuminate\Support\Str::limit($product->name, 40)}}</a>
                                            </h3><!-- End .product-title -->
                                            <div class="product-price">
                                                @php
                                                    $newPrice = $product->sell_price;

                                                    if ($product->discount > 0) {
                                                        if ($product->discount_type == 2) {
                                                            $newPrice = $product->sell_price - ($product->sell_price * ($product->discount / 100));
                                                        } else {
                                                            $newPrice = $product->sell_price - $product->discount;
                                                        }
                                                    }
                                                @endphp
                                                <span class="new-price">&#2547;{{ number_format($newPrice, 2) }}</span>

                                                @if($product->discount > 0)
                                                    <span class="old-price">&#2547;{{ number_format($product->sell_price, 2) }}</span>
                                                @endif
                                            </div><!-- End .product-price -->
                                            <div class="ratings-container mt-2">
                                                <div class="d-flex w-100 " style="gap: 5%">
                                                    @if(isset($product->variants) && $product->variants->isNotEmpty())
                                                        <a href="{{route('product.show', ['id' => $product->id, 'slug' => $product->slug])}}" class="btn-outline-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 38px; border: #cc9966; background-color: whitesmoke">
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </a>

                                                        <a href="{{route('product.show', ['id' => $product->id, 'slug' => $product->slug])}}"
                                                           class=" btn-primary text-white d-flex justify-content-center align-items-center flex-fill" style="height: 38px;color: white; background-color: #f89104;">
                                                            <i class="fa fa-bolt"></i><span class="text-white">&nbsp;Buy Now</span>
                                                        </a>
                                                    @else
                                                        <form id="buyNowForm{{ $product->id }}" action="{{ route('cart.add') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                            <input type="hidden" name="quantity" value="{{ $product->minimum_purchase_qty }}">
                                                            <input type="hidden" name="price" value="{{ discounted_price($product) }}">
                                                            <input type="hidden" name="discount" value="{{ $product->discount }}">
                                                            <input type="hidden" name="discountType" value="{{ $product->discount_type }}">
                                                            <input type="hidden" name="thumbnail_image" value="{{ asset($product->thumbnail_img) }}">

                                                            <!-- Hidden button value field -->
                                                            <input type="hidden" name="button" id="submitButtonValue{{ $product->id }}">
                                                        </form>
                                                        <button type="button"
                                                                onclick="addToCart({{ $product->id }})"
                                                                data-product-id="{{ $product->id }}"
                                                                data-product-title="{{ $product->name }}"
                                                                data-product-price="{{ discounted_price($product) }}"
                                                                data-product-image="{{ asset($product->thumbnail_img) }}"
                                                                class="btn-outline-primary d-flex align-items-center justify-content-center me-2"
                                                                style="width: 42px; height: 38px; border: 0px; background-color: whitesmoke;">
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </button>

                                                        <a href="javascript:void(0);"
                                                           onclick="
                                                               document.getElementById('submitButtonValue{{ $product->id }}').value = '2';
                                                               document.getElementById('buyNowForm{{ $product->id }}').submit();
                                                               "
                                                           class="btn-primary text-white d-flex justify-content-center align-items-center flex-fill"
                                                           style="height: 38px;color: white; background-color: #f89104;">
                                                            <i class="fa fa-bolt"></i><span class="text-white">&nbsp;Buy Now</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            {{--                                            <div class="ratings-container">--}}
{{--                                                <div class="ratings">--}}
{{--                                                    <div class="ratings-val" style="width: 20%;"></div><!-- End .ratings-val -->--}}
{{--                                                </div><!-- End .ratings -->--}}
{{--                                                <span class="ratings-text">( 2 Reviews )</span>--}}
{{--                                            </div><!-- End .rating-container -->--}}
                                        </div><!-- End .product-body -->
                                    </div><!-- End .product -->
                                </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                            @endforeach
                        </div><!-- End .row -->
                    </div><!-- End .products -->


                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <!-- Previous Page Link -->
                            @if ($products->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                        <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                    </a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link page-link-prev" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                    </a>
                                </li>
                            @endif

                        <!-- Pagination Elements -->
                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if ($page == $products->currentPage())
                                    <li class="page-item active" aria-current="page"><a class="page-link" href="#">{{ $page }}</a></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                        <!-- Last Page Indicator -->
                            <li class="page-item-total">of {{ $products->lastPage() }}</li>

                            <!-- Next Page Link -->
                            @if ($products->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link page-link-next" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                        Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link page-link-next" href="#" aria-label="Next" tabindex="-1" aria-disabled="true">
                                        Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div><!-- End .col-lg-9 -->
                <aside class="col-lg-3 order-lg-first">
                    <div class="sidebar sidebar-shop">
                        <div class="widget widget-clean">
                            <label>Filters:</label>
                            <a href="#" class="sidebar-filter-clear">Clear All</a>
                        </div><!-- End .widget widget-clean -->

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                    Category
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-1">
                                <div class="widget-body">
                                    <div class="filter-items filter-items-count">
                                        @foreach($categories as $category)
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="cat-{{$category->id}}" name="categories[]">
                                                    <label class="custom-control-label" for="cat-{{$category->id}}">{{$category->category_name}}</label>
                                                </div><!-- End .custom-checkbox -->
                                                @php
                                                    $categoryIds = $category->descendants->pluck('id')->toArray();
                                                    $categoryIds[] = $category->id;
                                                    $productCount = \App\Models\Product::whereIn('category_id', $categoryIds)->count();
                                                @endphp
                                                <span class="item-count">{{ $productCount }}</span>
                                            </div><!-- End .filter-item -->
                                        @endforeach
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

                        <!-- Size Filter -->
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-2">
                                    Size
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-2">
                                <div class="widget-body">
                                    <div class="filter-items">
                                        @foreach($sizes as $size)
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="size-{{$size->id}}" name="sizes[]">
                                                    <label class="custom-control-label" for="size-{{$size->id}}">{{$size->name}}</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->
                                        @endforeach
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

                    <!-- Brand Filter -->
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
                                   Brand
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-4">
                                <div class="widget-body">
                                    <div class="filter-items">
                                        @foreach($brands as $brand)
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brand-{{$brand->id}}" name="brands[]">
                                                    <label class="custom-control-label" for="brand-{{$brand->id}}">{{$brand->name}}</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->
                                        @endforeach
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

{{--                        <div class="widget widget-collapsible">--}}
{{--                            <h3 class="widget-title">--}}
{{--                                <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">--}}
{{--                                    Price--}}
{{--                                </a>--}}
{{--                            </h3><!-- End .widget-title -->--}}

{{--                            <div class="collapse show" id="widget-5">--}}
{{--                                <div class="widget-body">--}}
{{--                                    <div class="filter-price">--}}
{{--                                        <div class="filter-price-text">--}}
{{--                                            Price Range:--}}
{{--                                            <span id="filter-price-range"></span>--}}
{{--                                        </div><!-- End .filter-price-text -->--}}

{{--                                        <div id="price-slider"></div><!-- End #price-slider -->--}}
{{--                                    </div><!-- End .filter-price -->--}}
{{--                                </div><!-- End .widget-body -->--}}
{{--                            </div><!-- End .collapse -->--}}
{{--                        </div><!-- End .widget -->--}}
                    </div><!-- End .sidebar sidebar-shop -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sortby').on('change', function () {
                let sortValue = $(this).val();
                fetchFilteredProducts(sortValue, getSelectedCategories(), getSelectedSizes(), getSelectedBrands());
            });

            $('input[type="checkbox"]').on('change', function () {
                let sortValue = $('#sortby').val();
                fetchFilteredProducts(sortValue, getSelectedCategories(), getSelectedSizes(), getSelectedBrands());
            });
        });

        function getSelectedCategories() {
            let selectedCategories = [];
            $('input[type="checkbox"][id^="cat-"]:checked').each(function () {
                selectedCategories.push($(this).attr('id').replace('cat-', ''));
            });
            return selectedCategories;
        }

        function getSelectedSizes() {
            let selectedSizes = [];
            $('input[type="checkbox"][id^="size-"]:checked').each(function () {
                selectedSizes.push($(this).attr('id').replace('size-', ''));
            });
            return selectedSizes;
        }

        function getSelectedBrands() {
            let selectedBrands = [];
            $('input[type="checkbox"][id^="brand-"]:checked').each(function () {
                selectedBrands.push($(this).attr('id').replace('brand-', ''));
            });
            return selectedBrands;
        }

        function fetchFilteredProducts(sortValue, categories, sizes, brands) {
            $.ajax({
                url: "{{route('all.products')}}",
                type: 'GET',
                data: {
                    sort: sortValue,
                    categories: categories,
                    sizes: sizes,
                    brands: brands
                },
                success: function (response) {
                    $('.products .row').html(response); // Update the products grid
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
        // Clear all filters
        $('.sidebar-filter-clear').on('click', function () {
            $('.custom-control-input').prop('checked', false).trigger('change');
        });
    </script>

@endsection
