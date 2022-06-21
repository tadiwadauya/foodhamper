@extends('layouts.app')

@section('template_title')
    Configure Settings For Food Humbers
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
                        <h5>System Settings</h5>
                        <span class="pcoded-mtext"> Configure settings for food humber distribution</span>
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
                            <a href="{{ url('home') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('hsettings-get') }}">System Settings</a>
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
                                    <h4 style="font-size: 18px">CONFIGURE GLOBAL SETTINGS USED FOR FOOD HUMBER DISTRIBUTION.</h4>
                                </div>
                                <div class="card-block mt-0 pt-0" >
                                    <h4 class="sub-title"></h4>
                                    <form method="POST" action="{{ route('hsettings',$humber->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group row mt-2">
                                            <label for="manager" class="col-sm-4 col-form-label"
                                            >Is <strong style="font-weight: bold;">Food</strong> Humber Available : </label
                                            >
                                            <div class="col-sm-6">
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-round waves-effect waves-light btn-outline-info active">
                                                        <input type="radio" name="food_available" id="meat_available" value="1"> Make Food Available
                                                    </label>
                                                    <label class="btn btn-round btn-outline-info">
                                                        <input type="radio" name="food_available" id="meat_available" value="0"> Food is not available
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-2">
                                            <label for="manager" class="col-sm-4 col-form-label"
                                            >Is <strong style="font-weight: bold;">Meat</strong> Humber Available : </label
                                            >
                                            <div class="col-sm-6">
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-round waves-effect waves-light btn-outline-info active">
                                                        <input type="radio" name="meat_available" id="meat_available" value="1"> Make Meat Available
                                                    </label>
                                                    <label class="btn btn-round btn-outline-info">
                                                        <input type="radio" name="meat_available" id="meat_available" value="0"> Meat is not available
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row mt-2">
                                            <label for="name" class="col-sm-4 col-form-label">Last Modified By : </label>
                                            <div class="col-sm-5">
                                                <input type="text" style="padding: 10px 19px;" value="{{auth()->user()->name}}" name="last_agent" id="name" class="form-control" readonly />
                                            </div>

                                        </div>

                                        <div class="form-group row justify-content-center">
                                            <div class="col-lg-3">
                                                <button class="btn waves-effect btn-round waves-light btn-outline-primary btn-block">Update  Settings</button>
                                            </div>
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
            $('#manager').select2({
                placeholder:'Please select department manager',
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#assistant').select2({
                placeholder:'Please select department assistant manager',
            });
        });
    </script>
@endsection
