@extends('layouts.app')

@section('template_title')
Create new user
@endsection

@section('template_linked_css')
<link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
@endsection
@section('content')
<div class="page-header card">
    <div class="row align-items-end">
        @include('partials.form-status')
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h5>Users</h5>
                    <span class="pcoded-mtext"> Add User</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html"><i class="feather icon-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('users') }}">Users</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('users/create') }}">Add New</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4 style="font-size:18px;">Create New User <span class="float-right"><a
                                            href="{{ url('users') }}"
                                            class="btn d-inline btn-sm btn-light btn-round waves-effect waves-dark">Back
                                            to Users</a></span></h4>
                            </div>
                            <div class="card-block" style="margin-top: 0;padding-top:0;">
                                <h4 class="sub-title"></h4>
                                <form method="POST" action="{{ route('users.store') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label"> Email: </label>
                                        <div class="col-sm-10">
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="e.g vmarufu@whelson.co.zw" />
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="paynumber" class="col-sm-2 col-form-label"> Pay number: </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="paynumber" id="paynumber"
                                                class="form-control @error('paynumber') is-invalid @enderror"
                                                placeholder="e.g APPS244" required="" />
                                        </div>
                                        @error('paynumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="first_name" class="col-sm-2 col-form-label"> First Name: </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="first_name" id="first_name"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                placeholder="e.g Vincent" required="" />
                                        </div>
                                        @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="last_name" class="col-sm-2 col-form-label"> Last Name: </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="last_name" id="last_name"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                placeholder="e.g Marufu" required="" />
                                        </div>
                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="mobile" class="col-sm-2 col-form-label"> Mobile: </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="mobile" id="mobile"
                                                class="form-control @error('mobile') is-invalid @enderror"
                                                placeholder="e.g 0772876456" required="" />
                                        </div>
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label for="department_id" class="col-sm-2 col-form-label">Department : </label>
                                        <div class="col-sm-10">
                                            <select name="department_id" id="department_id" class="form-control"
                                                style="width: 100%;">
                                                <option value="">Please select department</option>
                                                @if ($departments)
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}">{{ $department->name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        @error('department_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="usertype_id" class="col-sm-2 col-form-label">Employee Type : </label>
                                        <div class="col-sm-10">
                                            <select name="usertype_id" id="usertype_id" class="form-control"
                                                style="width: 100%;">
                                                <option value="">Please select employee type</option>
                                                @if ($usertypes)
                                                    @foreach ($usertypes as $usertype)
                                                    <option value="{{ $usertype->id }}">{{ $usertype->type }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        @error('usertype_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="role" class="col-sm-2 col-form-label">Role : </label>
                                        <div class="col-sm-10">
                                            <select name="role" id="role" class="form-control" style="width: 100%;"
                                                required autofocus>
                                                @if ($roles)
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="activated" class="col-sm-2 col-form-label">User Status : </label>
                                        <div class="col-sm-10">
                                            <select name="activated" id="activated" class="form-control"
                                                style="width: 100%;" required autofocus>
                                                <option value="">Please select user status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Not Active</option>
                                            </select>
                                        </div>
                                        @error('activated')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-sm-2 col-form-label"> Password: </label>
                                        <div class="col-sm-10">
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="e.g 123456789" required="" />
                                        </div>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password:
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                placeholder="e.g 123456789" required="" />
                                        </div>
                                        @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="pin" class="col-sm-2 col-form-label">Pin:
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="password" name="pin" id="pin"
                                                class="form-control @error('pin') is-invalid @enderror"
                                                placeholder="e.g 1239" required="" />
                                        </div>
                                        @error('pin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row justify-content-end">
                                        <button
                                            class="btn mr-3 waves-effect btn-round waves-light btn-sm btn-primary">Create
                                            New User</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')
<script src="{{ asset('select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#department_id').select2({
            placeholder:'Please select department.',
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#usertype_id').select2({
            placeholder:'Please select user type.',
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#role').select2({
            placeholder:'Please select user role.',
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#activated').select2({
            placeholder:'Please select user status.',
        });
    });
</script>
@endsection
