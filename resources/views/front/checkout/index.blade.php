@extends('front.master')

@section('title')
{{$generalSettingView->site_name}} - Checkout
@endsection

@section('body')
{{--    <div class="page-header text-center" style="background-image: url('{{asset('/')}}front/assets/images/page-header-bg.jpg')">--}}
{{--        <div class="container">--}}
{{--            <h1 class="page-title">Checkout<span>Shop</span></h1>--}}
{{--        </div><!-- End .container -->--}}
{{--    </div><!-- End .page-header -->--}}
<nav aria-label="breadcrumb" class="breadcrumb-nav bg-gray">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->


<style>
    .form-section, .order-summary {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
    }
    .form-section h2, .order-summary h2 {
        font-size: 18px;
        margin-bottom: 20px;
        font-weight: bold;
    }
    .form-group i {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: #666;
    }
    .form-group input {
        padding-left: 40px;
    }
    .radio-group label {
        display: block;
        margin-bottom: 8px;
    }
    .submit-btn {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        background-color: #28a745;
        border: none;
        color: #fff;
        border-radius: 5px;
    }
    .submit-btn:hover {
        background-color: #218838;
    }
    .order-summary .item img {
        width: 80px;
        height: 80px;
        border-radius: 5px;
        object-fit: cover;
    }
    .quantity-control button {
        border: 1px solid #ddd;
        padding: 5px 10px;
        background-color: #f8f9fa;
    }
    .quantity-control input {
        width: 50px;
        text-align: center;
        border: 1px solid #ddd;
    }
    .total p {
        display: flex;
        justify-content: space-between;
    }
    .total label {
        display: flex;
        justify-content: space-between;
    }
    .total p strong {
        font-size: 16px;
    }
