@extends('admin.master')
@section('title')
    Shipping Cost manage | {{env('APP_NAME')}}
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
                <h4 class="page-title">All Shipping Costs</h4>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p class="page-title"><b>Shipping Costs</b></p>
                    <table class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Address Name</th>
                            <th>Shipping Cost</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shippingCosts as $shippingCost)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$shippingCost->address_name}}</td>
                            <td>{{$shippingCost->shipping_cost}}</td>
                            <td>
                                <button value="{{$shippingCost->id}}" class="btn btn-success editBtn btn-sm" title="Edit">
                                    <i class="ri-edit-box-fill"></i>
                                </button>
                                <button type="button" onclick="confirmDelete({{$shippingCost->id}});" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="ri-chat-delete-fill"></i>
                                </button>

                                <form action="{{route('shipping-cost.delete', ['id' => $shippingCost->id])}}" method="POST" id="shippingCostDeleteForm{{$shippingCost->id}}">
                                    @csrf
                                </form>
                                <script>
                                    function confirmDelete(shippingCostId) {
                                        var confirmDelete = confirm('Are you sure you want to delete this?');
                                        if (confirmDelete) {
                                            document.getElementById('shippingCostDeleteForm' + shippingCostId).submit();
                                        } else {
                                            return false;
                                        }
                                    }
                                </script>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p><b>Add New Shipping Cost</b></p>
                    <form action="{{route('shipping-cost.new')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-form-label">Address Name</label>
                            <input type="text" class="form-control @error('address_name') is-invalid @enderror" name="address_name" id="inputEmail3" placeholder="Address name"/>
                            @error('address_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail13" class="col-form-label">Shipping Cost</label>
                            <input type="text" class="form-control @error('shipping_cost') is-invalid @enderror" name="shipping_cost" oninput="this.value = this.value.replace(/[^0-9]/g,'');" id="inputEmail13" placeholder="Shipping Cost"/>
                            @error('shipping_cost')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <button type="submit" class="btn btn-primary float-end">Submit</button>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editShippingCostModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Shipping Cost update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('shipping-cost.update')}}" method="POST" enctype="multipart/form-data" id="sizeFormSubmit">
                                @csrf
                                <input type="hidden" id="shipping_cost_id" name="shipping_cost_id">
                                <div class="row mb-3">
                                    <label for="address_name" class="col-form-label">Address Name</label>
                                    <input type="text" class="form-control @error('address_name') is-invalid @enderror" name="address_name" id="address_name" placeholder="Address name"/>
                                    @error('address_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row mb-3">
                                    <label for="shipping_cost" class="col-form-label">Shipping Cost</label>
                                    <input type="text" class="form-control @error('shipping_cost') is-invalid @enderror" name="shipping_cost" oninput="this.value = this.value.replace(/[^0-9]/g,'');" id="shipping_cost" placeholder="Shipping Cost"/>
                                    @error('shipping_cost')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="event.preventDefault(); document.getElementById('sizeFormSubmit').submit();" class="btn btn-primary">Submit</button>
                </div> <!-- end modal footer -->
            </div> <!-- end modal content-->
        </div> <!-- end modal dialog-->
    </div> <!-- end modal-->


    <script>
        $(document).ready(function () {
            $(document).on('click', '.editBtn', function () {
                var shipping_cost_id = $(this).val();
                var editShippingCostRoute = "{{ route('shipping-cost.edit', ':id') }}";

                $('#editShippingCostModal').modal('show');

                var url = editShippingCostRoute.replace(':id', shipping_cost_id);

                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (response) {
                        console.log(response);

                        $('#address_name').val(response.shippingCost.address_name);
                        $('#shipping_cost').val(response.shippingCost.shipping_cost);

                        $('#shipping_cost_id').val(shipping_cost_id);
                    }
                });
            });
        });
    </script>


@endsection



