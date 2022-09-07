@extends('layouts.app')

@section('template_linked_css')
    <link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
@endsection

@section('template_title')
    Show user meat allocation for {{ $meatallocation->paynumber }}
@endsection

@section('content')

    <div class="page-header card">
        <div class="row align-items-end">
            @include('partials.form-status')
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>Allocations</h5>
                        <span class="pcoded-mtext"> Show user meat allocation for {{ $meatallocation->paynumber }}</span>
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
                            <a href="{{ url('meatallocations') }}">Meat Allocations</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('meatallocations/create') }}">Add New</a>
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
                                    <h4 style="margin-bottom:0">Meat Allocation Overview</h4>
                                    <p class="pt-3">Please be advised that you should only update the last meat allocation of the user e.g <strong style="font-weight: bold;"> @php echo date('FY'); @endphp </strong></p>
                                    <p><b style="font-weight: bold;">NB : </b> System automatically increments allocations based on the latest allocation.</p>
                                </div>
                                <div class="card-block" style="padding-top: 7px;margin-top:0;">
                                    <h4 class="sub-title">Description</h4>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6>Paynumber : </h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <h6>{{ $meatallocation->paynumber }}</h6>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6>Allocation : </h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <h6>{{ $meatallocation->allocation }}</h6>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6>Meat Type 1 : </h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <h6>{{ $meatallocation->meat_a }}</h6>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6>Meat Type 2 : </h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <h6>{{ $meatallocation->meat_b }}</h6>
                                        </div>
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
