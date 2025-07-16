@extends('front.master')

@section('title')
    {{$generalSettingView->site_name}} - অর্ডার ট্র্যাক করুন
@endsection

@section('body')
    <style>
        .progress {
            height: 20px;
            border-radius: 10px;
        }
        .progress-bar {
            border-radius: 10px;
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

    <div class="page-header text-center" style="background-image: url('{{asset('/')}}front/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">অর্ডার ট্র্যাক করুন</h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">হোম</a></li>
                <li class="breadcrumb-item active" aria-current="page">অর্ডার ট্র্যাক করুন</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8" style="margin-right: -6%">
                    <!-- অর্ডার ট্র্যাকিং ফর্ম -->
                    <div class="card">
                        <div class="card-body">
                            <form id="orderForm" action="{{route('show.track-result')}}" method="GET">
                                <div class="form-group">
                                    <label for="order-id">অর্ডার কোড</label>
                                    <input type="text" class="form-control" name="order_code" id="order-id" placeholder="xxxxxx-xxxxxx-xxxxx" maxlength="19">
                                    <small id="error-message" style="color: red; display: none;">অর্ডার কোডটি অবশ্যই ১৭ সংখ্যার হতে হবে।</small>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">ট্র্যাক করুন</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const orderInput = document.getElementById('order-id');
        const form = document.getElementById('orderForm');
        const errorMessage = document.getElementById('error-message');

        orderInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // শুধু সংখ্যাগুলি রাখুন

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
