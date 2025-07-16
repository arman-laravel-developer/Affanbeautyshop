@extends('front.master')

@section('title')
{{$generalSettingView->site_name}} - Forget Password
@endsection

@section('body')
    <div class="page-header text-center" style="background-image: url('{{asset('/')}}front/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Forget Password</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Forget Password</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content pb-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="cta-wrapper text-center pt-0 pb-0">
{{--                        <h3 class="cta-title">Join Our Newsletter</h3><!-- End .cta-title -->--}}
                        <p class="cta-desc text-success">{!! Session::get('message') !!}</p><!-- End .cta-desc -->
                        <h4 class="text-danger text-center">{{Session::get('invaild_message')}}</h4>
                        <form action="{{route('otp.check')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="otp" class="form-control form-control-rounded" placeholder="Enter OTP" aria-label="OTP" required maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);">
                            <button class="btn btn-primary" type="submit"><span>Verify</span><i class="icon-long-arrow-right"></i></button>
                        </form>
                        <div class="mt-2">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('resendForm').submit();" id="resendOtpLink" class="pt-3" style="pointer-events: none; color: grey;">
                                Resend OTP <span id="countdown"></span>
                            </a>
                            <form action="{{ route('resend.otp') }}" method="POST" id="resendForm">
                                @csrf
                            </form>
                        </div>
                    </div><!-- End .cta-wrapper -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

    </div><!-- End .page-content -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var remainingTime = {{ $remainingTime }};
            var resendLink = document.getElementById('resendOtpLink');
            var countdown = document.getElementById('countdown');

            if (remainingTime > 0) {
                countdown.innerText = 'available in ' + remainingTime + ' seconds';

                var interval = setInterval(function() {
                    remainingTime--;
                    countdown.innerText = 'available in ' + remainingTime + ' seconds';

                    if (remainingTime <= 0) {
                        clearInterval(interval);
                        resendLink.style.pointerEvents = 'auto';
                        resendLink.style.color = 'blue'; // Change to your preferred active link color
                        countdown.innerText = ''; // Remove countdown text when available
                    }
                }, 1000);
            } else {
                resendLink.style.pointerEvents = 'auto';
                resendLink.style.color = 'blue'; // Active link color
            }
        });
    </script>
@endsection
