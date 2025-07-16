@extends('admin.master')
@section('title')
    Category Edit | {{env('APP_NAME')}}
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
                <h4 class="page-title">Category Edit</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="basic-form-preview">
                            <form action="{{route('category.update', ['id' => $category->id])}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-2 col-form-label">Under Category</label>
                                    <div class="col-10">
                                        <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                                            <option value="0">Main Category</option>
                                            @foreach($categories as $categorya)
                                                <option value="{{$categorya->id}}"  @if($categorya->id == $category->parent_id) selected @endif>{{$categorya->category_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('parent_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-2 col-form-label">Category Name</label>
                                    <div class="col-10">
                                        <input type="text" value="{{$category->category_name}}" class="form-control @error('category_name') is-invalid @enderror" name="category_name" id="inputEmail3" placeholder="Category name"/>
                                        @error('category_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-2 col-form-label">Description</label>
                                    <div class="col-10">
                                        <textarea type="text" name="description" class="form-control @error('description') is-invalid @enderror" aria-describedby="emailHelp" placeholder="Enter Short Description">{{$category->description}}</textarea>
                                        @error('description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-2 col-form-label">Image</label>
                                    <div class="col-md-10">
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="inputEmail34"/>
                                        <img src="{{asset($category->image)}}" style="height: 100px; width: 100px;" alt="">
                                        @error('image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @if($category->parent_id == 0)
                                    <div id="displayStatus">
                                        <div class="row mb-3">
                                            <label for="inputEmail3" class="col-md-2 col-form-label">Dispaly Status</label>
                                            <div class="col-md-10">
                                                <input type="checkbox" id="switch12" value="1" class="form-control"  @if($category->display_status == 1) checked @endif name="display_status" data-switch="bool"/>
                                                <label for="switch12" data-on-label="On" data-off-label="Off"></label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-2 col-form-label">Status</label>
                                    <div class="col-10">
                                        {{--                                        <input type="checkbox" id="switch1" name="status" @if($notice->status == 1) checked @endif data-switch="bool"/>--}}
                                        <input type="checkbox" id="switch{{$category->id}}" class="form-control" value="1" @if($category->status == 1) checked @endif name="status" data-switch="bool"/>
                                        <label for="switch{{$category->id}}" data-on-label="On" data-off-label="Off"></label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-2 col-form-label"></label>
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->

                </div> <!-- end card-body-->
            </div> <!-- end card-->
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



