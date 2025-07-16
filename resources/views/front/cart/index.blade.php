@extends('front.master')

@section('title')
{{$generalSettingView->site_name}} - শপিং কার্ট
@endsection

@section('body')
    <div class="page-header text-center" style="background-image: url('{{asset('/')}}front/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">শপিং কার্ট<span>শপ</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">হোম</a></li>
                <li class="breadcrumb-item active" aria-current="page">শপিং কার্ট</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        @if(count($cartProducts) > 0)
                            @php
                                $hasSizes = false;
                                foreach ($cartProducts as $cartProduct) {
                                    $product = \App\Models\Product::find($cartProduct->attributes->product_id);
                                    if ($product->variants->where('size_id', '!=', null)->unique('size_id')->count() > 0) {
                                        $hasSizes = true;
                                        break;
                                    }
                                }
                                $hasColors = false;
                                foreach ($cartProducts as $cartProduct) {
                                    $product = \App\Models\Product::find($cartProduct->attributes->product_id);
                                    if ($product->variants->where('color_id', '!=', null)->unique('color_id')->count() > 0) {
                                        $hasColors = true;
                                        break;
                                    }
                                }
                            @endphp

                            <table class="table table-cart table-mobile">
                                <thead>
                                <tr>
                                    <th>পণ্য</th>
                                    <th>মূল্য</th>
                                    @if($hasSizes)
                                        <th>সাইজ</th>
                                    @endif
                                    <th>পরিমাণ</th>
                                    <th>মোট</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cartProducts as $cartProduct)
                                    @php
                                        $product = \App\Models\Product::find($cartProduct->attributes->product_id);
                                    @endphp
                                    <tr>
                                        <td class="product-col">
                                            <div class="product">
                                                <figure class="product-media">
                                                    <a href="{{route('product.show', ['id' => $cartProduct->attributes->product_id, 'slug' => $product->slug])}}">
                                                        <img src="{{$cartProduct->attributes->thumbnail_image}}" alt="Product image">
                                                    </a>
                                                </figure>

                                                <h3 class="product-title">
                                                    <a href="{{route('product.show', ['id' => $cartProduct->attributes->product_id, 'slug' => $product->slug])}}">{{$cartProduct->name}}</a>
                                                </h3><!-- End .product-title -->
                                            </div><!-- End .product -->
                                        </td>
                                        @php
                                            $product = \App\Models\Product::find($cartProduct->attributes->product_id);
                                            $defult_stock = $product->stock;
                                        @endphp
                                        <td class="price-col">&#2547;{{number_format($cartProduct->price, 2)}}</td>
                                        @if($hasSizes)
                                            <td class="quantity-col">
                                                <div class="cart-product-quantity">
                                                    <form action="{{ route('cart.updateSize') }}" method="POST" class="update-size-form">
                                                        @csrf
                                                        <input type="hidden" name="cart_product_id" value="{{$cartProduct->id}}">
                                                        <input type="hidden" name="product_id" value="{{$cartProduct->attributes->product_id}}">
                                                        <select name="size_id" class="form-control size-select"
                                                                onchange="this.form.submit()"
                                                                @if($cartProduct->attributes->size == null) disabled @endif>
                                                            <option value="" selected disabled>সাইজ সিলেক্ট করুন</option>
                                                        @foreach($product->variants as $variant)
                                                            @if($variant->size) <!-- Check if size exists -->
                                                                <option value="{{$variant->size_id}}" {{$variant->size_id == $cartProduct->attributes->size ? 'selected' : ''}}>
                                                                    {{$variant->size->name}}
                                                                </option>
                                                                @php
                                                                    if ($variant->size_id == $cartProduct->attributes->size) {
                                                                        $defult_stock = $variant->qty;
                                                                    }
                                                                @endphp
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif

                                        @if($hasColors)
                                            <td class="quantity-col">
                                                <div class="cart-product-quantity">
                                                    <form action="{{ route('cart.updateColor') }}" method="POST" class="update-size-form">
                                                        @csrf
                                                        <input type="hidden" name="cart_product_id" value="{{$cartProduct->id}}">
                                                        <input type="hidden" name="product_id" value="{{$cartProduct->attributes->product_id}}">
                                                        <select name="color_id" class="form-control size-select"
                                                                onchange="this.form.submit()"
                                                                @if($cartProduct->attributes->color == null) disabled @endif>
                                                            <option value="" selected disabled>কালার সিলেক্ট করুন</option>
                                                        @foreach($product->variants as $variant)
                                                            @if($variant->color) <!-- Check if color exists -->
                                                                <option value="{{$variant->color_id}}" {{$variant->color_id == $cartProduct->attributes->color ? 'selected' : ''}}>
                                                                    {{$variant->color->name}}
                                                                </option>
                                                                @php
                                                                    if ($variant->color_id == $cartProduct->attributes->color) {
                                                                        $defult_stock = $variant->qty;
                                                                    }
                                                                @endphp
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif
                                        <td class="quantity-col">
                                            <div class="cart-product-quantity">
                                                <input type="number"
                                                       class="form-control quantity-input"
                                                       value="{{$cartProduct->quantity}}"
                                                       max="{{$defult_stock}}"
                                                       min="1"
                                                       step="1"
                                                       data-product-id="{{$cartProduct->id}}"
                                                       data-row-total="#row-total-{{$cartProduct->id}}"
                                                       required readonly>
                                            </div><!-- End .cart-product-quantity -->
                                        </td>
                                        <td class="total-col" id="row-total-{{$cartProduct->id}}">&#2547; {{number_format($cartProduct->price * $cartProduct->quantity, 2)}}</td>
                                        <td class="remove-col">
                                            <button class="btn-remove" data-product-id="{{$cartProduct->id}}">
                                                <i class="icon-close"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table><!-- End .table table-wishlist -->
                        @else
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-center text-danger">আপনার কার্টে কোনো পণ্য নেই!</h4>
                                </div>
                            </div>
                        @endif
                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">কার্ট মোট</h3>

                            <table class="table table-summary">
                                <tbody>
                                <tr class="summary-subtotal">
                                    <td>সাবটোটাল:</td>
                                    <td>&#2547;{{ number_format(\Cart::getTotal(), 2) }}</td>
                                </tr>
{{--                                <tr class="summary-shipping">--}}
{{--                                    <td>Shipping:</td>--}}
{{--                                    <td id="shipping-cost">&nbsp;</td>--}}
{{--                                </tr>--}}

