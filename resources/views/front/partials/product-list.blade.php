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
                    <a href="{{route('product.show', ['id' => $category_product->id, 'slug' => $category_product->slug])}}">{{$category_product->name}}</a></h3><!-- End .product-title -->
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
                <<div class="ratings-container mt-2">
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
                                            </div><!-- End .rating-container -->
            </div><!-- End .product-body -->
        </div><!-- End .product -->
    </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
@endforeach
