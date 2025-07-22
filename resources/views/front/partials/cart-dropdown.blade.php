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
                            <a href="{{route('product.show', ['id' => $cartProduct->id, 'slug' => $product->slug])}}">{{$cartProduct->name}}</a>
                        </h4>

                        <span class="cart-product-info">
                                                <span class="cart-product-qty">{{$cartProduct->quantity}}</span>
                                                x &#2547;{{number_format($cartProduct->price)}}
                                            </span>
                    </div><!-- End .product-cart-details -->

                    <figure class="product-image-container">
                        <a href="{{route('product.show', ['id' => $cartProduct->id, 'slug' => $product->slug])}}" class="product-image">
                            <img src="{{asset($cartProduct->attributes->thumbnail_image)}}" alt="product">
                        </a>
                    </figure>
                    <a href="#" class="btn-remove" title="Remove Product" data-product-id="{{$cartProduct->id}}"><i class="icon-close"></i></a>
                </div><!-- End .product -->
            @endforeach
        </div><!-- End .cart-product -->

        <div class="dropdown-cart-total">
            <span>Total</span>
            @php($total = Cart::getTotal())
            <span class="cart-total-price">&#2547;{{number_format($total)}}</span>
        </div><!-- End .dropdown-cart-total -->

        <div class="dropdown-cart-action">
            <a href="{{route('cart.index')}}" class="btn btn-primary">View Cart</a>
            <a href="{{route('checkout')}}" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a>
        </div><!-- End .dropdown-cart-total -->
    </div><!-- End .dropdown-menu -->
</div><!-- End .cart-dropdown -->


