@extends('layouts.app')

@section('template_title')
    Approved Requests Schedule
@endsection

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
                        <h5>Daily Approved Requests</h5>
                        <span class="pcoded-mtext"> Generate daily approved requests list</span>
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
                            <a href="{{ url('mrequests') }}">Humber Requests</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('mrequests/create') }}">Add New</a>
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
                                    <h4 class="sub-title" style="font-weight: bold;">Generate a list of approved humber
                                        requests</h4>
                                </div>
                                <div class="card-block mt-0 pt-0">

                                    <form method="POST" action="{{ route('daily') }}" class="needs-validation mb-4">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-3 col-form-label mb-2">Approved Date :
                                            </label>
                                            <div class="col-sm-7 mb-2">
                                                <input type="date" name="date" id="date"
                                                    class="form-control @error('date') is-invalid @enderror"
                                                    required="" />
                                            </div>

                                            <div class="col-sm-2 mb-2">
                                                <button
                                                    class="btn waves-effect btn-block btn-round waves-light btn-sm btn-primary">Generate</button>
                                            </div>
                                            @error('date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> {{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </form>

                                    @if (isset($approved))

                                        <h6>Showing all pending requests</h6>

                                        <div class="dt-responsive table-responsive">
                                            <table id="basic-btn" class="table table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Paynumber</th>
                                                        <th>Name</th>
                                                        <th>Department</th>
                                                        <th>Allocation</th>
                                                        <th>Done By</th>
                                                        <th>Date created</th>
                                                        <th>Status</th>
                                                        <th>Request Type</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($approved)
                                                        @foreach ($approved as $mrequest)
                                                            <tr>
                                                                <td>{{ $mrequest->id }}</td>
                                                                <td>{{ $mrequest->paynumber }}</td>
                                                                <td>{{ $mrequest->user->full_name }}</td>
                                                                <td>{{ $mrequest->department }}</td>
                                                                <td>{{ $mrequest->allocation }}</td>
                                                                <td>{{ $mrequest->done_by }}</td>
                                                                <td>{{ date('d-m-Y', strtotime($mrequest->created_at)) }}
                                                                </td>
                                                                <td>
                                                                    @if ($mrequest->status == 'not approved')
                                                                        @php
                                                                            $badgeClass = 'warning';
                                                                        @endphp
                                                                    @elseif($mrequest->status == 'approved')
                                                                        @php
                                                                            $badgeClass = 'success';
                                                                        @endphp
                                                                    @elseif($mrequest->status == 'rejected')
                                                                        @php
                                                                            $badgeClass = 'danger';
                                                                        @endphp
                                                                    @else
                                                                        @php $badgeClass = 'default' @endphp
                                                                    @endif
                                                                    <span
                                                                        class="badge badge-{{ $badgeClass }}">{{ $mrequest->status }}</span>
                                                                </td>
                                                                <td>{{ $mrequest->type }}</td>

                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
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
