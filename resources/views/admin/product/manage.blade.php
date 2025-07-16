@extends('admin.master')
@section('title')
    Product manage | {{env('APP_NAME')}}
@endsection

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right" style="display: block!important;">
                    <a href="{{route('product.add')}}" class="btn btn-primary ms-1">
                        Add Product
                    </a>
                </div>
                <h4 class="page-title">Product Manage</h4>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Info</th>
                            <th>Stock</th>
                            <th>Added By</th>
                            <th data-priority="1">Published</th>
                            <th data-priority="2">Featured</th>
                            <th data-priority="3">You May Also</th>
                            <th data-priority="4">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr style="font-size: 90%">
                                <td>
                                    <img src="{{asset($product->thumbnail_img)}}" alt="" style="height: 30px">
                                </td>
                                @php
                                    $name = $product->name;
                                    $line1 = substr($name, 0, 31); // First 31 characters
                                    $line2 = substr($name, 31); // Remaining characters
                                @endphp
                                <td>{{ $line1 }}<br>{{ $line2 }}</td>
                                <td>
                                    <b>Num of sale:</b> {{$product->num_of_sale ? $product->num_of_sale : 0}} Times <br>
                                    <b>Base price:</b>&#2547;{{number_format($product->sell_price , 2)}}
                                </td>
                                <td>
                                    {{ number_format($product->stock).'/'.$product->unit }}
                                    @if($product->stock <= 5)
                                        <span class="badge badge-danger-lighten">Low</span>
                                    @endif
                                    <br>
                                    <a href="javascript:void(0)" onclick="showStockUpdateModal({{ $product->id }}, {{ $product->stock }})">Update</a>
                                </td>
                                <td>{{$product->user->name}}</td>
                                <td>
                                    <input type="checkbox" id="switch{{$product->id}}_published" data-switch="none"
                                           {{ $product->status == 1 ? 'checked' : '' }}
                                           onchange="updateProductStatus({{$product->id}}, this.checked ? 1 : 2)">
                                    <label for="switch{{$product->id}}_published" data-on-label="" data-off-label=""></label>
                                </td>
                                <td>
                                    <input type="checkbox" id="switch{{$product->id}}_featured" data-switch="none"
                                           {{ $product->is_featured == 1 ? 'checked' : '' }}
                                           onchange="updateProductFeatured({{$product->id}}, this.checked ? 1 : 2)">
                                    <label for="switch{{$product->id}}_featured" data-on-label="" data-off-label=""></label>
                                </td>
                                <td>
                                    <input type="checkbox" id="switch{{$product->id}}_you_may_also" data-switch="none"
                                           {{ $product->you_may_also == 1 ? 'checked' : '' }}
                                           onchange="updateProductYouMayAlso({{$product->id}}, this.checked ? 1 : 2)">
                                    <label for="switch{{$product->id}}_you_may_also" data-on-label="" data-off-label=""></label>
                                </td>
                                <td>
                                    <a href="{{route('product.edit', ['id' => $product->id])}}" class="btn btn-success btn-sm" title="Edit">
                                        <i class="ri-edit-box-fill"></i>
                                    </a>
                                    <button type="button" onclick="confirmDelete({{$product->id}});" class="btn btn-danger btn-sm" title="Delete">
                                        <i class="ri-chat-delete-fill"></i>
                                    </button>

                                    <form action="{{route('product.delete', ['id' => $product->id])}}" method="POST" id="productDeleteForm{{$product->id}}">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <!-- Stock Update Modal -->
    <div class="modal fade" id="stockUpdateModal" tabindex="-1" aria-labelledby="stockUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockUpdateModalLabel">Update Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="stockUpdateForm">
                        @csrf
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="mb-3">
                            <label for="stock" class="form-label">New Stock Quantity</label>
                            <input type="number" class="form-control" id="stock" name="stock" oninput="validateInput(this)" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(productId) {
            var confirmDelete = confirm('Are you sure you want to delete this?');
            if (confirmDelete) {
                document.getElementById('productDeleteForm' + productId).submit();
            } else {
                return false;
            }
        }
    </script>

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
        function showStockUpdateModal(productId, currentStock) {
            // Set the values in the modal form
            document.getElementById('product_id').value = productId;
            document.getElementById('stock').value = currentStock;

            // Show the modal
            var stockModal = new bootstrap.Modal(document.getElementById('stockUpdateModal'));
            stockModal.show();
        }

        // Handle form submission
        document.getElementById('stockUpdateForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Get form data
            var formData = new FormData(this);

            // Send AJAX request to update stock
            $.ajax({
                url: '{{ route("product.updateStock") }}', // Make sure you have this route defined
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload(); // Reload the page to reflect the updated stock
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred while updating the stock.');
                }
            });
        });
    </script>

    <script>
        function updateProductStatus(productId, status) {
            $.ajax({
                url: '{{ route("product.updateStatus") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                    } else if (response.error) {
                        toastr.error(response.error);
                    }
                },
                error: function(xhr) {
                    alert('An error occurred while updating the product status.');
                }
            });
        }
    </script>

    <script>
        function updateProductFeatured(productId, featured) {
            $.ajax({
                url: '{{ route("product.updateFeatured") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    featured: featured
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                    } else if (response.error) {
                        toastr.error(response.error);
                    }
                },
                error: function(xhr) {
                    alert('An error occurred while updating the product status.');
                }
            });
        }
    </script>

    <script>
        function updateProductYouMayAlso(productId, status) {
            $.ajax({
                url: '{{ route("product.updateYouMayAlso") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                    } else if (response.error) {
                        toastr.error(response.error);
                    }
                },
                error: function(xhr) {
                    alert('An error occurred while updating the product status.');
                }
            });
        }
    </script>

@endsection




