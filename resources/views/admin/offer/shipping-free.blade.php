@extends('admin.master')
@section('title')
    Shipping Free Offer manage | {{env('APP_NAME')}}
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
                <h4 class="page-title">Shipping Free Offer</h4>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('shipping-free.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="type" class="col-form-label">Offer Type</label>
                            <select name="type" id="type" class="form-control" onchange="toggleCategory()">
                                <option value="" selected disabled>Select type</option>
                                <option value="any" {{ old('type', $shippingFree->type ?? '') == 'any' ? 'selected' : '' }}>Any</option>
                                <option value="category_wise" {{ old('type', $shippingFree->type ?? '') == 'category_wise' ? 'selected' : '' }}>Category wise</option>
                                <option value="order_total" {{ old('type', $shippingFree->type ?? '') == 'order_total' ? 'selected' : '' }}>Minimum Purchase Amount</option>
                            </select>
                            @error('type')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3" id="categoryNameRow">
                            <label for="category_id" class="col-form-label">Category Name</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="" selected disabled>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $shippingFree->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="qty" class="col-form-label">Minimum order quantity</label>
                            <input type="number" class="form-control @error('qty') is-invalid @enderror" value="{{ old('qty', $shippingFree->qty ?? '') }}" name="qty" oninput="this.value = this.value.replace(/[^0-9]/g,'');" id="qty" placeholder="Minimum order quantity"/>
                            @error('qty')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3" id="minPurchaseRow" style="display: none;">
                            <label for="minimum_purchase" class="col-form-label">Minimum Purchase Amount</label>
                            <input type="number" class="form-control @error('minimum_purchase') is-invalid @enderror"
                                value="{{ old('minimum_purchase', $shippingFree->minimum_purchase ?? '') }}"
                                name="minimum_purchase"
                                id="minimum_purchase"
                                placeholder="Minimum purchase amount"
                                step="0.01"
                                min="0">
                            @error('minimum_purchase')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <label for="date_range" class="form-label">Date Range</label>
                            <input type="text" class="form-control" id="date_range" name="date_range"
                                   value="{{ old('date_range', isset($shippingFree->start_date) && isset($shippingFree->end_date) ? $shippingFree->start_date . ' - ' . $shippingFree->end_date : '') }}"
                                   placeholder="Select date range">
                            @error('date_range')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-10">
                                <input type="checkbox" id="switch1" value="1" class="form-control" {{ old('status', $shippingFree->status ?? 2) == 1 ? 'checked' : '' }} name="status" data-switch="bool"/>
                                <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <button type="submit" class="btn btn-primary float-end">Submit</button>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <script>
        $(document).ready(function() {
            $('#date_range').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'  // Adjust date format as needed
                },
                autoUpdateInput: false,  // Prevents automatic setting of a date range
                showDropdowns: true,
                opens: 'left',
                clearBtn: true  // Custom button to allow clearing the selection
            });

            // Apply selected date range to input
            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });

            // Clear the date range selection
            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');  // Clear the input value
            });
        });
    </script>

    <script>
    function toggleCategory() {
        const typeSelect = document.getElementById("type");
        const categoryRow = document.getElementById("categoryNameRow");
        const qtyRow = document.getElementById("qty").closest('.row');
        const minPurchaseRow = document.getElementById("minPurchaseRow");

        // Show/Hide Category Row
        if (typeSelect.value === "any") {
            categoryRow.style.display = "none";
        } else if (typeSelect.value === "category_wise") {
            categoryRow.style.display = "block";
        } else {
            categoryRow.style.display = "none";
        }

        // Show/Hide Quantity and Min Purchase
        if (typeSelect.value === "order_total") {
            qtyRow.style.display = "none";
            minPurchaseRow.style.display = "block";
        } else {
            qtyRow.style.display = "block";
            minPurchaseRow.style.display = "none";
        }
    }

    // Run on page load
    document.addEventListener("DOMContentLoaded", function () {
        toggleCategory();
    });
</script>


@endsection