{{--                                <tr class="summary-shipping-row">--}}
{{--                                    <td>--}}
{{--                                        <div class="custom-control custom-radio">--}}
{{--                                            <input type="radio" id="inside-dhaka-shipping" name="shipping" class="custom-control-input" data-cost="80">--}}
{{--                                            <label class="custom-control-label" for="inside-dhaka-shipping">Inside Dhaka:</label>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>&#2547; 80</td>--}}
{{--                                </tr>--}}

{{--                                <tr class="summary-shipping-row">--}}
{{--                                    <td>--}}
{{--                                        <div class="custom-control custom-radio">--}}
{{--                                            <input type="radio" id="outside-dhaka-shipping" name="shipping" class="custom-control-input" data-cost="120">--}}
{{--                                            <label class="custom-control-label" for="outside-dhaka-shipping">Outside Dhaka:</label>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>&#2547; 120</td>--}}
{{--                                </tr>--}}

                                <tr class="summary-total">
                                    <td>মোট:</td>
                                    <td id="total-amount">&#2547;{{ number_format(\Cart::getTotal(), 2) }}</td>
                                </tr>
                                </tbody>
                            </table>

                            <a href="{{route('checkout')}}" class="btn btn-outline-primary-2 btn-order btn-block">চেকআউটে যান</a>
                        </div>

                        <a href="{{route('all.products')}}" class="btn btn-outline-dark-2 btn-block mb-3"><span>কেনাকাটা চালিয়ে যান</span><i class="icon-refresh"></i></a>
                    </aside>
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->



    <script type = "text/javascript">
        dataLayer.push({ ecommerce: null }); // Clear the previous ecommerce object.
        dataLayer.push({
            event : "view_cart",
            ecommerce: {
                currency: "BDT",
                value: "{{\Cart::getTotal()}}",
                items: [@foreach ($cartProducts as $cartProduct)
                    @php
                    $product = \App\Models\Product::find($cartProduct->attributes->product_id);
                    $size = \App\Models\Variant::where('size_id', $cartProduct->attributes->size)->first();
                    @endphp
                {
                    item_name : "{{$cartProduct->name}}",
                    item_id : "{{$cartProduct->attributes->product_id}}",
                    price : "{{$cartProduct->price}}",
                    item_brand : "{{$product->brand->name ?? ""}}",
                    item_category : "{{$product->category->category_name ?? ""}}",
                    item_category2: "{{$product->category->category_name ?? ""}}",
                    item_category3: "",
                    item_category4: "",
                    @if($product->variants->where('size_id', '!=', null)->unique('size_id')->count() > 0)
                    item_variant : "{{$size->size->name}}",
                    @endif
                    item_list_name: "", // If associated with a list selection.
                    item_list_id : "", // If associated with a list selection.
                    index : 0, // If associated with a list selection.
                    quantity : {{$cartProduct->quantity ?? 0}}
                },@endforeach]
            }
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subtotal = parseFloat('{{ \Cart::getTotal() }}');
            const totalAmountElem = document.getElementById('total-amount');
            const shippingCostElem = document.getElementById('shipping-cost');

            document.querySelectorAll('input[name="shipping"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    const shippingCost = parseFloat(this.getAttribute('data-cost')) || 0;
                    const total = subtotal + shippingCost;

                    shippingCostElem.textContent = `৳ ${shippingCost.toFixed(2)}`;
                    totalAmountElem.textContent = `৳ ${total.toFixed(2)}`;
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.querySelectorAll('.quantity-input').forEach(function (input) {
                input.addEventListener('change', function () {
                    const productId = this.getAttribute('data-product-id');
                    const newQuantity = this.value;
                    const rowTotalElement = document.querySelector(this.getAttribute('data-row-total'));

                    fetch('{{ route("cart.updateQuantity") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: newQuantity
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update the row total
                                rowTotalElement.textContent = '৳' + number_format(data.rowTotal);

                                // Update the subtotal and total
                                document.querySelector('.summary-subtotal td:last-child').textContent = '৳' + number_format(data.subtotal);
                                document.querySelector('#total-amount').textContent = '৳' + number_format(data.total);

                                // Optionally, update other elements like shipping cost if needed
                            } else {
                                alert('Error updating quantity.');
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
                                // Remove the product row from the DOM
                                const productRow = this.closest('tr');
                                productRow.remove();

                                // Update the cart total and count
                                document.querySelector('.cart-count').textContent = data.cartCount;
                                document.querySelector('.cart-total-price').textContent = '৳' + number_format(data.total);

                                // Check if the cart is empty
                                if (document.querySelectorAll('.table-cart tbody tr').length === 0) {
                                    // Hide the table and show the empty cart message
                                    document.querySelector('.table-cart').style.display = 'none';
                                    document.querySelector('.col-lg-9').innerHTML = `
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="text-center text-danger">Your cart is empty!</h4>
                                    </div>
                                </div>`;
                                }
                            } else {
                                alert('Error removing product from cart.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });

            // Helper function to format numbers
            function number_format(number) {
                return parseFloat(number).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }
        });
    </script>

@endsection
