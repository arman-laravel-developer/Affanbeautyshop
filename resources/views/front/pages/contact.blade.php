@extends('front.master')

@section('title')
{{$generalSettingView->site_name}} - Contact us
@endsection

@section('body')
    <div class="page-header text-center" style="background-image: url('{{asset('/')}}front/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Contact us</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact us</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <!-- অফিস ঠিকানা -->
                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h3>Office Address</h3>
                        <address>{{$generalSettingView->address}}</address>
                    </div>
                </div>

                <!-- যোগাযোগের তথ্য -->
                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h3>Contact us</h3>
                        <div><a href="mailto:{{$generalSettingView->email}}">{{$generalSettingView->email}}</a></div>
                        <div><a href="tel:{{$generalSettingView->mobile}}">{{$generalSettingView->mobile}}</a></div>
                    </div>
                </div>

                <!-- সোশ্যাল মিডিয়া -->
                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h3>Social Media</h3>
                        <div class="social-icons social-icons-color justify-content-center">
                            <a href="{{$generalSettingView->facebook_url}}" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                            <a href="{{$generalSettingView->twitter_url}}" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                            <a href="{{$generalSettingView->instagram_url}}" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                            <a href="{{$generalSettingView->youtube_url}}" class="social-icon social-youtube" title="YouTube" target="_blank"><i class="icon-youtube"></i></a>
                            <a href="{{$generalSettingView->pinterest_url}}" class="social-icon social-pinterest" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="mt-3 mb-5 mt-md-1">

            <!-- Contact Form -->
            <div class="touch-container row justify-content-center">
                <div class="col-md-9 col-lg-7">
                    <div class="text-center">
                        <h2 class="title mb-1">Get in Touch</h2>
                        <p class="lead text-primary">
                            We love working with passionate individuals and brands — let’s create something amazing together.
                        </p>
                    </div>

                    <form action="{{ route('contact-form.submit') }}" class="contact-form mb-2" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="cname" class="sr-only">Name</label>
                                <input type="text" class="form-control" id="cname" name="name" placeholder="Your Name *" required>
                            </div>

                            <div class="col-sm-4">
                                <label for="cemail" class="sr-only">Email</label>
                                <input type="email" class="form-control" id="cemail" name="email" placeholder="Email Address *" required>
                            </div>

                            <div class="col-sm-4">
                                <label for="cphone" class="sr-only">Phone</label>
                                <input type="tel" class="form-control" id="cphone" name="phone" placeholder="Phone Number *" required>
                            </div>
                        </div>

                        <label for="csubject" class="sr-only">Subject</label>
                        <input type="text" class="form-control" id="csubject" name="subject" placeholder="Subject *" required>

                        <label for="cmessage" class="sr-only">Message</label>
                        <textarea class="form-control" cols="30" rows="4" id="cmessage" name="message" required placeholder="Write your message *"></textarea>

                        <div class="text-center">
                            <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
                                <span>Send Message</span>
                                <i class="icon-long-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
