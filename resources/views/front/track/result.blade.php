@extends('front.master')

@section('title')
    {{ $generalSettingView->site_name }} - আমার অর্ডার ট্র্যাক করুন
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
            <h1 class="page-title">আমার অর্ডার ট্র্যাক করুন</h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">হোম</a></li>
                <li class="breadcrumb-item active" aria-current="page">অর্ডার ট্র্যাক</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8" style="margin-right: -6%">
                    <!-- অর্ডার ট্র্যাক ফর্ম -->
                    <div class="card">
                        <div class="card-body">
                            <form id="orderForm" action="{{ route('show.track-result') }}" method="GET">
                                <div class="form-group">
                                    <label for="order-id">অর্ডার কোড</label>
                                    <input type="text" class="form-control" name="order_code" id="order-id" value="{{ $order_code }}" placeholder="উদাহরণ: ১২৩৪৫৬-১২৩৪৫৬-১২৩৪৫" maxlength="19">
                                    <small id="error-message" style="color: red; display: none;">অর্ডার কোড অবশ্যই ১৭ সংখ্যার হতে হবে।</small>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">অর্ডার ট্র্যাক করুন</button>
                            </form>
                        </div>
                    </div>

                @if($order)
                    <!-- অর্ডার অগ্রগতি -->
                        <div class="card mt-5">
                            <div class="card-header" style="margin-top: 3%;">
                                <h4>অর্ডার অগ্রগতি</h4>
                            </div>
                            <div class="card-body">
                                <div class="progress">
                                    @if($order->order_status == 'pending')
                                        <div class="progress-bar bg-success" style="width: 25%;">অপেক্ষমাণ</div>
                                    @elseif($order->order_status == 'proccessing')
                                        <div class="progress-bar bg-success" style="width: 50%;">প্রসেসিং</div>
                                    @elseif($order->order_status == 'shipped')
                                        <div class="progress-bar bg-success" style="width: 75%;">রওনা হয়েছে</div>
                                    @elseif($order->order_status == 'delivered')
                                        <div class="progress-bar bg-success" style="width: 100%;">ডেলিভারি সম্পন্ন</div>
                                    @else
                                        <div class="progress-bar bg-danger" style="width: 100%;">বাতিল</div>
                                    @endif
                                </div>

                                <!-- ধাপে ধাপে ট্র্যাকিং -->
                                <div class="tracking-step mt-4">
                                    <div>
                                        <span class="tracking-icon">&#128221;</span><br>
                                        <small>অর্ডার হয়েছে</small>
                                    </div>
                                    <div>
                                        <span class="tracking-icon">&#128736;</span><br>
                                        <small>প্রসেসিং</small>
                                    </div>
                                    <div>
                                        <span class="tracking-icon">&#128666;</span><br>
                                        <small>রওনা হয়েছে</small>
                                    </div>
                                    <div>
                                        <span class="tracking-icon">&#128230;</span><br>
                                        <small>ডেলিভারি</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- পেমেন্ট অবস্থা -->
                        <div class="card payment-card">
                            <div class="card-header" style="margin-top: 3%;">
                                <h4>পেমেন্ট স্ট্যাটাস</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>পেমেন্ট মাধ্যম:</strong> {{ \Illuminate\Support\Str::ucfirst($order->payment_method) }}</p>
                                        <p><strong>পেমেন্ট স্ট্যাটাস:</strong>
                                            @if($order->payment_status == 'pending')
                                                <span class="badge badge-danger">অপেক্ষমাণ</span>
                                            @elseif($order->payment_status == 'paid')
                                                <span class="badge badge-success">পরিশোধিত</span>
                                            @else
                                                <span class="badge badge-danger">অপরিশোধিত</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>মোট পরিশোধযোগ্য:</strong> ৳ {{ $order->grand_total + $order->shipping_cost }}</p>
                                        <p><strong>অর্ডারের তারিখ:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card mt-3">
                            <div class="card-body">
                                <p class="text-center text-danger" style="font-size: 1.8em;">দুঃখিত! অর্ডার পাওয়া যায়নি।</p>
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
