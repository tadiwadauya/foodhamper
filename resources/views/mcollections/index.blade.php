@extends('layouts.app')

@section('template_title')
    Showing all meat collections
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
                        <h5>Meat Collections</h5>
                        <span class="pcoded-mtext">Summary of all collected meat humbers</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href=""><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('mcollections') }}">Meat Collections</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('mcollections/create') }}">Add New</a>
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
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="basic-btn" class="table table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Pay Number</th>
                                                    <th>Name</th>
                                                    <th>Department</th>
                                                    <th>Job Card Number</th>
                                                    <th>Issue Date</th>
                                                    <th>Month</th>
                                                    <th>Collected By</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($collections)
                                                    @foreach ($collections as $collection)
                                                        <tr>
                                                            <td>{{ $collection->id }}</td>
                                                            <td>{{ $collection->paynumber }}</td>
                                                            <td>{{ $collection->user->full_name }}</td>
                                                            <td>{{ $collection->user->department->name }}</td>
                                                            <td>{{ $collection->jobcard }}</td>
                                                            <td>{{ $collection->issue_date }}</td>
                                                            <td>{{ $collection->allocation }}</td>
                                                            <td>
                                                                @if ($collection->self == 1)
                                                                    SELF
                                                                @else
                                                                    {{ $collection->collected_by }}
                                                                @endif
                                                            </td>
                                                            <td><a href="{{ route('mcollections.show', $collection->id) }}"
                                                                    data-toggle="tooltip" title="View Details"
                                                                    class="d-inline btn btn-sm btn-success"><i
                                                                        class="fa fa-eye"></i></a></td>
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

    @include('departments.show')


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
