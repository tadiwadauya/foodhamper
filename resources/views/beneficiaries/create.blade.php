@extends('layouts.app')

@section('template_title')
Add new Beneficiary
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
                    <h5>Beneficiaries</h5>
                    <span class="pcoded-mtext"> Add Beneficiary</span>
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
                        <a href="{{ url('beneficiaries') }}">Beneficiaries</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('beneficiaries/create') }}">Add New</a>
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
                                <h4 style="font-size: 18px">Add New Beneficiary</h4>
                            </div>
                            <div class="card-block mt-0 pt-0">
                                <h4 class="sub-title"></h4>
                                <form method="POST" action="{{ route('beneficiaries.store') }}">

                                    @csrf

                                    <div class="form-group row">
                                        <label for="first_name" class="col-sm-3 col-form-label">First Name : </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="first_name" class="form-control" id="first_name"
                                                required="" autofocus placeholder="e.g Vincent">
                                        </div>
                                        @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label for="last_name" class="col-sm-3 col-form-label">Last Name : </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="last_name" class="form-control" id="last_name"
                                                required="" autofocus placeholder="e.g Marufu">
                                        </div>
                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label for="id_number" class="col-sm-3 col-form-label">ID Number : </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="id_number" class="form-control" id="id_number"
                                                required="" autofocus placeholder="e.g 633027241W07">
                                        </div>
                                        @error('id_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label for="mobile_number" class="col-sm-3 col-form-label">Mobile Number :
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="mobile_number" class="form-control"
                                                id="mobile_number" required="" autofocus placeholder="e.g 0784333915">
                                        </div>
                                        @error('mobile_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row justify-content-end">
                                        <button
                                            class="btn waves-effect btn-round waves-light btn-sm mr-4 btn-primary">Add
                                            Beneficiary</button>
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
        $('#user_id').select2({
            placeholder:'Please select employee name',
        });
    });
</script>
@endsection
