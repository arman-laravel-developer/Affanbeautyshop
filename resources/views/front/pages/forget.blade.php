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
{{--                        <p class="cta-desc">Lorem ipsum dolor sit amet adipiscing.</p><!-- End .cta-desc -->--}}
                        <form action="{{route('forget.password-send-code')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="email" name="email" class="form-control form-control-rounded" placeholder="Enter your Email address" aria-label="Email Adress" required>
                            <button class="btn btn-primary" type="submit"><span>Send OTP</span><i class="icon-long-arrow-right"></i></button>
                        </form>
                        <div class="mt-2">
                            <a href="#signin-modal" data-toggle="modal" class="pt-3">Back to Login</a>
                        </div>
                    </div><!-- End .cta-wrapper -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

    </div><!-- End .page-content -->
@endsection
