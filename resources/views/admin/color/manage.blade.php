@extends('admin.master')
@section('title')
    Color manage | {{env('APP_NAME')}}
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
                <h4 class="page-title">All Colors</h4>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p class="page-title"><b>Colors</b></p>
                    <table class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Color</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($colors as $color)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$color->name}}</td>
                            <td>
                                <div style="border: 1px solid; background-color: {{$color->color_code}}; height: 30px; width: 30px;"></div>
                                <p>{{$color->color_code}}</p>
                            </td>
                            <td>
                                <button value="{{$color->id}}" class="btn btn-success editBtn btn-sm" title="Edit">
                                    <i class="ri-edit-box-fill"></i>
                                </button>
                                <button type="button" onclick="confirmDelete({{$color->id}});" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="ri-chat-delete-fill"></i>
                                </button>

                                <form action="{{route('color.delete', ['id' => $color->id])}}" method="POST" id="colorDeleteForm{{$color->id}}">
                                    @csrf
                                </form>
                                <script>
                                    function confirmDelete(colorId) {
                                        var confirmDelete = confirm('Are you sure you want to delete this?');
                                        if (confirmDelete) {
                                            document.getElementById('colorDeleteForm' + colorId).submit();
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
                    <p><b>Add New Color</b></p>
                    <form action="{{route('color.new')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputEmail3" placeholder="Color name"/>
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label">Color Code</label>
                            <input type="color" class="form-control @error('color_code') is-invalid @enderror" name="color_code" id="inputEmail34"/>
                            @error('color_code')
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
    <div class="modal fade" id="editColorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Color update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('color.update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="color_id" name="color_id">
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="color_name" placeholder="Color name"/>
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label">Color Code</label>
                                    <input type="color" class="form-control @error('color_code') is-invalid @enderror" name="color_code" id="color_code"/>
                                    @error('color_code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div> <!-- end modal footer -->
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- end modal content-->
        </div> <!-- end modal dialog-->
    </div> <!-- end modal-->


    <script>
        $(document).ready(function () {
            $(document).on('click', '.editBtn', function () {
                var color_id = $(this).val();
                var editColorRoute = "{{ route('color.edit', ':id') }}";

                $('#editColorModal').modal('show');

                var url = editColorRoute.replace(':id', color_id);

                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (response) {
                        console.log(response);

                        $('#color_name').val(response.color.name);
                        $('#color_code').val(response.color.color_code);

                        $('#color_id').val(color_id);
                    }
                });
            });
        });
    </script>


@endsection



