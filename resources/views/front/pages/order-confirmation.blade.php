@extends('front.master')

@section('title')
{{$generalSettingView->site_name}} - Order Confirmation
@endsection

@section('body')
    <style>
        .thank-you-page {
            background-color: #f8f9fa;
            padding: 50px 0;
        }
        .thank-you-card {
            border: none;
            border-radius: 8px;
        }
        .thank-you-card .card-body {
            padding: 40px;
        }
        .thank-you-icon {
            font-size: 50px;
            color: #28a745;
        }
        .order-summary {
            margin-top: 30px;
        }
        .contact-us-box {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            padding: 30px;
            border-radius: 8px;
            margin-top: 40px;
        }
        .contact-us-box i {
            margin-right: 8px;
        }
        .contact-us-box a:hover {
            text-decoration: none;
        }
    </style>

    <!-- Thank You Page Content -->
    <div class="thank-you-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card thank-you-card shadow">
                        <div class="card-body text-center">
                            <div class="thank-you-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h1 class="card-title">Thank You for Your Order!</h1>
                            <p class="card-text">We appreciate your purchase. Your order is being processed, and we will notify you once it has been shipped.</p>
                            <p class="card-text">Order Code: <strong>#{{$order->order_code}}</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary and Details -->
            <div class="row justify-content-center order-summary">
                <div class="col-md-8">
                    <div class="card p-5">
                        <div class="card-header">
                            <h4>Order Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th class="text-center">Variant</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $withOutDiscount = 0;
                                            $discount = 0;
                                        @endphp
                                        @foreach($order->orderDetails as $orderDetail)
                                            @php
                                                $sizeName = $orderDetail->size->name ?? null;
                                                $colorName = $orderDetail->color->name ?? null;
                                                $product = \App\Models\Product::find($orderDetail->product_id);
                                                $newDiscount = $orderDetail->discount_type == 2 ? ($orderDetail->price * ($orderDetail->discount / 100)) : $orderDetail->discount;
                                                $totalAmount = $orderDetail->price + $newDiscount;
                                                $withOutDiscount += $totalAmount * $orderDetail->qty;
                                                $discount += $newDiscount * $orderDetail->qty;
                                            @endphp
                                            <tr>
                                                <td style="padding-top: 2%; padding-bottom: 2%">
                                                    <a href="{{route('product.show', ['id' => $orderDetail->product->id, 'slug' => $orderDetail->product->slug])}}">
                                                        {{ \Illuminate\Support\Str::limit($orderDetail->product->name, 30) }}
                                                    </a>
                                                </td>
                                                <td class="text-center" style="padding-top: 2%; padding-bottom: 2%">
                                                    @if($sizeName || $colorName)
                                                        @if($sizeName) {{ $sizeName }} @endif
                                                        @if($sizeName && $colorName) / @endif
                                                        @if($colorName) {{ $colorName }} @endif
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="text-center" style="padding-top: 2%; padding-bottom: 2%">
                                                    @if($orderDetail->discount > 0)
                                                        <del class="text-danger">&#2547; {{ number_format($orderDetail->price + $newDiscount, 2) }}</del><br>
                                                    @endif
                                                    &#2547; {{ number_format($orderDetail->price, 2) }}
                                                </td>
                                                <td class="text-center" style="padding-top: 2%; padding-bottom: 2%">{{ $orderDetail->qty }}</td>
                                                <td class="text-center" style="padding-top: 2%; padding-bottom: 2%">
                                                    @if($orderDetail->discount > 0)
                                                        <del class="text-danger">&#2547; {{ number_format($totalAmount * $orderDetail->qty, 2) }}</del><br>
                                                    @endif
                                                    &#2547; {{ number_format($orderDetail->price * $orderDetail->qty, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        @php
                                            $totalFinal = $order->grand_total + $order->shipping_cost;
                                        @endphp
                                        <tr>
                                            <th colspan="4" class="text-right"><b>Subtotal:</b></th>
                                            <th class="text-center">&#2547; {{ number_format($withOutDiscount, 2) }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right"><b>Shipping cost:</b></th>
                                            @if($order->shipping_cost > 0)
                                                <th class="text-center">&#2547; {{ number_format($order->shipping_cost, 2) }}</th>
                                            @else
                                                <th class="text-center">Shipping is free</th>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right"><b>Discount:</b></th>
                                            <th class="text-center">&#2547; {{ number_format($discount, 2) }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right"><b>Grand Total:</b></th>
                                            <th class="text-center">&#2547; {{ number_format($totalFinal, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        @if(Session::get('customer_id'))
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                        @else
                            <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
                        @endif
                        <a href="#" class="btn btn-info" onclick="event.preventDefault(); document.getElementById('invoiceDownload').submit();">
                            <i class="fas fa-download"></i> Download Invoice
                        </a>
                        <form action="{{ route('invoice.download', ['id' => $order->id]) }}" method="POST" id="invoiceDownload">
                            @csrf
                        </form>
                    </div>

                    <!-- Contact Info Section -->
                    <div class="contact-us-box text-center">
                        <h5 class="text-success font-weight-bold mb-3">Need Help or Have Questions?</h5>
                        <p class="mb-3">We're here to help you. Connect with us anytime for assistance.</p>
                        <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                            <a href="{{ $generalSettingView->facebook_url }}" target="_blank" class="btn btn-outline-primary px-4">
                                <i class="fab fa-facebook-f"></i> Visit Our Facebook Page
                            </a>
                            <a href="tel:+88{{ $generalSettingView->mobile }}" class="btn btn-outline-success px-4">
                                <i class="fas fa-phone"></i> Call Us: {{ $generalSettingView->mobile }}
                            </a>
                        </div>
                    </div>
                    <!-- End Contact Info -->
                </div>
            </div>
        </div>
    </div>

    <script>
        dataLayer.push({ ecommerce: null });
        dataLayer.push({
            event : "purchase",
            ecommerce: {
                currency: "BDT",
                transaction_id: "{{ $order->order_code }}",
                affiliation : "",
                value : "{{ $order->grand_total }}",
                tax : "",
                shipping : "{{ $order->shipping_cost }}",
                coupon : "",
                items : [
                    @foreach ($order->orderDetails as $orderDetail)
                    {
                        item_name : "{{ $orderDetail->product->name }}",
                        item_id : "{{ $orderDetail->product_id }}",
                        price : "{{ $orderDetail->price }}",
                        item_brand : "{{ $orderDetail->product->brand->name }}",
                        item_category: "{{ $orderDetail->product->category->category_name ?? '' }}",
                        item_variant : "{{ $orderDetail->size_id ? $orderDetail->size->name : '' }}{{ $orderDetail->size_id && $orderDetail->color_id ? ' / ' : '' }}{{ $orderDetail->color_id ? $orderDetail->color->name : '' }}",
                        quantity : {{ $orderDetail->qty }}
                    },
                    @endforeach
                ]
            },
            customer: {
                shipping: {
                    name: "{{ $order->name }}",
                    email: "{{ $order->email }}",
                    mobile: "{{ $order->mobile }}",
                    address: "{{ $order->address }}",
                    alt_phone: "{{ $order->alt_mobile }}"
                }
            }
        });
    </script>
@endsection
