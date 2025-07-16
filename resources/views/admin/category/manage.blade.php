@extends('admin.master')
@section('title')
    Category manage | {{env('APP_NAME')}}
@endsection

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right" style="display: block!important;">
                    <a href="{{route('category.add')}}" class="btn btn-primary ms-1">
                        Add Category
                    </a>
                </div>
                <h4 class="page-title">Category Manage</h4>
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
                            <th>S.N</th>
                            <th>Category name</th>
                            <th>Main category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$category->category_name}}</td>
                            <td>
                                @if($category->parent_id == 0)
                                    Main Category
                                @else
                                    {{$category->subCategory->category_name}}
                                @endif
                            </td>
                            <td>
                                @if($category->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">In Active</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('category.edit', ['id' => $category->id])}}" class="btn btn-success btn-sm" title="Edit">
                                    <i class="ri-edit-box-fill"></i>
                                </a>
                                <button type="button" onclick="confirmDelete({{$category->id}});" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="ri-chat-delete-fill"></i>
                                </button>

                                <form action="{{route('category.delete', ['id' => $category->id])}}" method="POST" id="categoryDeleteForm{{$category->id}}">
                                    @csrf
                                </form>
                                <script>
                                    function confirmDelete(categoryId) {
                                        var confirmDelete = confirm('Are you sure you want to delete this?');
                                        if (confirmDelete) {
                                            document.getElementById('categoryDeleteForm' + categoryId).submit();
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
    </div>

@endsection



