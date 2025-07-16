@extends('admin.master')
@section('title')
    Setup And Configarations manage | {{env('APP_NAME')}}
@endsection

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-light" id="dash-daterange">
                            <span class="input-group-text bg-primary border-primary text-white">
                                                    <i class="mdi mdi-calendar-range font-13"></i>
                                                </span>
                        </div>
                        <a href="javascript: void(0);" class="btn btn-primary ms-2">
                            <i class="mdi mdi-autorenew"></i>
                        </a>
                        <a href="javascript: void(0);" class="btn btn-primary ms-1">
                            <i class="mdi mdi-filter-variant"></i>
                        </a>
                    </form>
                </div>
                <h4 class="page-title">Google Analytics</h4>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('google-analytic.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <p class="page-title"><b>Facebook Pixel Setting</b></p>
                        <input type="hidden" value="{{optional($googleSetup)->id}}" name="google_analytic_id">
                        <div class="row mb-3">
                            <label for="inputEmail39" class="col-md-4 col-form-label">Status</label>
                            <div class="col-md-8">
                                <input type="checkbox" id="switch1" value="1" class="form-control" @if(optional($googleSetup)->facebook_pixel_status == 1) checked @endif name="facebook_pixel_status" data-switch="bool"/>
                                <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail38" class="col-md-4 col-form-label">Facebook pixel id</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control @error('facebook_pixel') is-invalid @enderror" value="{{optional($googleSetup)->facebook_pixel}}" name="facebook_pixel" id="inputEmail38" placeholder="Facebook pixel id"/>
                                @error('facebook_pixel')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail37" class="col-md-4 col-form-label"></label>
                            <div class="col-md-8">
                                <button type="submit" name="button" value="1" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('google-analytic.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <p class="page-title"><b>Google Analytics Setting</b></p>
                        <input type="hidden" value="{{optional($googleSetup)->id}}" name="google_analytic_id">
                        <div class="row mb-3">
                            <label for="inputEmail36" class="col-md-4 col-form-label">Status</label>
                            <div class="col-md-8">
                                <input type="checkbox" id="switch2" value="1" class="form-control" @if(optional($googleSetup)->google_analytics_status == 1) checked @endif name="google_analytics_status" data-switch="bool"/>
                                <label for="switch2" data-on-label="On" data-off-label="Off"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail35" class="col-md-4 col-form-label">Tracking id</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control @error('google_analytics') is-invalid @enderror" value="{{optional($googleSetup)->google_analytics}}" name="google_analytics" id="inputEmail35" placeholder="G-XXXXXXXXXX"/>
                                @error('google_analytics')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail34" class="col-md-4 col-form-label"></label>
                            <div class="col-md-8">
                                <button type="submit" name="button" value="2" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('google-analytic.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <p class="page-title"><b>Google Tag Manager Setting</b></p>
                        <input type="hidden" value="{{optional($googleSetup)->id}}" name="google_analytic_id">
                        <div class="row mb-3">
                            <label for="inputEmail34" class="col-md-4 col-form-label">Status</label>
                            <div class="col-md-8">
                                <input type="checkbox" id="switch3" value="1" class="form-control" @if(optional($googleSetup)->tag_manager_status == 1) checked @endif name="tag_manager_status" data-switch="bool"/>
                                <label for="switch3" data-on-label="On" data-off-label="Off"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail33" class="col-md-4 col-form-label">Tag manager id</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control @error('tag_manager') is-invalid @enderror" value="{{optional($googleSetup)->tag_manager}}" name="tag_manager" id="inputEmail33" placeholder="Tag manager id"/>
                                @error('tag_manager')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail33" class="col-md-4 col-form-label"></label>
                            <div class="col-md-8">
                                <button type="submit" name="button" value="3" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>



@endsection




