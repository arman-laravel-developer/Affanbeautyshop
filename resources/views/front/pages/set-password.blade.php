@extends('front.master')

@section('title')
{{$generalSettingView->site_name}} - Forget Password
@endsection

@section('body')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                        <form action="{{ route('save.password') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="input-group mb-3">
                                <input type="password" id="password" name="password" class="form-control form-control-rounded @error('password') is-invalid @enderror" placeholder="New Password" required>
                                <span class="input-group-text" id="toggle-password" onclick="togglePasswordVisibility()">
            <i class="fa fa-eye" id="eye-icon" style="font-size: 14px;"></i>
        </span>
                            </div>
                            @error('password')
                            <div class="alert alert-danger mb-2">{{ $message }}</div>
                            @enderror

                            <div class="input-group mb-3">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-rounded @error('password_confirmation') is-invalid @enderror" placeholder="Confirm New Password" required>
                                <span class="input-group-text" id="toggle-password-confirm" onclick="togglePasswordConfirmationVisibility()">
            <i class="fa fa-eye" id="eye-icon-confirm" style="font-size: 14px;"></i>
        </span>
                            </div>
                            @error('password_confirmation')
                            <div class="alert alert-danger mb-2">{{ $message }}</div>
                            @enderror

                            <button class="btn btn-primary" type="submit"><span>Save Password</span><i class="icon-long-arrow-right"></i></button>
                        </form>

                        <script>
                            function togglePasswordVisibility() {
                                var passwordField = document.getElementById('password');
                                var eyeIcon = document.getElementById('eye-icon');

                                if (passwordField.type === 'password') {
                                    passwordField.type = 'text';
                                    eyeIcon.classList.remove('fa-eye');
                                    eyeIcon.classList.add('fa-eye-slash');
                                } else {
                                    passwordField.type = 'password';
                                    eyeIcon.classList.remove('fa-eye-slash');
                                    eyeIcon.classList.add('fa-eye');
                                }
                            }

                            function togglePasswordConfirmationVisibility() {
                                var passwordFieldConfirm = document.getElementById('password_confirmation');
                                var eyeIconConfirm = document.getElementById('eye-icon-confirm');

                                if (passwordFieldConfirm.type === 'password') {
                                    passwordFieldConfirm.type = 'text';
                                    eyeIconConfirm.classList.remove('fa-eye');
                                    eyeIconConfirm.classList.add('fa-eye-slash');
                                } else {
                                    passwordFieldConfirm.type = 'password';
                                    eyeIconConfirm.classList.remove('fa-eye-slash');
                                    eyeIconConfirm.classList.add('fa-eye');
                                }
                            }
                        </script>
                    </div><!-- End .cta-wrapper -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

    </div><!-- End .page-content -->

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            var password = document.querySelector('input[name="password"]').value;
            var confirmPassword = document.querySelector('input[name="password_confirmation"]').value;

            if (password !== confirmPassword) {
                e.preventDefault(); // Stop form submission
                alert('Passwords do not match!');
            }
        });
    </script>

@endsection
