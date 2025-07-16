@extends('front.master')

@section('title')
    {{ $generalSettingView->site_name }} - আমাদের সম্পর্কে
@endsection

@section('body')
    <div class="page-header text-center" style="background-image: url('{{ asset('/') }}front/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">আমাদের সম্পর্কে</h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">হোম</a></li>
                <li class="breadcrumb-item active" aria-current="page">আমাদের সম্পর্কে</li>
            </ol>
        </div>
    </nav>

    <div class="page-content pb-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="about-text text-center mt-3">
                        <h2 class="title text-center mb-2">আমরা কারা?</h2>
                        <p>{!! $about->who_we_are !!}</p>

                        @if($about->image)
                            <img src="{{ asset($about->image) }}" alt="আমাদের ছবি" class="mx-auto mb-5 mt-3" style="max-width: 100%; height: auto;">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
