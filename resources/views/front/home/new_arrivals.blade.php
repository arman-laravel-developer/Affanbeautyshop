@foreach($newArrivals as $newArrival)
    <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
        <div class="product product-7 text-center">
            <figure class="product-media">
                @php
                    $isNew = \Carbon\Carbon::parse($newArrival->created_at)->gt(\Carbon\Carbon::now()->subDays(14));
                @endphp

                @if($isNew)
                    <span class="product-label label-new">New</span>
                @endif
                <a href="{{route('product.show', ['id' => $newArrival->id, 'slug' => $newArrival->slug])}}" class="product-link">
                    <img src="{{asset($newArrival->thumbnail_img)}}" alt="Product image" class="product-image">
                    <img src="{{asset($newArrival->thumbnail_img)}}" alt="Product image" class="product-image-hover">
                </a>
            </figure><!-- End .product-media -->

            <div class="product-body">
                <h3 class="product-title"><a href="{{route('product.show', ['id' => $newArrival->id, 'slug' => $newArrival->slug])}}">{{\Illuminate\Support\Str::limit($newArrival->name, 40)}}</a></h3><!-- End .product-title -->
                <div class="product-price">
                    <span class="new-price">&#2547;{{ number_format(discounted_price($newArrival), 2) }}</span>

                    @if(discounted_active($newArrival))
                        <span class="old-price">&#2547;{{ number_format($newArrival->sell_price, 2) }}</span>
                    @endif
                </div><!-- End .product-price -->
                <div class="ratings-container">
                    <div class="ratings">
                        <div class="ratings-val" style="width: 40%;"></div><!-- End .ratings-val -->
                    </div><!-- End .ratings -->
                    <span class="ratings-text">( 4 Reviews )</span>
                </div><!-- End .rating-container -->
            </div><!-- End .product-body -->
        </div><!-- End .product -->
    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
@endforeach

