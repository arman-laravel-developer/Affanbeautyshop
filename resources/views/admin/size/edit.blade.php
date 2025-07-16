@extends('admin.master')
@section('title')
    Brand Edit | {{env('APP_NAME')}}
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
                <h4 class="page-title">Brand Edit</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">

        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('brand.update', ['id' => $brand->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{$brand->name}}" name="name" id="inputEmail3" placeholder="Brand name"/>
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label">Logo</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" id="inputEmail34"/>
                            <img src="{{asset($brand->logo)}}" style="height: 150px; width: 150px; margin-top: 2px;" alt="">
                            @error('logo')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3w" class="col-form-label">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" value="{{$brand->meta_title}}" name="meta_title" id="inputEmail3w" placeholder="meta title"/>
                            @error('meta_title')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label">Meta Description</label>
                            <textarea type="text" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" aria-describedby="emailHelp" placeholder="Meta Description">{{$brand->meta_description}}</textarea>
                            @error('meta_description')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <button type="submit" class="btn btn-primary float-end">Submit</button>
                        </div>
                    </form>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-lg-3">

        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <script>
        $('#summernote').summernote({
            tabsize: 2,
            height: 300
        });
    </script>

@endsection



