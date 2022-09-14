@extends('layouts.app')

@section('template_title')
    Dashboard
@endsection

@section('template_linked_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/datatables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/buttons.datatables.min.css') }}">
@endsection

@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="feather icon-home bg-c-blue"></i>
                    <div class="d-inline">
                        <h5>Dashboard</h5>
                        <span>WHELSON FOOD DISTRIBUTION SYSTEM</span>
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
                            <a href="#!">Dashboard</a>
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
                        @include('partials.form-status')
                        <div class="col-xl-4 col-md-6">
                            <div class="card prod-p-card card-red">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white">Food Humber</h6>
                                            <h3 class="m-b-0 f-w-700 text-white">

                                            </h3>
                                        </div>
                                        <div class="col-auto">
                                            <i
                                                class="
                                      fas
                                      fa-money-bill-alt
                                      text-c-red
                                      f-18
                                    "></i>
                                        </div>
                                    </div>
                                    {{-- <p class="m-b-0 text-white">

                                        @if ($settings->food_available == 0)
                                            Not Available
                                        @else
                                            Available for Collection
                                        @endif
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card prod-p-card card-blue">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white">Meat Humber</h6>
                                            <h3 class="m-b-0 f-w-700 text-white">

                                            </h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-database text-c-blue f-18"></i>
                                        </div>
                                    </div>
                                    {{-- <p class="m-b-0 text-white">

                                        @if ($settings->meat_available == 0)
                                            Not Available
                                        @else
                                            Available for Collection
                                        @endif
                                    </p> --}}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header" style="margin-bottom: 0;padding-bottom:0;">
                                    <h4 style="font-size:16px;margin-bottom:0;font-weight: bold;">Recent Food Allocations</h4>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="basic-btn" class="table table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Allocation</th>
                                                    <th>Food Balance</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($allocations)
                                                    @foreach ($allocations as $allocation)
                                                        <tr>
                                                            <td>{{ $allocation->id }}</td>
                                                            <td>{{ $allocation->user->full_name }}</td>
                                                            <td>{{ $allocation->allocation }}</td>
                                                            <td>{{ $allocation->food_allocation }}</td>
                                                            <td>
                                                                @if ($allocation->status == 'not collected')
                                                                    @php
                                                                        $badgeClass = 'success';
                                                                    @endphp
                                                                @elseif($allocation->status == 'partial')
                                                                    @php
                                                                        $badgeClass = 'warning';
                                                                    @endphp
                                                                @elseif($allocation->status == 'collected')
                                                                    @php
                                                                        $badgeClass = 'danger';
                                                                    @endphp
                                                                @else
                                                                    @php $badgeClass = 'default' @endphp
                                                                @endif
                                                                <span
                                                                    class="badge badge-{{ $badgeClass }}">{{ $allocation->status }}</span>

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
