@extends('admin.master')
@section('title')
    General Settings | {{env('APP_NAME')}}
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
                <h4 class="page-title">General Settings</h4>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('setting.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-1">
                            <label class="col-form-label">Site Name</label>
                            <input type="text" class="form-control @error('site_name') is-invalid @enderror" value="{{optional($generalSetting)->site_name}}" name="site_name" placeholder="Site name"/>
                            @error('site_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-1">
                            <label class="col-form-label">Site Mobile</label>
                            <input type="text" class="form-control @error('mobile') is-invalid @enderror" value="{{optional($generalSetting)->mobile}}" name="mobile" placeholder="Site mobile"/>
                            @error('mobile')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-1">
                            <label class="col-form-label">Site email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{optional($generalSetting)->email}}" name="email" placeholder="Site email"/>
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-1">
                            <label class="col-form-label">Site address</label>
                            <textarea type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Site address">{{optional($generalSetting)->address}}</textarea>
                            @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-1">
                            <label class="col-form-label">About Us Footer</label>
                            <textarea type="text" class="form-control @error('about_us_short') is-invalid @enderror" name="about_us_short" placeholder="About us">{{optional($generalSetting)->about_us_short}}</textarea>
                            @error('about_us_short')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-1">
                            <label class="col-form-label">WhatsApp Number</label>
                            <input type="text" class="form-control @error('pinterest_url') is-invalid @enderror" value="{{optional($generalSetting)->pinterest_url}}" name="pinterest_url" placeholder="+8801XXXXXXXXX"/>
                            @error('pinterest_url')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-1">
                            <label class="col-form-label">Facebook url</label>
                            <input type="text" class="form-control @error('facebook_url') is-invalid @enderror" value="{{optional($generalSetting)->facebook_url}}" name="facebook_url" placeholder="facebook url"/>
                            @error('facebook_url')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-1">
                            <label class="col-form-label">Instagram url</label>
                            <input type="text" class="form-control @error('instagram_url') is-invalid @enderror" value="{{optional($generalSetting)->instagram_url}}" name="instagram_url" placeholder="instagram url"/>
                            @error('instagram_url')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-1">
                            <label class="col-form-label">Youtube url</label>
                            <input type="text" class="form-control @error('youtube_url') is-invalid @enderror" value="{{optional($generalSetting)->youtube_url}}" name="youtube_url" placeholder="youtube url"/>
                            @error('youtube_url')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-1">
                            <label class="col-form-label">Twitter url</label>
                            <input type="text" class="form-control @error('twitter_url') is-invalid @enderror" value="{{optional($generalSetting)->twitter_url}}" name="twitter_url" placeholder="twitter url"/>
                            @error('twitter_url')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-1">
                            <label class="col-form-label">LinkedIn url</label>
                            <input type="text" class="form-control @error('linkedin_url') is-invalid @enderror" value="{{optional($generalSetting)->linkedin_url}}" name="linkedin_url" placeholder="linkedIn url"/>
                            @error('linkedin_url')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-1">
                            <label class="col-form-label">Header Logo</label>
                            <input type="file" class="form-control @error('header_logo') is-invalid @enderror" name="header_logo" id="headerLogo"/>
                            <img id="headerLogoPreview" class="mt-1" src="{{asset(optional($generalSetting)->header_logo)}}" alt="Preview" style="max-width: 200px; max-height: 200px;">
                            @error('header_logo')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-1">
                            <label class="col-form-label">Footer Logo</label>
                            <input type="file" class="form-control @error('footer_logo') is-invalid @enderror" name="footer_logo" id="footerLogo"/>
                            <img id="footerLogoPreview" class="mt-1" src="{{asset(optional($generalSetting)->footer_logo)}}" alt="Preview" style="max-width: 200px; max-height: 200px;">
                            @error('footer_logo')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-1">
                            <label class="col-form-label">Favicon</label>
                            <input type="file" class="form-control @error('favicon') is-invalid @enderror" name="favicon" id="favicon"/>
                            <img id="faviconPreview" class="mt-1" src="{{asset(optional($generalSetting)->favicon)}}" alt="Preview" style="max-width: 200px; max-height: 200px;">
                            @error('favicon')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label">Payment method footer image</label>
                            <input type="file" class="form-control @error('payment_method_image') is-invalid @enderror" name="payment_method_image" id="payment_method_image"/>
                            <img id="paymentPreview" class="mt-1" src="{{asset(optional($generalSetting)->payment_method_image)}}" alt="Preview" style="max-width: 200px; max-height: 200px;">
                            @error('payment_method_image')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <!-- end col -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('home-category.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div id="category-select-container">
                            @foreach($homeCategories as $selectedCategory)
                                <div class="row gutters-5 mb-2">
                                    <div class="col">
                                        <div class="form-group">
                                            <select class="form-control aiz-selectpicker category-select" name="home_categories[]" data-live-search="true" required>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{$category->id == $selectedCategory ? 'selected' : ''}}>{{ $category->category_name }}</option>
                                                    @if(count($category->subCategories) > 0)
                                                        @foreach($category->subCategories as $subCategory)
                                                            <option value="{{$subCategory->id}}" {{$subCategory->id == $selectedCategory ? 'selected' : ''}}>--{{$subCategory->category_name}}</option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger remove-category-row" data-toggle="remove-parent" data-parent=".row">
                                            <i class="fa fa-close"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mt-3">
                            <div class="d-flex justify-content-start">
                                <button type="button" id="add-category-btn" class="btn btn-light btn-sm">Add more categories</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </div>
                        </div>
                    </form>

                    @if (session('updatedCategoriesCount'))
                        <div class="alert alert-success mt-3">
                            {{ session('updatedCategoriesCount') }} categories have been updated!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function updateCategoryOptions() {
                const selectedCategories = Array.from(document.querySelectorAll('.category-select')).map(select => select.value);

                document.querySelectorAll('.category-select').forEach(select => {
                    Array.from(select.options).forEach(option => {
                        if (selectedCategories.includes(option.value) && option.value !== select.value) {
                            option.disabled = true;
                        } else {
                            option.disabled = false;
                        }
                    });
                });

                // Reinitialize the selectpicker to update the UI
                $('.aiz-selectpicker').selectpicker('refresh');
            }

            document.querySelectorAll('.category-select').forEach(select => {
                select.addEventListener('change', updateCategoryOptions);
            });

            document.getElementById('add-category-btn').addEventListener('click', function () {
                const container = document.getElementById('category-select-container');
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'gutters-5', 'mb-2');

                newRow.innerHTML = `
                                <div class="col">
                                    <div class="form-group">
                                        <select class="form-control aiz-selectpicker category-select" name="home_categories[]" required>
                                            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @if(count($category->subCategories) > 0)
                @foreach($category->subCategories as $subCategory)
                <option value="{{$subCategory->id}}">--{{$subCategory->category_name}}</option>
                                                        @endforeach
                @endif
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-auto">
            <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger remove-category-row">
                <i class="fa fa-close"></i>
            </button>
        </div>
`;

                container.appendChild(newRow);

                $('.aiz-selectpicker').selectpicker('refresh');
                newRow.querySelector('.category-select').addEventListener('change', updateCategoryOptions);
                newRow.querySelector('.remove-category-row').addEventListener('click', function () {
                    newRow.remove();
                    updateCategoryOptions();
                });
            });

            document.querySelectorAll('.remove-category-row').forEach(button => {
                button.addEventListener('click', function () {
                    this.closest('.row').remove();
                    updateCategoryOptions();
                });
            });
        });
    </script>
    <script>
        function previewHeaderImage(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function(){
                var headerLogoPreview = document.getElementById('headerLogoPreview');
                headerLogoPreview.src = reader.result;
                headerLogoPreview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }

        var headerLogo = document.getElementById('headerLogo');
        headerLogo.addEventListener('change', previewHeaderImage);
    </script>
    <script>
        function previewFooterImage(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function(){
                var footerLogoPreview = document.getElementById('footerLogoPreview');
                footerLogoPreview.src = reader.result;
                footerLogoPreview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }

        var footerLogo = document.getElementById('footerLogo');
        footerLogo.addEventListener('change', previewFooterImage);
    </script>
    <script>
        function previewFaviconImage(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function(){
                var faviconPreview = document.getElementById('faviconPreview');
                faviconPreview.src = reader.result;
                faviconPreview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }

        var favicon = document.getElementById('favicon');
        favicon.addEventListener('change', previewFaviconImage);
    </script>
    <script>
        function previewPaymentImage(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function(){
                var paymentPreview = document.getElementById('paymentPreview');
                paymentPreview.src = reader.result;
                paymentPreview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }

        var payment_method_image = document.getElementById('payment_method_image');
        payment_method_image.addEventListener('change', previewPaymentImage);
    </script>

    <script>
        $('#summernote').summernote({
            tabsize: 2,
            height: 300
        });
    </script>
    <!-- end row -->



@endsection



