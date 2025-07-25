@extends('admin.master')
@section('title')
    Product Edit | {{env('APP_NAME')}}
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
                <h4 class="page-title">Product Edit</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="{{route('product.update', ['id' => $product->id])}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" style="margin-bottom: -4%;">
                                <h4>Product Information</h4>
                            </div>
                            <hr/>
                            <div class="card-body" style="margin-top: -2%">
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" style="font-size: 90%">Product Name<sup class="text-danger">*</sup></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{$product->name}}" name="name" placeholder="Product name" required/>
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" style="font-size: 90%">Category<sup class="text-danger">*</sup></label>
                                    <div class="col-md-9">
                                        <select name="category_id" id="" class="selectpicker form-control @error('category_id') is-invalid @enderror" data-live-search="true" required>
                                            @php echo $categories_dropdown @endphp
                                        </select>
                                        @error('category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" style="font-size: 90%">Brand</label>
                                    <div class="col-md-9">
                                        <select name="brand_id" id="" class="selectpicker form-control @error('brand_id') is-invalid @enderror" data-live-search="true">
                                            <option value="" selected disabled>Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand->id}}" {{$product->brand_id == $brand->id ? 'selected':''}}>{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" style="font-size: 90%">Unit<sup class="text-danger">*</sup></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('unit') is-invalid @enderror" value="{{$product->unit}}" name="unit" placeholder="Unit (eg:KG,Pc)" required/>
                                        @error('unit')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" style="font-size: 90%">
                                        Minimum Purchase qty<sup class="text-danger">*</sup>
                                    </label>
                                    <div class="col-md-9">
                                        <input
                                            type="text"
                                            class="form-control @error('minimum_purchase_qty') is-invalid @enderror"
                                            name="minimum_purchase_qty"
                                            value="{{$product->minimum_purchase_qty}}"
                                            required
                                            oninput="validateInput(this)"
                                        />
                                        @error('minimum_purchase_qty')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" style="font-size: 90%">Tags<sup class="text-danger">*</sup></label>
                                    <div class="col-md-9">
                                        <input type="text" id="tags" value="{{$product->tags}}" class="form-control @error('tags') is-invalid @enderror" name="tags" placeholder="ex: fashion, men's fashion, t-shirt, etc" required/>
                                        @error('tags')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" style="margin-bottom: -4%;">
                                <h4>Product Images</h4>
                            </div>
                            <hr/>
                            <div class="card-body" style="margin-top: -2%">
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label">Thumbnail Image <br>
                                        <small>340 x 345</small>
                                    </label>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control @error('thumbnail_img') is-invalid @enderror" id="imageInput" name="thumbnail_img"/>
                                        <img id="imagePreview" class="mt-1" src="{{asset($product->thumbnail_img)}}" alt="Preview" style="max-width: 200px; max-height: 200px;">
                                        @error('thumbnail_img')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label">Gallery Image <br>
                                        <small>340 x 345</small>
                                    </label>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control @error('galleryImage') is-invalid @enderror" id="imageInputGallery" name="galleryImages[]" multiple/>
                                        <div id="imagePreviews" class="mt-1">
                                            <!-- Existing Images -->
                                            @foreach($product->otherImages as $otherImage)
                                                <img src="{{ asset($otherImage->gellery_image) }}" alt="Existing Image" style="display: inline-block; margin-right: 10px; max-width: 80px; max-height: 100px;" class="mt-1 existing-image">
                                            @endforeach
                                        </div>
                                        @error('galleryImage')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" style="margin-bottom: -4%;">
                                <h4>Product Variation</h4>
                            </div>
                            <hr/>
                            <div class="card-body" style="margin-top: -2%">
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label">Product Variation</label>
                                    <div class="col-md-9">
                                        <select name="is_variant" id="is_variation" class="form-control @error('color') is-invalid @enderror">
                                            <option value="">Select option</option>
                                            <option value="yes" {{$product->is_variant == 1 ? 'selected': ''}}>Yes</option>
                                            <option value="no" {{$product->is_variant == 2 ? 'selected': ''}}>No</option>
                                        </select>
                                        @error('image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div id="variation_active" style="display: none;">
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Color</label>
                                        <div class="col-md-9">
                                            <select name="color_id[]" id="colors" data-selected-text-format="count" class="selectpicker form-control @error('color') is-invalid @enderror select-enabled" multiple>
                                                @foreach($colors as $color)
                                                    <option value="{{ $color->id }}" {{ in_array($color->id, $selectedColorIds) ? 'selected' : '' }}>
                                                        {{ $color->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('color')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Size</label>
                                        <div class="col-md-9">
                                            <select name="size_id[]" id="sizes" class="selectpicker form-control @error('size') is-invalid @enderror" data-selected-text-format="count" multiple>
                                                @foreach($sizes as $size)
                                                    <option value="{{ $size->id }}" {{ in_array($size->id, $selectedSizeIds) ? 'selected' : '' }}>
                                                        {{ $size->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('size')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" style="margin-bottom: -4%;">
                                <h4>Product price + stock</h4>
                            </div>
                            <hr/>
                            <div class="card-body" style="margin-top: -2%">
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label">Unit price<sup class="text-danger">*</sup></label>
                                    <div class="col-md-9">
                                        <input type="number" name="sell_price" value="{{$product->sell_price}}" class="form-control @error('sell_price') is-invalid @enderror" placeholder="Unit price" required/>
                                        @error('sell_price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label">Cost price<sup class="text-danger">*</sup></label>
                                    <div class="col-md-9">
                                        <input type="number" name="cost_price" value="{{$product->cost_price}}" class="form-control @error('cost_price') is-invalid @enderror" placeholder="Cost price" required/>
                                        @error('cost_price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
{{--                                @php--}}
{{--                                    use Carbon\Carbon;--}}

{{--                                    $startDate = $product->start_date ? Carbon::parse($product->start_date)->format('m/d/Y') : '';--}}
{{--                                    $endDate = $product->end_date ? Carbon::parse($product->end_date)->format('m/d/Y') : '';--}}
{{--                                @endphp--}}

{{--                                <div class="row mb-3">--}}
{{--                                    <label class="col-md-3 col-form-label">Discount Range Date</label>--}}
{{--                                    <div class="col-md-9">--}}
{{--                                        <input--}}
{{--                                            type="text"--}}
{{--                                            class="form-control date"--}}
{{--                                            name="discount_date_range"--}}
{{--                                            id="singledaterange"--}}
{{--                                            data-toggle="date-picker"--}}
{{--                                            data-cancel-class="btn-warning"--}}
{{--                                            required--}}
{{--                                            value="{{ $startDate && $endDate ? $startDate . ' - ' . $endDate : '' }}"--}}
{{--                                        >--}}
{{--                                        @error('discount_date_range')--}}
{{--                                        <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label">Discount</label>
                                    <div class="col-md-7">
                                        <input type="number" name="discount" value="{{$product->discount}}" class="form-control @error('discount') is-invalid @enderror" placeholder="Discount"/>
                                        @error('discount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <select name="discount_type" id="" class="form-control">
                                            <option value="1" {{$product->discount_type == 1 ? 'selected' : ''}}>Flat</option>
                                            <option value="2" {{$product->discount_type == 2 ? 'selected' : ''}}>Percent</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label">Quantity<sup class="text-danger">*</sup></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('stock') is-invalid @enderror" value="{{$product->stock}}" name="stock" required>
                                        @error('stock')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div id="variantInputsContainer" style="display: none;" class="mb-3">
                                    <!-- Variant inputs will be inserted here -->
                                </div>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" style="margin-bottom: -4%;">
                                <h4>Product Description</h4>
                            </div>
                            <hr/>
                            <div class="card-body" style="margin-top: -2%">
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Description</label>
                                    <div class="col-md-9">
                                        <textarea type="text" name="description" id="summernote" class="form-control @error('description') is-invalid @enderror" aria-describedby="emailHelp" placeholder="Enter Short Description" required>{{$product->description}}</textarea>
                                        @error('description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="card-body" style="margin-top: -2%">
                                <div class="row">
                                    <label class="col-md-3 col-form-label">Ingredients</label>
                                    <div class="col-md-9">
                                        <textarea type="text" name="ingredients" id="summernote1" class="form-control @error('ingredients') is-invalid @enderror" aria-describedby="emailHelp" placeholder="Enter ingredients" required>{{$product->ingredients}}</textarea>
                                        @error('ingredients')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="card-body" style="margin-top: -2%">
                                <div class="row">
                                    <label class="col-md-3 col-form-label">How to use</label>
                                    <div class="col-md-9">
                                        <textarea type="text" name="how_to_use" id="summernote2" class="form-control @error('how_to_use') is-invalid @enderror" aria-describedby="emailHelp" placeholder="Enter how to use" required>{{$product->how_to_use}}</textarea>
                                        @error('how_to_use')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        <div class="card">--}}
{{--                            <div class="card-header" style="margin-bottom: -4%;">--}}
{{--                                <h4>Product Short Description</h4>--}}
{{--                            </div>--}}
{{--                            <hr/>--}}
{{--                            <div class="card-body" style="margin-top: -2%">--}}
{{--                                <div class="row mb-3">--}}
{{--                                    <label class="col-md-3 col-form-label">Active Short Description</label>--}}
{{--                                    <div class="col-md-9">--}}
{{--                                        <input type="checkbox" name="is_short_description" value="1" {{$product->is_short_description == 1 ? 'checked' : ''}} style="margin-top: 5%;margin-left: 1%">--}}
{{--                                        @error('short_description')--}}
{{--                                        <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <label class="col-md-3 col-form-label">Short Description</label>--}}
{{--                                    <div class="col-md-9">--}}
{{--                                        <textarea type="text" name="short_description" id="shot_summernote" class="form-control @error('short_description') is-invalid @enderror" aria-describedby="emailHelp" placeholder="Enter Short Description">{{$product->short_description}}</textarea>--}}
{{--                                        @error('short_description')--}}
{{--                                        <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="card">
                            <div class="card-header" style="margin-bottom: -4%;">
                                <h4>Seo Meta Tag</h4>
                            </div>
                            <hr/>
                            <div class="card-body" style="margin-top: -2%">
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label">Meta title</label>
                                    <div class="col-md-9">
                                        <input type="text" name="meta_title" value="{{$product->meta_title}}" class="form-control @error('meta_title') is-invalid @enderror" aria-describedby="emailHelp" placeholder="Meta title"/>
                                        @error('meta_title')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label">Meta Description</label>
                                    <div class="col-md-9">
                                        <textarea type="text" style="height: 200px" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" aria-describedby="emailHelp" placeholder="Enter Meta Description">{{$product->meta_description}}</textarea>
                                        @error('meta_description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label">Meta Image</label>
                                    <div class="col-md-9">
                                        <input type="file" name="meta_image" class="form-control @error('meta_image') is-invalid @enderror" aria-describedby="emailHelp"/>
                                        <img src="{{asset($product->meta_image)}}" alt="" style="height: 80px;" class="mt-2">
                                        @error('meta_image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
{{--                    <div class="col-md-4">--}}
{{--                                                <div class="card">--}}
{{--                                                    <div class="card-header" style="margin-bottom: -9%;">--}}
{{--                                                        <h4>Product Status</h4>--}}
{{--                                                    </div>--}}
{{--                                                    <hr/>--}}
{{--                                                    <div class="card-body" style="margin-top: -2%">--}}
{{--                                                        <div class="row mb-3">--}}
{{--                                                            <label class="col-md-7 col-form-label">Status</label>--}}
{{--                                                            <div class="col-md-5">--}}
{{--                                                                <input type="checkbox" id="switch1" value="1" class="form-control" name="status" data-switch="bool"/>--}}
{{--                                                                <label for="switch1" data-on-label="On" data-off-label="Off"></label>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-header" style="margin-bottom: -9%;">--}}
{{--                                <h4>Cash on Delivery</h4>--}}
{{--                            </div>--}}
{{--                            <hr/>--}}
{{--                            <div class="card-body" style="margin-top: -2%">--}}
{{--                                <div class="row mb-3">--}}
{{--                                    <label class="col-md-7 col-form-label">Status</label>--}}
{{--                                    <div class="col-md-5">--}}
{{--                                        <input type="checkbox" id="switch1" value="1" {{$product->cod_status == 1 ? 'checked' : ''}} class="form-control" name="cod_status" data-switch="bool"/>--}}
{{--                                        <label for="switch1" data-on-label="On" data-off-label="Off"></label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-header" style="margin-bottom: -9%;">--}}
{{--                                <h4>Featured</h4>--}}
{{--                            </div>--}}
{{--                            <hr/>--}}
{{--                            <div class="card-body" style="margin-top: -2%">--}}
{{--                                <div class="row mb-3">--}}
{{--                                    <label class="col-md-7 col-form-label">Status</label>--}}
{{--                                    <div class="col-md-5">--}}
{{--                                        <input type="checkbox" id="switch2" value="1" {{$product->is_featured == 1 ? 'checked' : ''}} class="form-control" name="is_featured" data-switch="bool"/>--}}
{{--                                        <label for="switch2" data-on-label="On" data-off-label="Off"></label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-header" style="margin-bottom: -9%;">--}}
{{--                                <h4>You May Also</h4>--}}
{{--                            </div>--}}
{{--                            <hr/>--}}
{{--                            <div class="card-body" style="margin-top: -2%">--}}
{{--                                <div class="row mb-3">--}}
{{--                                    <label class="col-md-7 col-form-label">Status</label>--}}
{{--                                    <div class="col-md-5">--}}
{{--                                        <input type="checkbox" id="switch3" value="1" {{$product->you_may_also == 1 ? 'checked' : ''}} class="form-control" name="you_may_also" data-switch="bool"/>--}}
{{--                                        <label for="switch3" data-on-label="On" data-off-label="Off"></label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-toolbar float-end mb-3" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group" style="margin-right: 1%; margin-left: -13%;" role="group" aria-label="First group">
                                <button type="submit" name="button" value="3"
                                        class="btn btn-warning">Save As Draft</button>
                            </div>
                            <div class="btn-group" style="margin-right: 1%" role="group" aria-label="Third group">
                                <button type="submit" name="button" value="2"
                                        class="btn btn-primary">Save & Unpublish</button>
                            </div>
                            <div class="btn-group" role="group" aria-label="Second group">
                                <button type="submit" name="button" value="1"
                                        class="btn btn-success">Save & Publish</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- end col -->
    </div>
    <script>
        $('#summernote').summernote({
            tabsize: 2,
            height: 200
        });
        $('#shot_summernote').summernote({
            tabsize: 2,
            height: 200
        });
        $('#summernote1').summernote({
            tabsize: 2,
            height: 200
        });
        $('#summernote2').summernote({
            tabsize: 2,
            height: 200
        });
    </script>
    <!-- end row -->
    <script>
        function validateInput(input) {
            // Remove any non-numeric characters
            input.value = input.value.replace(/[^0-9]/g, '');

            // Ensure the value is at least 1
            if (input.value < 1) {
                input.value = 1;
            }
        }
    </script>

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

    <script>
        function previewImages(event) {
            var input = event.target;
            var imagePreviewsContainer = document.getElementById('imagePreviews');

            // Clear all existing images (both loaded on page and previews)
            imagePreviewsContainer.innerHTML = '';

            Array.from(input.files).forEach(file => {
                var reader = new FileReader();

                reader.onload = function() {
                    var img = document.createElement('img');
                    img.src = reader.result;
                    img.alt = 'Preview';
                    img.style.display = 'inline-block';
                    img.style.marginRight = '10px';
                    img.style.maxWidth = '80px';
                    img.style.maxHeight = '100px';
                    img.classList.add('mt-1');
                    imagePreviewsContainer.appendChild(img);
                };

                reader.readAsDataURL(file);
            });
        }

        var imageInput = document.getElementById('imageInputGallery');
        imageInput.addEventListener('change', previewImages);
    </script>

    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker({
                noneSelectedText: 'Select Colors'
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colorsSelect = document.getElementById('colors');
            const sizesSelect = document.getElementById('sizes');
            const variantInputsContainer = document.getElementById('variantInputsContainer');
            const colorOptions = Array.from(colorsSelect.options);
            const sizeOptions = Array.from(sizesSelect.options);

            // Existing variants loaded from the server
            const existingVariants = @json($product->variants);

            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            function getColorNameById(id) {
                const color = colorOptions.find(option => option.value == id);
                return color ? color.text : '';
            }

            function getSizeNameById(id) {
                const size = sizeOptions.find(option => option.value == id);
                return size ? size.text : '';
            }

            function generateVariantInputs() {
                const selectedColors = Array.from(colorsSelect.selectedOptions).map(option => option.value);
                const selectedSizes = Array.from(sizesSelect.selectedOptions).map(option => option.value);

                // Clear existing inputs
                variantInputsContainer.innerHTML = '';

                let hasVariants = false;

                if (selectedColors.length > 0) {
                    selectedColors.forEach(colorId => {
                        const colorName = capitalizeFirstLetter(getColorNameById(colorId));

                        if (selectedSizes.length > 0) {
                            selectedSizes.forEach(sizeId => {
                                const sizeName = getSizeNameById(sizeId);

                                // Find the existing variant if available
                                const existingVariant = existingVariants.find(variant => variant.color_id == colorId && variant.size_id == sizeId);
                                const price = existingVariant ? existingVariant.price : '';
                                const discount = existingVariant ? existingVariant.discount : '';
                                const discount_type = existingVariant ? existingVariant.discount_type : '';
                                const quantity = existingVariant ? existingVariant.qty : '';
                                const image = existingVariant ? existingVariant.image : '';

                                const variantHtml = `
                                <div class="row mb-3 variant-row" data-color="${colorId}" data-size="${sizeId}">
                                    <label class="col-form-label">${colorName} - ${sizeName}</label>
                                    <input type="hidden" name="variant_name_${colorId}_${sizeId}" class="form-control" value="${colorName} - ${sizeName}" readonly />
                                    <div class="col-md-2">
                                        <input type="number" name="variant_price_${colorId}_${sizeId}" class="form-control" value="${price}" placeholder="Price" required />
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="variant_qty_${colorId}_${sizeId}" class="form-control" value="${quantity}" placeholder="Quantity" required />
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="variant_discount_${colorId}_${sizeId}" class="form-control" value="${discount}" placeholder="Discount" required />
                                    </div>
                                    <div class="col-md-2">
                                        <select name="variant_discount_type_${colorId}_${sizeId}" id="discount_type" class="form-control">
                                            <option value="1" ${discount_type == '1' ? 'selected' : ''}>Flat</option>
                                            <option value="2" ${discount_type == '2' ? 'selected' : ''}>Percent</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="file" name="variant_image_${colorId}_${sizeId}" class="form-control" />
                                        ${image ? `<img src="{{ asset('${image}') }}" alt="${colorName} - ${sizeName}" width="50">` : ''}
                                    </div>
                                </div>
                            `;
                                variantInputsContainer.insertAdjacentHTML('beforeend', variantHtml);
                                hasVariants = true;
                            });
                        } else {
                            const existingVariant = existingVariants.find(variant => variant.color_id == colorId && !variant.size_id);
                            const price = existingVariant ? existingVariant.price : '';
                            const discount = existingVariant ? existingVariant.discount : '';
                            const discount_type = existingVariant ? existingVariant.discount_type : '';
                            const quantity = existingVariant ? existingVariant.qty : '';
                            const image = existingVariant ? existingVariant.image : '';

                            const variantHtml = `
                            <div class="row mb-3 variant-row" data-color="${colorId}">
                                <label class="col-form-label">${colorName}</label>
                                <input type="hidden" name="variant_name_${colorId}" class="form-control" value="${colorName}" readonly />
                                <div class="col-md-2">
                                        <input type="number" name="variant_price_${colorId}" class="form-control" value="${price}" placeholder="Price" required />
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="variant_qty_${colorId}" class="form-control" value="${quantity}" placeholder="Quantity" required />
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="variant_discount_${colorId}" class="form-control" value="${discount}" placeholder="Discount" required />
                                    </div>
                                    <div class="col-md-2">
                                        <select name="variant_discount_type_${colorId}" id="discount_type" class="form-control">
                                            <option value="1" ${discount_type == '1' ? 'selected' : ''}>Flat</option>
                                            <option value="2" ${discount_type == '2' ? 'selected' : ''}>Percent</option>
                                        </select>
                                    </div>
                                <div class="col-md-3">
                                    <input type="file" name="variant_image_${colorId}" class="form-control" />
                                    ${image ? `<img src="{{ asset('${image}') }}" alt="${colorName}" width="50">` : ''}
                                </div>
                            </div>
                        `;
                            variantInputsContainer.insertAdjacentHTML('beforeend', variantHtml);
                            hasVariants = true;
                        }
                    });
                } else if (selectedSizes.length > 0) {
                    // Handle the case where only sizes are selected
                    selectedSizes.forEach(sizeId => {
                        const sizeName = capitalizeFirstLetter(getSizeNameById(sizeId));

                        const existingVariant = existingVariants.find(variant => !variant.color_id && variant.size_id == sizeId);
                        const price = existingVariant ? existingVariant.price : '';
                        const discount = existingVariant ? existingVariant.discount : '';
                        const discount_type = existingVariant ? existingVariant.discount_type : '';
                        const quantity = existingVariant ? existingVariant.qty : '';
                        const image = existingVariant ? existingVariant.image : '';

                        const variantHtml = `
                        <div class="row mb-3 variant-row" data-size="${sizeId}">
                            <label class="col-form-label">${sizeName}</label>
                            <input type="hidden" name="variant_name_${sizeId}" class="form-control" value="${sizeName}" readonly />
                            <div class="col-md-2">
                                <input type="number" name="variant_price_${sizeId}" class="form-control" value="${price}" placeholder="Price" required />
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="variant_qty_${sizeId}" class="form-control" value="${quantity}" placeholder="Quantity" required />
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="variant_discount_${sizeId}" class="form-control" value="${discount}" placeholder="Discount" required />
                            </div>
                            <div class="col-md-2">
                                <select name="variant_discount_type_${sizeId}" id="discount_type" class="form-control">
                                    <option value="1" ${discount_type == '1' ? 'selected' : ''}>Flat</option>
                                    <option value="2" ${discount_type == '2' ? 'selected' : ''}>Percent</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="file" name="variant_image_${sizeId}" class="form-control" />
                                ${image ? `<img src="{{ asset('${image}') }}" alt="${sizeName}" width="50">` : ''}
                            </div>
                        </div>
                    `;
                        variantInputsContainer.insertAdjacentHTML('beforeend', variantHtml);
                        hasVariants = true;
                    });
                }

                // Show or hide the container based on whether there are any variants
                variantInputsContainer.style.display = hasVariants ? 'block' : 'none';
            }

            colorsSelect.addEventListener('change', generateVariantInputs);
            sizesSelect.addEventListener('change', generateVariantInputs);

            // Initial check
            generateVariantInputs();
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var isVariationSelect = document.getElementById('is_variation');
            var variationActiveDiv = document.getElementById('variation_active');

            function toggleVariationDiv() {
                if (isVariationSelect.value === 'yes') {
                    variationActiveDiv.style.display = 'block';
                } else {
                    variationActiveDiv.style.display = 'none';
                }
            }
            // Initial check
            toggleVariationDiv();

            // Add event listener
            isVariationSelect.addEventListener('change', toggleVariationDiv);
        });
    </script>

@endsection




