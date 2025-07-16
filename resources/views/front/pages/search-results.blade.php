@extends('front.master')

@section('title')
{{$generalSettingView->site_name}} - Search Results
@endsection

@section('body')
    <div class="page-header text-center" style="background-image: url('{{asset('/')}}front/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Search Results</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Search Results</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="toolbox" style="font-size: 2.4rem;">
                        <div class="toolbox-left">
                            <div class="toolbox-info">
                                Search result for"{{$query}}"
                            </div><!-- End .toolbox-info -->
                        </div><!-- End .toolbox-left -->

{{--                        <div class="toolbox-right">--}}
{{--                            <div class="toolbox-sort">--}}
{{--                                <label for="sortby">Sort by:</label>--}}
{{--                                <div class="select-custom">--}}
{{--                                    <select name="sortby" id="sortby" class="form-control">--}}
{{--                                        <option value="popularity" selected="selected">Most Popular</option>--}}
{{--                                        <option value="date">Date</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div><!-- End .toolbox-sort -->--}}
{{--                        </div><!-- End .toolbox-right -->--}}
                    </div><!-- End .toolbox -->

                    <div class="products mb-3">
                        <div class="row justify-content-center">
                            @if(count($products) > 0)
                            @foreach($products as $product)
                                <div class="col-6 col-md-3 col-lg-3 col-xl-3">
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
                                            <div class="product-cat">
                                                <a href="{{route('category.product', ['id' => $product->category_id])}}">{{$product->category->category_name}}</a>
                                            </div><!-- End .product-cat -->
                                            <h3 class="product-title">
                                                <a href="{{route('product.show', ['id' => $product->id, 'slug' => $product->slug])}}">{{\Illuminate\Support\Str::limit($product->name,40)}}</a></h3><!-- End .product-title -->
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
                            @else
                                <div class="col-md-12 text-center" style="display: block; margin-top: 5%">
                                    <h4 class="text-danger text-center">Product not found!</h4>
                                </div>
                            @endif
                        </div><!-- End .row -->
                    </div><!-- End .products -->

                </div><!-- End .col-lg-9 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
@endsection
