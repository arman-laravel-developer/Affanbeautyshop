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
                <h4 class="page-title">Edit User form</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted font-14">{{Session::get('message')}}</p>
                    <form class="form-horizontal" action="{{route('user.update', ['id' => $user->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-3 col-form-label">User Name</label>
                            <div class="col-9">
                                <input type="text" class="form-control" value="{{$user->name}}" name="name" id="inputEmail3" placeholder="User Name"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail31" class="col-3 col-form-label">User Email</label>
                            <div class="col-9">
                                <input type="email" class="form-control" value="{{$user->email}}" name="email" id="inputEmail31" placeholder="User Email"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail32" class="col-3 col-form-label">User Password</label>
                            <div class="col-9">
                                <input type="password" class="form-control" name="password" placeholder="User Password" autocomplete="new-password"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail33" class="col-3 col-form-label">User Mobile</label>
                            <div class="col-9">
                                <input type="number" class="form-control" value="{{$user->mobile}}" name="mobile" id="inputEmail33" placeholder="User Mobile"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail34" class="col-3 col-form-label">User Image</label>
                            <div class="col-9">
                                <input type="file" class="form-control" name="image" id="inputEmail34" placeholder="User Image"/>
                                <img src="{{asset($user->image)}}" alt="" height="100" width="120"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail32" class="col-3">User Type</label>
                            <div class="col-9">
                                <label><input type="radio" name="user_type" value="1" {{$user->user_type == 1 ? 'checked' : ''}}/> Admin</label>
                                <label><input type="radio" name="user_type" value="2" {{$user->user_type == 2 ? 'checked' : ''}}/> Reporter</label>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-end">
                            <label class="col-3">Select User Role</label>
                            <div class="col-9">
                                @foreach($roles as $key => $role)
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" value="{{ $role->id }}" name="role[]" @foreach($user->roles as $user_role) @if($user_role->id == $role->id) {{'checked'}} @endif  @endforeach class="form-check-input" id="customCheck{{$key}}"/>
                                        <label class="form-check-label" for="customCheck{{$key}}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-info">Update User Info</button>
                            </div>
                        </div>
                    </form>
                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->
    </div>
@endsection
