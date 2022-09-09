@extends('layouts.app')

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
                    <h5>Meat Allocations</h5>
                    <span class="pcoded-mtext"> Add Meat Allocation</span>
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
                            <h4 style="margin-bottom:0">Create new Meat Allocation</h4>
                        </div>
                        <div class="card-block" style="padding-top: 7px;margin-top:0;">
                            <h4 class="sub-title"></h4>
                            <form method="POST" action="{{ route('meatallocations.store') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="paynumber" class="col-sm-2 col-form-label"
                                        >Paynumber : </label
                                    >
                                    <div class="col-sm-10">
                                        <select name="paynumber" id="paynumber" class="form-control" style="width: 100%;">
                                            <option value="">Please select paynumber</option>
                                            @if ($users)
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->paynumber }}"> {{ $user->paynumber }} - {{ $user->full_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('paynumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="meatallocation" class="col-sm-2 col-form-label"
                                        >Month : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="text" id="meatallocation" class="form-control" name="meatallocation" placeholder="e.g January2021" required="" autofocus>
                                    </div>
                                    @error('meatallocation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="meat_a" class="col-sm-2 col-form-label"
                                        >Meat Type 1 : </label
                                    >
                                    <div class="col-sm-10">
                                        <select name="meat_a" id="meat_a" class="form-control" style="width: 100%;" required="" autofocus>
                                            <option value="">Please select meat type</option>
                                            <option value="beef">Beef</option>
                                            <option value="chicken">Chicken</option>
                                            <option value="pork">Pork</option>
                                        </select>
                                    </div>
                                    @error('meat_a')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="meat_b" class="col-sm-2 col-form-label"
                                        >Meat Type 2 : </label
                                    >
                                    <div class="col-sm-10">
                                        <select name="meat_b" id="meat_b" class="form-control" style="width: 100%;">
                                            <option value="">Please select meat type</option>
                                            <option value="beef">Beef</option>
                                            <option value="chicken">Chicken</option>
                                            <option value="pork">Pork</option>
                                        </select>
                                    </div>
                                    @error('meat_b')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row justify-content-end">
                                    <button class="btn waves-effect btn-round waves-light btn-sm mr-4 btn-success">Create Meat Allocation</button>
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
<script type="text/javascript">
    $('#paynumber').select2({
        placeholder:'Select user paynumber'
    });
</script>
<script>
    $(document).ready(function() {
        $('#meat_a').select2({
            placeholder:'Select meat type'
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#meat_b').select2({
            placeholder: 'Select meat type'
        });
    });
</script>
@endsection