</style>

    <div class="page-content">
        <div class="checkout">
            <div class="container py-4">
                <div class="row g-4 justify-content-center">
                    <!-- Form Section -->
                    <div class="col-md-6">
                        <div class="form-section">
                            <h2>Fill out the form below to order</h2>
                            <form id="orderForm" action="{{route('order.store-button')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @php
                                    $order = \App\Models\Order::where('order_status', 'in_completed')->where('id', Session::get('order_id'))->first();
                                @endphp
                                <div class="form-group position-relative mb-3">
                                    <i class="fa fa-user"></i>
                                    <input type="text" class="form-control" name="name" value="{{$order->name ?? ''}}" placeholder="Enter Your Name*" required>
                                </div>
                                <div class="form-group position-relative mb-3">
                                    <i class="fa fa-phone"></i>
                                    <input type="text" class="form-control" name="mobile" value="{{$order->mobile ?? ''}}"
                                           oninput="this.value = convertBanglaToArabic(this.value).replace(/[^0-9]/g, '');"
                                           placeholder="Enter Your Mobile Number*" required>
                                </div>
                                <div class="form-group position-relative mb-3">
                                    <i class="fa fa-map-marker-alt"></i>
                                    <input type="text" class="form-control" name="address" value="{{$order->address ?? ''}}" placeholder="Enter Your Address (Thana + Zilla)*" required>
                                </div>
                                <div class="form-group position-relative mb-3">
                                    <i class="fa fa-comments"></i>
                                    <input type="text" class="form-control" name="order_note" value="{{$order->order_note ?? ''}}" placeholder="Notes about your order, e.g. special notes for delivery. (optional)">
                                </div>
                                <input type="hidden" name="payment_method" value="3">
                                @if(!$isFreeShipping)
                                <!-- Shipping Area Selection -->
                                    <h3 class="h6 mt-4">Select Delivery Area</h3>
                                    <div class="radio-group mb-4">
                                        @foreach($shippingCosts as $shippingCost)
                                            <div class="total">
                                                <label style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                                                    <input type="radio" name="shipping_cost" {{ isset($order->shipping_cost) && $order->shipping_cost == $shippingCost->shipping_cost ? 'checked' : '' }}  class="shipping-cost"
                                                           value="{{$shippingCost->shipping_cost}}" data-cost="{{$shippingCost->shipping_cost}}" required>
                                                    <span style="margin-left: 1%">{{$shippingCost->address_name}}</span>
                                                    <span style="margin-left: auto">&#2547; {{$shippingCost->shipping_cost}}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <input type="hidden" name="shipping_cost" value="0">
                                @endif
{{--                                <div id="responseMessage" style="display: none; color: green; margin-top: 10px;"></div>--}}
                                <button type="submit" class="btn btn-success w-100">Place Order</button>
                            </form>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let submitTimeout; // Variable to store timeout reference

                            function submitOrderForm() {
                                var formData = new FormData($("#orderForm")[0]); // Get form data
                                formData.append('_token', '{{ csrf_token() }}'); // Add CSRF token

                                $.ajax({
                                    url: "{{ route('order.store') }}", // Laravel route
                                    type: "POST",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    beforeSend: function () {
                                        $("#responseMessage").hide().text("অর্ডার প্রসেস হচ্ছে...");
                                    },
                                    success: function (response) {
                                        $("#responseMessage").show().text("✅ অর্ডার সফলভাবে আপডেট হয়েছে!");
                                    },
                                    error: function (xhr) {
                                        $("#responseMessage").show().text("❌ কিছু ভুল হয়েছে, আবার চেষ্টা করুন!");
                                    }
                                });
                            }

                            // Debounce function
                            function debounceSubmit() {
                                clearTimeout(submitTimeout); // Clear any previous timeout
                                submitTimeout = setTimeout(submitOrderForm, 1000); // Wait 2 seconds before submitting
                            }

                            // Trigger debounce on input change
                            $("#orderForm input").on("input", function () {
                                debounceSubmit();
                            });
                        });
                    </script>

                    <!-- Order Summary Section -->
                    <div class="col-md-6">
                        <div class="order-summary">
                            <h2>Your Order</h2>
                            @foreach($cartProducts as $cartProduct)
                                @php
                                    // Fetch variants based on size and color attributes
                                    $size = $cartProduct->attributes->size ?? null;
                                    $color = $cartProduct->attributes->color ?? null;

                                    $variants = \App\Models\Variant::where('product_id', $cartProduct->attributes->product_id)
                                        ->when($size, function($query) use ($size) {
                                            return $query->where('size_id', $size);
                                        })
                                        ->when($color, function($query) use ($color) {
                                            return $query->where('color_id', $color);
                                        })
                                        ->get();
                                @endphp
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{$cartProduct->attributes->thumbnail_image}}" style="width: 10%; margin-right: 5%;" alt="Product" class="me-3">
                                    <div>
                                        <p class="m-0 fw-bold">{{$cartProduct->name}}</p>
                                        @if($variants->isNotEmpty())
                                            <ul class="m-0">
                                                @foreach($variants as $variant)
                                                    <li class="text-muted">
                                                        Variant: {{$variant->variant ?? 'N/A'}} x {{$cartProduct->quantity}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="m-0">Quantity: {{$cartProduct->quantity}}</p>
                                        @endif
                                    </div>
                                    <p class="ms-auto fw-bold" style="margin-left: auto;">&#2547;{{number_format($cartProduct->price,2)}}</p>
                                </div>
                            @endforeach
                            <div class="total mt-3">
                                <p>Sub-Total: <span id="cart-subtotal">&#2547;{{ number_format(\Cart::getTotal(), 2) }}</span></p>
                                @if(!$isFreeShipping)
                                    <p>Shipping Cost: <span id="shipping-cost">&#2547;0</span></p>
                                @else
                                    <p>Shipping Cost: <img src="{{ asset('/free-shipping.png') }}" alt="Free Shipping" style="width: 9%; justify-content: flex-end; display: block; margin-left: auto;"></p>
                                @endif
                                <p>Total: <span id="cart-total"><strong>&#2547;{{ number_format(\Cart::getTotal(), 2) }}</strong></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End .checkout -->
    </div><!-- End .page-content -->

<script>
    // Function to convert Bangla numbers to Arabic numbers
    function convertBanglaToArabic(input) {
        var banglaNumbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        var arabicNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        // Replace each Bangla number with the corresponding Arabic number
        return input.split('').map(function(char) {
            var index = banglaNumbers.indexOf(char);
            return index !== -1 ? arabicNumbers[index] : char;
        }).join('');
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const shippingInputs = document.querySelectorAll('input[name="shipping_cost"]');
        const shippingCostElement = document.querySelector('.total p:nth-child(2) span');
        const totalElement = document.querySelector('.total p:nth-child(3) span');

        const subTotal = parseFloat({{ \Cart::getTotal() }}); // Server-side subtotal

        // Show initial values (no shipping cost)
        shippingCostElement.innerHTML = `&#2547;0.00`;
        totalElement.innerHTML = `<strong>&#2547;${subTotal.toFixed(2)}</strong>`;

        const updateSummary = (shippingCost) => {
            const updatedTotal = subTotal + parseFloat(shippingCost || 0);
            shippingCostElement.innerHTML = `&#2547;${parseFloat(shippingCost || 0).toFixed(2)}`;
            totalElement.innerHTML = `<strong>&#2547;${updatedTotal.toFixed(2)}</strong>`;
        };

        // Only update total when a shipping option is selected
        shippingInputs.forEach(input => {
            input.addEventListener('change', (event) => {
                updateSummary(event.target.value);
            });
        });
    });
