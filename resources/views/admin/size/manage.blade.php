@extends('admin.master')
@section('title')
    Size manage | {{env('APP_NAME')}}
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
                <h4 class="page-title">All Sizes</h4>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p class="page-title"><b>Sizes</b></p>
                    <table class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sizes as $size)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$size->name}}</td>
                            <td>
                                <button value="{{$size->id}}" class="btn btn-success editBtn btn-sm" title="Edit">
                                    <i class="ri-edit-box-fill"></i>
                                </button>
                                <button type="button" onclick="confirmDelete({{$size->id}});" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="ri-chat-delete-fill"></i>
                                </button>

                                <form action="{{route('size.delete', ['id' => $size->id])}}" method="POST" id="sizeDeleteForm{{$size->id}}">
                                    @csrf
                                </form>
                                <script>
                                    function confirmDelete(sizeId) {
                                        var confirmDelete = confirm('Are you sure you want to delete this?');
                                        if (confirmDelete) {
                                            document.getElementById('sizeDeleteForm' + sizeId).submit();
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
                    <p><b>Add New Size</b></p>
                    <form action="{{route('size.new')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputEmail3" placeholder="Size name"/>
                            @error('name')
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
    <div class="modal fade" id="editSizeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Size update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('size.update')}}" method="POST" enctype="multipart/form-data" id="sizeFormSubmit">
                                @csrf
                                <input type="hidden" id="size_id" name="size_id">
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="size_name" placeholder="Size name"/>
                                    @error('name')
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
                var size_id = $(this).val();
                var editSizeRoute = "{{ route('size.edit', ':id') }}";

                $('#editSizeModal').modal('show');

                var url = editSizeRoute.replace(':id', size_id);

                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (response) {
                        console.log(response);

                        $('#size_name').val(response.size.name);

                        $('#size_id').val(size_id);
                    }
                });
            });
        });
    </script>


@endsection



