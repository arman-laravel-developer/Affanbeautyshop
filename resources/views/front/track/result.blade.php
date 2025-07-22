@extends('front.master')

@section('title')
    {{ $generalSettingView->site_name }} - Track my order
@endsection

@section('body')
    <style>
        .progress {
            height: 20px;
            border-radius: 10px;
        }
        .progress-bar {
            border-radius: 10px;
            font-size: 1.2em;
        }
        .tracking-step {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .tracking-step div {
            text-align: center;
        }
        .tracking-icon {
            font-size: 24px;
            color: #007bff;
        }
        .payment-card {
            margin-top: 20px;
        }
    </style>

    <div class="page-header text-center" style="background-image: url('{{ asset('/') }}front/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Track My order</h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Track Order</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" style="margin-right: -6%">
                <!-- Order Tracking Form -->
                <div class="card">
                    <div class="card-body">
                        <form id="orderForm" action="{{ route('show.track-result') }}" method="GET">
                            <div class="form-group">
                                <label for="order-id">Order Code</label>
                                <input type="text" class="form-control" name="order_code" id="order-id" value="{{ $order_code }}" placeholder="Example: 123456-123456-12345" maxlength="19">
                                <small id="error-message" style="color: red; display: none;">The order code must be exactly 17 digits.</small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Track Order</button>
                        </form>
                    </div>
                </div>

                @if($order)
                    <!-- Order Progress -->
                    <div class="card mt-5">
                        <div class="card-header" style="margin-top: 3%;">
                            <h4>Order Progress</h4>
                        </div>
                        <div class="card-body">
                            <div class="progress">
                                @if($order->order_status == 'pending')
                                    <div class="progress-bar bg-success" style="width: 25%;">Pending</div>
                                @elseif($order->order_status == 'proccessing')
                                    <div class="progress-bar bg-success" style="width: 50%;">Processing</div>
                                @elseif($order->order_status == 'shipped')
                                    <div class="progress-bar bg-success" style="width: 75%;">Shipped</div>
                                @elseif($order->order_status == 'delivered')
                                    <div class="progress-bar bg-success" style="width: 100%;">Delivered</div>
                                @else
                                    <div class="progress-bar bg-danger" style="width: 100%;">Cancelled</div>
                                @endif
                            </div>

                            <!-- Step by Step Tracking -->
                            <div class="tracking-step mt-4">
                                <div>
                                    <span class="tracking-icon">&#128221;</span><br>
                                    <small>Order Placed</small>
                                </div>
                                <div>
                                    <span class="tracking-icon">&#128736;</span><br>
                                    <small>Processing</small>
                                </div>
                                <div>
                                    <span class="tracking-icon">&#128666;</span><br>
                                    <small>Shipped</small>
                                </div>
                                <div>
                                    <span class="tracking-icon">&#128230;</span><br>
                                    <small>Delivery</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="card payment-card">
                        <div class="card-header" style="margin-top: 3%;">
                            <h4>Payment Status</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Payment Method:</strong> {{ \Illuminate\Support\Str::ucfirst($order->payment_method) }}</p>
                                    <p><strong>Payment Status:</strong>
                                        @if($order->payment_status == 'pending')
                                            <span class="badge badge-danger">Pending</span>
                                        @elseif($order->payment_status == 'paid')
                                            <span class="badge badge-success">Paid</span>
                                        @else
                                            <span class="badge badge-danger">Unpaid</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Total Payable:</strong> ৳ {{ $order->grand_total + $order->shipping_cost }}</p>
                                    <p><strong>Order Date:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card mt-3">
                        <div class="card-body">
                            <p class="text-center text-danger" style="font-size: 1.8em;">Sorry! Order not found.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


    <!-- স্ক্রিপ্ট -->
    <script>
        const orderInput = document.getElementById('order-id');
        const form = document.getElementById('orderForm');
        const errorMessage = document.getElementById('error-message');

        orderInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            if (value.length > 17) {
                value = value.slice(0, 17);
            }

            if (value.length > 6) {
                value = value.replace(/(\d{6})(\d{1,6})/, '$1-$2');
            }
            if (value.length > 12) {
                value = value.replace(/(\d{6})-(\d{6})(\d{1,5})/, '$1-$2-$3');
            }

            e.target.value = value;
        });

        form.addEventListener('submit', function(e) {
            const inputVal = orderInput.value.replace(/\D/g, '');

            if (inputVal.length !== 17) {
                e.preventDefault();
                errorMessage.style.display = 'block';
            } else {
                errorMessage.style.display = 'none';
            }
        });
    </script>
@endsection
