@extends('front.master')

@section('title')
{{$generalSettingView->site_name}} - Return And Refund Policies
@endsection

@section('body')
    <div class="page-header text-center" style="background-image: url('{{asset('/')}}front/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Return And Refund Policies<span>Pages</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">

        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            {{--            <div class="row">--}}
            {{--                <div class="col-md-4">--}}
            {{--                    <hr style="border: solid dodgerblue 1px">--}}
            {{--                </div>--}}
            {{--                <div class="col-md-4">--}}
            {{--                    <p class="text-center" style="font-size: 2em; color: dodgerblue">Terms & Conditions</p>--}}
            {{--                </div>--}}
            {{--                <div class="col-md-4 ">--}}
            {{--                    <hr style="border: solid dodgerblue 1px">--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div class="accordion accordion-rounded">
                <p>{!! $return->return !!}</p>
            </div><!-- End .accordion -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
@endsection
