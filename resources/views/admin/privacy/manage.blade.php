@extends('admin.master')
@section('title')
    Privacy & Policy Manage | {{env('APP_NAME')}}
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
                <h4 class="page-title">Privacy & Policy Manage</h4>
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
                            <th>Privacy & Policy</th>
                            <th>Conditions</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($privacy as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            @php
                            $without_tag_privacy = strip_tags($data->privacy);
                            $without_tag_condition = strip_tags($data->condition);
                            @endphp
                            <td>{{\Illuminate\Support\Str::limit($without_tag_privacy, 20)}}</td>
                            <td>{{\Illuminate\Support\Str::limit($without_tag_condition, 20)}}</td>
                            <td>
                                @if($data->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">In Active</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('privacy.edit', ['id' => $data->id])}}" class="btn btn-success btn-sm" title="Edit">
                                    <i class="ri-edit-box-fill"></i>
                                </a>
                                <button type="button" onclick="confirmDelete({{$data->id}});" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="ri-chat-delete-fill"></i>
                                </button>

                                <form action="{{route('privacy.delete', ['id' => $data->id])}}" method="POST" id="privacyDeleteForm{{$data->id}}">
                                    @csrf
                                </form>
                                <script>
                                    function confirmDelete(dataId) {
                                        var confirmDelete = confirm('Are you sure you want to delete this?');
                                        if (confirmDelete) {
                                            document.getElementById('privacyDeleteForm' + dataId).submit();
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



