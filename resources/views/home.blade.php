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
                            <a href="{{ url('home') }}"><i class="feather icon-home"></i></a>
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
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-red">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white">Food Humbers</h6>
                                            <h3 class="m-b-0 f-w-700 text-white">
                                                {{ $food_count }}
                                            </h3>
                                        </div>
                                        <div class="col-auto">
                                            <i
                                                class="
                                      fas
                                      fa-database
                                      text-c-red
                                      f-18
                                    "></i>
                                        </div>
                                    </div>
                                    <p class="m-b-0 text-white">

                                        @if ($settings->food_available == 0)
                                            Cannot be issued (In Stock)
                                        @else
                                            Available for Issue
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-blue">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white">Meat Humbers</h6>
                                            <h3 class="m-b-0 f-w-700 text-white">
                                                {{ $meat_count }}
                                            </h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-database text-c-blue f-18"></i>
                                        </div>
                                    </div>
                                    <p class="m-b-0 text-white">

                                        @if ($settings->meat_available == 0)
                                            Cannot be issued (In Stock)
                                        @else
                                            Available for Issue
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-green">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white">
                                                Total Available
                                            </h6>
                                            <h3 class="m-b-0 f-w-700 text-white">
                                                {{ $total }}
                                            </h3>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign text-c-green f-18"></i>
                                        </div>
                                    </div>
                                    <p class="m-b-0 text-white"> + From Previous Month
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card prod-p-card card-yellow">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-30">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white text-center">Status</h6>
                                            <h3 class="m-b-0 f-w-700 text-white text-center">
                                                @if ($settings->food_available == 1 || $settings->meat_available == 1)
                                                    AVAILABLE
                                                @else
                                                    NOT AVAILABLE
                                                @endif
                                            </h3>
                                        </div>

                                    </div>
                                    <p class="m-b-0 text-white text-center f-w-100">
                                        @if ($settings->food_available == 1 || $settings->meat_available == 1)
                                            Can be issued from date.
                                        @else
                                            Cannot be issued.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header" style="margin-bottom: 0;padding-bottom:0;">
                                    <h4 style="font-size:16px;margin-bottom:0;font-weight: bold;">Recently used job cards
                                        and their quantities <span class="float-right"><a href=""
                                                class="d-inline btn btn-sm btn-round btn-outline-secondary">Add new job
                                                card</a></span> </h4>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="basic-btn" class="table table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Job Card Number</th>
                                                    <th>Date Opened</th>
                                                    <th>Month</th>
                                                    <th>Type</th>
                                                    <th>Quantity</th>
                                                    <th>Issued</th>
                                                    <th>Remaining</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($jobcards)
                                                    @foreach ($jobcards as $card)
                                                        <tr>
                                                            <td>{{ $card->card_number }}</td>
                                                            <td>{{ $card->date_opened }}</td>
                                                            <td>{{ $card->card_month }}</td>
                                                            <td>{{ $card->card_type }}</td>
                                                            <td>{{ $card->quantity }}</td>
                                                            <td>{{ $card->issued }}</td>
                                                            <td>{{ $card->remaining }}</td>
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