</script>



<script type="text/javascript">
    dataLayer.push({ ecommerce: null }); // Clear the previous ecommerce object.
    dataLayer.push({
        event: "begin_checkout",
        ecommerce: {
            currency: "BDT",
            value: "{{ \Cart::getTotal() }}",
            items: [
                    @foreach ($cartProducts as $cartProduct)
                    @php
                        $product = \App\Models\Product::find($cartProduct->attributes->product_id);
                        $variant = \App\Models\Variant::where('size_id', $cartProduct->attributes->size)
                                    ->orWhere('color_id', $cartProduct->attributes->color)
                                    ->first();
                        $sizeName = $variant->size->name ?? null;
                        $colorName = $variant->color->name ?? null;
                    @endphp
                {
                    item_name: "{{ $cartProduct->name }}",
                    item_id: "{{ $cartProduct->attributes->product_id }}",
                    price: "{{ $cartProduct->price }}",
                    item_brand: "{{ $product->brand->name ?? '' }}",
                    item_category: "{{ $product->category->category_name ?? '' }}",
                    item_category2: "{{ $product->subcategory->category_name ?? '' }}",
                    item_variant: "{{ $sizeName ? $sizeName : '' }}{{ $sizeName && $colorName ? ' / ' : '' }}{{ $colorName ? $colorName : '' }}",
                    item_list_name: "", // Optional: If associated with a list selection.
                    item_list_id: "", // Optional: If associated with a list selection.
                    index: 0, // Optional: If associated with a list selection.
                    quantity: {{ $cartProduct->quantity ?? 0 }}
                },
                @endforeach
            ]
        }
    });
</script>


<script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const bkashAccountInput = document.getElementById('bkash_account');
            const nagadAccountInput = document.getElementById('nagad_account');

            function updateRequiredFields() {
                bkashAccountInput.removeAttribute('required');
                nagadAccountInput.removeAttribute('required');

                if (document.getElementById('bkash').checked) {
                    bkashAccountInput.setAttribute('required', 'required');
                } else if (document.getElementById('nagad').checked) {
                    nagadAccountInput.setAttribute('required', 'required');
                }
            }

            paymentMethods.forEach(method => {
                method.addEventListener('change', updateRequiredFields);
            });

            updateRequiredFields(); // Set initial state
        });
    </script>
    <!-- End .accordion -->

    <script>
        function copyAccountNumber() {
            // Create a temporary input element to hold the text to copy
            var tempInput = document.createElement("input");
            tempInput.value = "01709925778";
            document.body.appendChild(tempInput);

            // Select the text
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the input
            document.execCommand("copy");

            // Remove the temporary input element
            document.body.removeChild(tempInput);

            // Show the status message
            var statusMessage = document.getElementById("copy-status");
            statusMessage.style.display = "inline";

            // Hide the status message after 2 seconds
            setTimeout(function() {
                statusMessage.style.display = "none";
            }, 2000);
        }
        function copyAccountNagadNumber() {
            // Create a temporary input element to hold the text to copy
            var tempInput = document.createElement("input");
            tempInput.value = "01709925778";
            document.body.appendChild(tempInput);

            // Select the text
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the input
            document.execCommand("copy");

            // Remove the temporary input element
            document.body.removeChild(tempInput);

            // Show the status message
            var statusMessage = document.getElementById("copy-status-nagad");
            statusMessage.style.display = "inline";

            // Hide the status message after 2 seconds
            setTimeout(function() {
                statusMessage.style.display = "none";
            }, 2000);
        }

    </script>
@endsection
