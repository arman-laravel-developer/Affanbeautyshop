@extends('admin.master')
@section('title')
    About us Add | {{env('APP_NAME')}}
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
                <h4 class="page-title">About us Add</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="basic-form-preview">
                            <form action="{{route('about-us.new')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="about_id" value="{{optional($about)->id}}">
                                <div class="row mb-3">
                                    <label class="col-md-2 col-form-label">Who we are text</label>
                                    <div class="col-md-10">
                                        <textarea type="text" id="summernote" name="who_we_are" class="form-control @error('who_we_are') is-invalid @enderror" aria-describedby="emailHelp" placeholder="Enter Short Description">
                                            {{optional($about)->who_we_are}}
                                        </textarea>
                                        @error('who_we_are')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-2 col-form-label">Image</label>
                                    <div class="col-md-10">
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="imageInput" name="image"/>
                                        <img id="imagePreview" class="mt-1" src="{{asset(optional($about)->image)}}" alt="Preview" style="max-width: 200px; max-height: 200px;">
                                        @error('image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10">
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
    <script>
        $('#summernote').summernote({
            tabsize: 2,
            height: 300
        });
    </script>
    <!-- end row -->

    <script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function(){
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }

        var imageInput = document.getElementById('imageInput');
        imageInput.addEventListener('change', previewImage);
    </script>



@endsection



