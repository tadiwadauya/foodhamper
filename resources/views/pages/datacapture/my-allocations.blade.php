@extends('layouts.app')

@section('template_linked_css')
<link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/datatables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/buttons.datatables.min.css') }}">
@endsection

@section('content')
<div class="page-header card">
    <div class="row align-items-end">
        @include('partials.form-status')
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h5>My Allocations</h5>
                    <span class="pcoded-mtext"> Overview of my allocations</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ url('home') }}"
                        ><i class="feather icon-home"></i
                        ></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('home') }}">Dashboard</a>
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
                            <h4 style="font-size:16px;margin-bottom:0;">Showing all user allocations </h4>
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
                                  <th>Name</th>
                                  <th>Allocation</th>
                                  <th>Food</th>
                                  <th>Meet</th>
                                  <th>Meet A</th>
                                  <th>Meet B</th>
                                  <th>Status</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if ($allocations)
                                    @foreach ($allocations as $allocation )
                                        <tr>
                                            <td>{{ $allocation->id }}</td>
                                            <td>{{ $allocation->user->full_name }}</td>
                                            <td>{{ $allocation->allocation }}</td>
                                            <td>{{ $allocation->food_allocation }}</td>
                                            <td>{{ $allocation->meet_allocation }}</td>
                                            <td>{{ $allocation->meet_a }}</td>
                                            <td>{{ $allocation->meet_b }}</td>
                                            <td>
                                                @if ($allocation->status == 'not collected')
                                                    @php
                                                        $badgeClass = 'success'
                                                    @endphp
                                                @elseif($allocation->status == 'partial')
                                                    @php
                                                        $badgeClass = 'warning'
                                                    @endphp
                                                @elseif($allocation->status == 'collected')
                                                    @php
                                                        $badgeClass = 'danger'
                                                    @endphp
                                                @else
                                                    @php $badgeClass = 'default' @endphp
                                                @endif
                                                <span
                                                        class="badge badge-{{$badgeClass}}"
                                                        >{{ $allocation->status }}</span
                                                    >

                                            </td>
                                        </tr>
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
