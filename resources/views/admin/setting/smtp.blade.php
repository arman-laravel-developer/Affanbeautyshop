@extends('admin.master')
@section('title')
    Setting Module | {{env('APP_NAME')}}
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
                <h4 class="page-title">Setting Module</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('setting.smtp-update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class=" col-form-label">MAIL_MAILER</label>
                            <div class="">
                                <input type="text" name="MAIL_MAILER" value="{{ env('MAIL_MAILER') }}" class="form-control @error('MAIL_MAILER') is-invalid @enderror">
                                @error('MAIL_MAILER')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class=" col-form-label">MAIL_HOST</label>
                            <div class="">
                                <input type="text" name="MAIL_HOST" value="{{ env('MAIL_HOST') }}" class="form-control @error('MAIL_HOST') is-invalid @enderror">
                                @error('MAIL_HOST')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class=" col-form-label">MAIL_PORT</label>
                            <div class="">
                                <input type="text" name="MAIL_PORT" value="{{ env('MAIL_PORT') }}" class="form-control @error('MAIL_PORT') is-invalid @enderror">
                                @error('MAIL_PORT')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class=" col-form-label">MAIL_USERNAME</label>
                            <div class="">
                                <input type="text" name="MAIL_USERNAME" value="{{ env('MAIL_USERNAME') }}" class="form-control @error('MAIL_USERNAME') is-invalid @enderror">
                                @error('MAIL_USERNAME')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class=" col-form-label">MAIL_PASSWORD</label>
                            <div class="">
                                <input type="text" name="MAIL_PASSWORD" value="{{ env('MAIL_PASSWORD') }}" class="form-control @error('MAIL_PASSWORD') is-invalid @enderror">
                                @error('MAIL_PASSWORD')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class=" col-form-label">MAIL_ENCRYPTION</label>
                            <div class="">
                                <input type="text" name="MAIL_ENCRYPTION" value="{{ env('MAIL_ENCRYPTION') }}" class="form-control @error('MAIL_ENCRYPTION') is-invalid @enderror">
                                @error('MAIL_ENCRYPTION')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class=" col-form-label">MAIL_FROM_ADDRESS</label>
                            <div class="">
                                <input type="text" name="MAIL_FROM_ADDRESS" value="{{ env('MAIL_FROM_ADDRESS') }}" class="form-control @error('MAIL_FROM_ADDRESS') is-invalid @enderror">
                                @error('MAIL_FROM_ADDRESS')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class=" col-form-label">MAIL_FROM_NAME</label>
                            <div class="">
                                <input type="text" name="MAIL_FROM_NAME" value="{{ env('MAIL_FROM_NAME') }}" class="form-control @error('MAIL_FROM_NAME') is-invalid @enderror">
                                @error('MAIL_FROM_NAME')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class=" col-form-label"></label>
                            <div class="">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('test.mail')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class=" col-form-label">Email</label>
                            <div class="">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email">
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class=" col-form-label"></label>
                            <div class="">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

@endsection




