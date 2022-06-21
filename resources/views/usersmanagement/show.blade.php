@extends('layouts.app')

@section('template_title')
    Show User {{ $user->name }}
@endsection

@section('template_linked_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/list.css') }}" />
@endsection
@section('content')
<div class="page-header card">
    <div class="row align-items-end">
        @include('partials.form-status')
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h5>Users</h5>
                    <span class="pcoded-mtext"> Showing {{ $user->first_name }} {{ $user->last_name }}'s Information</span>
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
                        <div class="card-header">
                          <h4>User's Information</h4>
                        </div>
                        <div class="row card-block">
                          <div class="col-md-12 col-lg-6">

                            <ul class="basic-list">
                              <li class="">
                                <h6>Email : </h6>
                                <p>
                                  {{ $user->email }}
                                </p>
                              </li>
                              <li class="">
                                <h6>Paynumber : </h6>
                                <p>
                                  {{ $user->paynumber }}
                                </p>
                              </li>
                              <li class="">
                                <h6>First name : </h6>
                                <p>
                                  {{ $user->first_name }}
                                </p>
                              </li>
                              <li class="">
                                <h6>Last name : </h6>
                                <p>
                                  {{ $user->last_name }}
                                </p>
                              </li>
                              <li class="">
                                <h6>Mobile : </h6>
                                <p>
                                  {{ $user->mobile }}
                                </p>
                              </li>
                              <li class="">
                                <h6>Access Level : </h6>
                                <p>
                                    @if($user->level() >= 5)
                                    <span class="badge badge-primary margin-half margin-left-0">5</span>
                                  @endif

                                  @if($user->level() >= 4)
                                     <span class="badge badge-info margin-half margin-left-0">4</span>
                                  @endif

                                  @if($user->level() >= 3)
                                    <span class="badge badge-success margin-half margin-left-0">3</span>
                                  @endif

                                  @if($user->level() >= 2)
                                    <span class="badge badge-warning margin-half margin-left-0">2</span>
                                  @endif

                                  @if($user->level() >= 1)
                                    <span class="badge badge-default margin-half margin-left-0">1</span>
                                  @endif
                                </p>
                              </li>
                            </ul>
                          </div>

                          <div class="col-md-12 col-lg-6">

                            <ul class="basic-list">
                              <li class="">
                                <h6>Department : </h6>
                                <p>
                                  {{ $user->department->name }}
                                </p>
                              </li>
                              <li class="">
                                <h6>Usertype : </h6>
                                <p>
                                  {{ $user->usertype->type }}
                                </p>
                              </li>
                              <li class="">
                                <h6>User Role : </h6>
                                <p>
                                    @foreach ($user->roles as $user_role)

                                    @if ($user_role->name == 'User')
                                      @php $badgeClass = 'primary' @endphp

                                    @elseif ($user_role->name == 'Admin')
                                      @php $badgeClass = 'warning' @endphp

                                    @elseif ($user_role->name == 'Unverified')
                                      @php $badgeClass = 'danger' @endphp

                                    @else
                                      @php $badgeClass = 'default' @endphp

                                    @endif

                                    <span class="badge badge-{{$badgeClass}}">{{ $user_role->name }}</span>

                                  @endforeach
                                </p>
                              </li>

                              <li class="">
                                <h6>User status : </h6>
                                <p>
                                    @if ($user->activated == 1)
                                    <span class="badge badge-success">
                                      Activated
                                    </span>
                                  @else
                                    <span class="badge badge-danger">
                                      Not-Activated
                                    </span>
                                  @endif
                                </p>
                              </li>
                              <li class="">
                                <h6>Date created : </h6>
                                <p>
                                  {{ $user->created_at }}
                                </p>
                              </li>
                              <li class="">
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <a href="{{ route('users.edit',$user->id) }}" class="btn btn-success btn-sm btn-round btn-block">Edit User Account</a>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <a href="" class="btn btn-danger btn-sm btn-round btn-block">Delete User Account</a>
                                    </div>
                                </div>
                              </li>
                            </ul>
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

@endsection
