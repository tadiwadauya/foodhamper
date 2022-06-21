@extends('layouts.app')

@section('template_title')
    Meat collection details for {{ $collection->allocation }}
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
                    <span class="pcoded-mtext"> Showing collection details for allocation number {{ $collection->allocation }}</span>
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
                          <h4>Detailed Description</h4>
                          <p><strong style="font-weight: bold; font-size:18px;">Note : </strong>Please not that this info is only for references purposes only.</p>
                          <div style="border-bottom: 1px solid rgb(114, 114, 114);"></div>
                        </div>
                        <div class="row card-block mt-0 pt-0">

                          <div class="col-md-12 col-lg-6">
                            <ul class="basic-list">
                              <li class="">
                                <h6>ID : </h6>
                                <p>
                                  {{ $collection->id }}
                                </p>
                              </li>
                              <li class="">
                                <h6>Department : </h6>
                                <p style="text-transform: capitalize">
                                  {{ $collection->user->department->name }}
                                </p>
                              </li>
                              <li class="">
                                <h6>Full Name : </h6>
                                <p style="text-transform: capitalize">
                                  {{ $collection->user->full_name }}
                                </p>
                              </li>
                              <li class="">
                                <h6>User Type : </h6>
                                <p style="text-transform: capitalize">
                                  {{ $collection->user->usertype->type }}
                                </p>
                              </li>
                              <li class="">
                                <h6>Collectd By : </h6>
                                <p style="text-transform: capitalize">
                                    @if($collection->self == 1)
                                        SELF
                                    @else
                                        {{ $collection->collected_by }}
                                    @endif
                                </p>
                              </li>

                              @if($collection->collected_by)
                                <li class="">
                                    <h6>ID Number : </h6>
                                    <p style="text-transform: capitalize">
                                        {{ $collection->id_number }}
                                    </p>
                                </li>
                              @endif

                            </ul>
                          </div>

                          <div class="col-md-12 col-lg-6">
                            <ul class="basic-list">
                              <li class="">
                                <h6>Paynumber : </h6>
                                <p>
                                  {{ $collection->paynumber }}
                                </p>
                              </li>
                              <li class="">
                                <h6>Allocation : </h6>
                                <p>
                                  {{ $collection->allocation }}
                                </p>
                              </li>
                              <li class="">
                                <h6>Job Card Number : </h6>
                                <p>
                                  {{ $collection->jobcard }}
                                </p>
                              </li>
                              <li class="">
                                <h6>Issue Date : </h6>
                                <p>
                                  {{ $collection->issue_date }}
                                </p>
                              </li>
                              <li class="">
                                <h6>Month Collected : </h6>
                                <p>
                                  {{ $collection->allocation }}
                                </p>
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
