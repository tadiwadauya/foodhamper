@extends('layouts.app')

@section('template_title')
    Showing all users
@endsection

@section('template_linked_css')
<link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/datatables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/buttons.datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="page-header card">
    <div class="row align-items-end">
        @include('partials.form-status')
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h5>Users</h5>
                    <span class="pcoded-mtext"> Overview of system users</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html"
                        ><i class="feather icon-home"></i
                        ></a>
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
                        <div class="card-header" style="margin-bottom: 0;padding-bottom:0;">
                            <h4 style="font-size:16px;margin-bottom:0;">Showing all users</h4>
                        </div>
                        <div class="card-block">
                          <div class="dt-responsive table-responsive">
                            <table
                              id="basic-btn"
                              class="table table-bordered nowrap"
                            >
                              <thead>
                                <tr>
                                  <th>Id</th>
                                  <th>Username</th>
                                  <th>Pay Number</th>
                                  <th>Name</th>
                                  <th>Department</th>
                                  <th>UserType</th>
                                  <th>FCount</th>
                                  <th>MCount</th>
                                  <th data-toggle="tooltip" title="User Role">Role</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if ($users)
                                    @php
                                        $i = 1;
                                    @endphp

                                    @foreach ($users as $user )
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->paynumber }}</td>
                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                            <td>{{ $user->department->name }}</td>
                                            <td>{{ $user->usertype->type }}</td>
                                            <td>{{ $user->fcount }}</td>
                                            <td>{{ $user->mcount }}</td>
                                            <td>
                                                @foreach ($user->roles as $user_role)
                                                    @if ($user_role->name == 'User')
                                                        @php
                                                            $badgeClass = 'primary'
                                                        @endphp
                                                    @elseif($user_role->name == 'Admin')
                                                        @php
                                                            $badgeClass = 'warning'
                                                        @endphp
                                                    @elseif($user_role->name == 'Unverified')
                                                        @php
                                                            $badgeClass = 'danger'
                                                        @endphp
                                                    @else
                                                        @php $badgeClass = 'default' @endphp
                                                    @endif
                                                    <span
                                                        class="badge badge-{{$badgeClass}}"
                                                        >{{ $user_role->name }}</span
                                                    >
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($user->activated == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">DeActivated</span>
                                                @endif
                                            </td>
                                            <td style="white-space: nowrap;">
                                                <a href="{{ url('deactivate-user/'.$user->id) }}" data-toggle="tooltip" title="Deactivate User" class="d-inline btn btn-sm btn-info"><i class="fa fa-times"></i></a>
                                                <a href="{{ route('users.show',$user->id) }}" data-toggle="tooltip" title="Show User" class="d-inline btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                                <form method="POST" action="{{ route('users.destroy',$user->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="d-inline btn-sm btn btn-danger" data-toggle="tooltip" title="Delete User"><i class="fa fa-trash-o"></i></button>
                                                </form>

                                            </td>
                                        </tr>

                                        @php
                                            $i ++;
                                        @endphp

                                    @endforeach
                                @endif
                              </tbody>
                            </table>
                          </div>
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
<script src="{{ asset('dash_resource/js/jquery.datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/datatables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/vfs_fonts-2.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/buttons.colvis.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/buttons.print.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/datatables.bootstrap4.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/datatables.responsive.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('dash_resource/js/extension-btns-custom.js') }}" type="text/javascript"></script>
@endsection
