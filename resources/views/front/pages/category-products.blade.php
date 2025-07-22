@extends('front.master')

@section('title')
{{$generalSettingView->site_name}} - {{$category->category_name}}
@endsection

@section('body')
    <div class="page-header text-center" style="background-image: url('{{asset('/')}}front/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">{{$category->category_name}}</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                @if($category->parentCategory)
                <li class="breadcrumb-item">
                    <a href="{{route('category.product', ['id' => $category->parentCategory->id])}}">{{$category->parentCategory->category_name}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{$category->category_name}}</li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">{{$category->category_name}}</li>
                @endif
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
                                Showing <span>{{ $category_products->firstItem() }} - {{ $category_products->lastItem() }}</span> of
                                  <span>{{ $category_products->total() }}</span> Products
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
                        </div><!-- End .toolbox-right -->
                    </div><!-- End .toolbox -->

                    <div class="products mb-3">
                        <div class="row justify-content-center">
                            @foreach($category_products as $category_product)
                            <div class="col-6 col-md-4 col-lg-4 col-xl-3">
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
                                            @php
                                                $newPrice = $category_product->sell_price;

                                                if ($category_product->discount > 0) {
                                                    if ($category_product->discount_type == 2) {
                                                        $newPrice = $category_product->sell_price - ($category_product->sell_price * ($category_product->discount / 100));
                                                    } else {
                                                        $newPrice = $category_product->sell_price - $category_product->discount;
                                                    }
                                                }
                                            @endphp
                                            <span class="new-price">&#2547;{{ number_format($newPrice, 2) }}</span>

                                            @if($category_product->discount > 0)
                                                <span class="old-price">&#2547;{{ number_format($category_product->sell_price, 2) }}</span>
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
                                                        <i class="fa fa-bolt"></i><span class="text-white">&nbsp;এখনই কিনুন</span>
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
                                                        <i class="fa fa-bolt"></i><span class="text-white">&nbsp;এখনই কিনুন</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
{{--                                        <div class="ratings-container">--}}
{{--                                            <div class="ratings">--}}
{{--                                                <div class="ratings-val" style="width: 100%;"></div><!-- End .ratings-val -->--}}
{{--                                            </div><!-- End .ratings -->--}}
{{--                                            <span class="ratings-text">( 2 Reviews )</span>--}}
{{--                                        </div><!-- End .rating-container -->--}}
                                    </div><!-- End .product-body -->
                                </div><!-- End .product -->
                            </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                            @endforeach
                        </div><!-- End .row -->
                    </div><!-- End .products -->


                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <!-- Previous Page Link -->
                            @if ($category_products->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                        <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                    </a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link page-link-prev" href="{{ $category_products->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                    </a>
                                </li>
                            @endif

                        <!-- Pagination Elements -->
                            @foreach ($category_products->getUrlRange(1, $category_products->lastPage()) as $page => $url)
                                @if ($page == $category_products->currentPage())
                                    <li class="page-item active" aria-current="page"><a class="page-link" href="#">{{ $page }}</a></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                        <!-- Last Page Indicator -->
                            <li class="page-item-total">মধ্যে {{ $category_products->lastPage() }}</li>

                            <!-- Next Page Link -->
                            @if ($category_products->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link page-link-next" href="{{ $category_products->nextPageUrl() }}" aria-label="Next">
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
                            <label>Fillters:</label>
                            <a href="#" class="sidebar-filter-clear">Clear All</a>
                        </div><!-- End .widget widget-clean -->

                        @if(count($category->subCategories) > 0)
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                        {{$category->category_name}}
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-1">
                                    <div class="widget-body">
                                        @foreach($category->subCategories as $subCategory)
                                            <div class="filter-items filter-items-count">
                                                <div class="filter-item">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input subcategory-filter" id="cat-{{$subCategory->id}}" data-id="{{$subCategory->id}}">
                                                        <label class="custom-control-label" for="cat-{{$subCategory->id}}">{{$subCategory->category_name}}</label>
                                                    </div><!-- End .custom-checkbox -->
                                                    <span class="item-count">{{count($subCategory->products)}}</span>
                                                </div><!-- End .filter-item -->
                                            </div><!-- End .filter-items -->
                                        @endforeach
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->
                        @endif

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
                                                        <input type="checkbox" class="custom-control-input size-filter" id="size-{{$size->id}}" data-id="{{$size->id}}">
                                                        <label class="custom-control-label" for="size-{{$size->id}}">{{$size->name}}</label>
                                                    </div><!-- End .custom-checkbox -->
                                                </div><!-- End .filter-item -->
                                            @endforeach
                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

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
                                                        <input type="checkbox" class="custom-control-input brand-filter" id="brand-{{$brand->id}}" data-id="{{$brand->id}}">
                                                        <label class="custom-control-label" for="brand-{{$brand->id}}">{{$brand->name}}</label>
                                                    </div><!-- End .custom-checkbox -->
                                                </div><!-- End .filter-item -->
                                            @endforeach
                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->
                    </div><!-- End .sidebar sidebar-shop -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->


    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Sorting
            $('#sortby').on('change', function () {
                updateProducts();
            });

            // SubCategory, Size, and Brand filters
            $('.subcategory-filter, .size-filter, .brand-filter').on('change', function () {
                updateProducts();
            });

            function updateProducts() {
                let sortValue = $('#sortby').val();
                let categoryId = '{{ $category->id }}'; // Use the current category ID

                // Get selected subCategories
                let selectedSubCategories = $('.subcategory-filter:checked').map(function() {
                    return $(this).data('id');
                }).get();

                // Get selected sizes
                let selectedSizes = $('.size-filter:checked').map(function() {
                    return $(this).data('id');
                }).get();

                // Get selected brands
                let selectedBrands = $('.brand-filter:checked').map(function() {
                    return $(this).data('id');
                }).get();

                let routeUrl = "{{ route('category.product', ['id' => ':id']) }}";
                routeUrl = routeUrl.replace(':id', categoryId); // Replace placeholder with category ID

                fetchFilteredProducts(sortValue, selectedSubCategories, selectedSizes, selectedBrands, routeUrl);
            }

            function fetchFilteredProducts(sortValue, subCategories, sizes, brands, routeUrl) {
                $.ajax({
                    url: routeUrl,
                    type: 'GET',
                    data: {
                        sort: sortValue,
                        subcategories: subCategories,
                        sizes: sizes,
                        brands: brands
                    },
                    success: function (response) {
                        $('.products .row').html(response); // Update the product list
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });

        // Clear all filters
        $('.sidebar-filter-clear').on('click', function () {
            $('.custom-control-input').prop('checked', false).trigger('change');
        });

    </script>

@endsection
