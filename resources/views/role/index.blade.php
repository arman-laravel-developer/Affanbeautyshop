@extends('admin.master')

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
                <h4 class="page-title">Add Role form</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted font-14">{{Session::get('message')}}</p>
                    <form class="form-horizontal" action="{{route('role.new')}}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-2 col-form-label">Role Name</label>
                            <div class="col-10">
                                <input type="text" class="form-control" name="name" id="inputEmail3" placeholder="Role Name"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-2 col-form-label">Description</label>
                            <div class="col-10">
                                <textarea class="form-control" id="inputPassword3" name="description" placeholder="Role Description"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-end">
                            <label class="col-2 col-form-label">Select Route</label>
                            <div class="col-10">
                                <div class="row">
                                    @foreach ($routeLists as $prefix => $routeNames)
                                        <div class="col-md-6">
                                            <h4 class="mt-3">{{ \Illuminate\Support\Str::ucfirst($prefix) }} Module</h4>
                                            @foreach ($routeNames as $key => $routeName)
                                                @php
                                                    // Format the route name
                                                    $formattedRouteName = str_replace('.', ' ', $routeName); // Replace dots with spaces
                                                    $formattedRouteName = ucwords($formattedRouteName); // Capitalize the first letter of each word
                                                @endphp
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        value="{{ $routeName }}"
                                                        name="route_name[]"
                                                        class="form-check-input"
                                                        id="customCheck{{ $routeName }}"
                                                        style="height: 20px; width: 20px;"
                                                    />
                                                    <label
                                                        for="customCheck{{ $routeName }}"
                                                        class="form-check-label"
                                                        style="margin-left: 5px; cursor: pointer;"
                                                    >
                                                        {{ $formattedRouteName }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        {{--                                    <div class="col-md-6">--}}
                                        {{--                                        <div class="card h-100">--}}
                                        {{--                                            <div class="card-header">--}}
                                        {{--                                                <h4 class="text-center">{{ \Illuminate\Support\Str::ucfirst($prefix) }} Module</h4>--}}
                                        {{--                                            </div>--}}
                                        {{--                                            <div class="card-body text-center">--}}
                                        {{--                                                @foreach ($routeNames as $key => $routeName)--}}
                                        {{--                                                    @php--}}
                                        {{--                                                        // Format the route name--}}
                                        {{--                                                        $formattedRouteName = str_replace('.', ' ', $routeName); // Replace dots with spaces--}}
                                        {{--                                                        $formattedRouteName = ucwords($formattedRouteName); // Capitalize the first letter of each word--}}
                                        {{--                                                    @endphp--}}
                                        {{--                                                    <div class="form-check form-check-inline" style="margin: 2%;">--}}
                                        {{--                                                        <input--}}
                                        {{--                                                            type="checkbox"--}}
                                        {{--                                                            value="{{ $routeName }}"--}}
                                        {{--                                                            name="route_name[]"--}}
                                        {{--                                                            class="form-check-input"--}}
                                        {{--                                                            id="customCheck{{ $routeName }}"--}}
                                        {{--                                                            style="height: 20px; width: 20px;"--}}
                                        {{--                                                        />--}}
                                        {{--                                                        <label--}}
                                        {{--                                                            for="customCheck{{ $routeName }}"--}}
                                        {{--                                                            class="form-check-label"--}}
                                        {{--                                                            style="margin-left: 5px; cursor: pointer;"--}}
                                        {{--                                                        >--}}
                                        {{--                                                            {{ $formattedRouteName }}--}}
                                        {{--                                                        </label>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                @endforeach--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                    </div>--}}
                                    @endforeach
                                </div>
                                {{--                                <table class="table table-bordered text-center table-striped dt-responsive nowrap w-100">--}}
                                {{--                                    <thead>--}}
                                {{--                                    <th>--}}
                                {{--                                    Name--}}
                                {{--                                        <td>Add Form</td>--}}
                                {{--                                        <td>Create</td>--}}
                                {{--                                        <td>Manage</td>--}}
                                {{--                                        <td>Edit Form</td>--}}
                                {{--                                        <td>Update</td>--}}
                                {{--                                        <td>Delete</td>--}}
                                {{--                                    </th>--}}
                                {{--                                    </thead>--}}
                                {{--                                    <tbody>--}}
                                {{--                                    @foreach ($routeLists as $prefix => $routeNames)--}}
                                {{--                                        <tr>--}}
                                {{--                                            <td>{{ $prefix }}</td> <!-- Prefix column -->--}}
                                {{--                                            @foreach ($routeNames as $key => $routeName)--}}
                                {{--                                                <td>--}}
                                {{--                                                    <div class="form-check form-check-inline">--}}
                                {{--                                                        <input type="checkbox" value="{{ $routeName }}" style="height: 20px;width: 20px;" name="route_name[]" class="form-check-input" id="customCheck{{ $key }}"/>--}}
                                {{--                                                    </div>--}}
                                {{--                                                </td>--}}
                                {{--                                            @endforeach--}}
                                {{--                                        </tr>--}}

                                {{--                                    @endforeach--}}
                                {{--                                    </tbody>--}}
                                {{--                                </table>--}}

                            </div>
                        </div>
                        <div class="justify-content-end row">
                            <div class="col-10">
                                <button type="submit" class="btn btn-info">Create New Role</button>
                            </div>
                        </div>
                    </form>
                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->
    </div>
@endsection
