@extends('layouts.app')

@section('template_title')
    Add New Meat collection
@endsection

@section('template_linked_css')
    <link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jquery-steps/jquery.steps.css')}}">
    <style>
        fieldset.scheduler-border {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow:  0px 0px 0px 0px #000;
                    box-shadow:  0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1em !important;
            font-weight: bold !important;
            text-align: left !important;
            width:auto;
            padding:0 10px;
            border-bottom:none;
        }

        .beneficiary-hidden {
            display: none;
            visibility: hidden;
        }
        .beneficiary-visible {
            display: block;
            visibility: visible;
        }

        #hidden_div {
            display: none;
        }

    </style>
@endsection

@section('content')

<div class="page-header card">
    <div class="row align-items-end">
        @include('partials.form-status')
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h5>Meat Collections</h5>
                    <span class="pcoded-mtext"> Add Meat collection</span>
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
                            <div class="card-header pb-0">
                            <h4 style="margin-bottom:0">Add To Collection.</h4>
                            <span>Please complete the request details before proceeding feather with the application</span>
                        </div>
                            <div class="card-body">

                                <form method="POST" action="{{ url('mcollections') }}" id="form-horizontal"  role="form" class="form-horizontal form-wizard-wrapper">

                                    @csrf

                                    <h3>Employee Details</h3>
                                    <fieldset>
                                        <div class="row mb-4 mb-4">
                                            <div class="col-lg-6">
                                                <label for="paynumber">Employee Paynumber *</label>
                                                <select name="paynumber" id="paynumber" class="form-control" style="width: 100%;">
                                                    <option value="">Select requested employee paynumber</option>
                                                    @if($requests)
                                                        @foreach ($requests as $request)
                                                            <option value="{{ $request->id }}">{{ $request->user->paynumber }} - {{ $request->user->full_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('paynumber')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="jobcard">Job Card Number *</label>
                                                <input type="text" name="jobcard" id="jobcard" class="form-control" readonly placeholder="select jobcard">

                                                @error('jobcard')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-4 mb-4">
                                            <div class="col-lg-6">
                                                <label for="frequest">Request Number *</label>
                                                <input type="text" name="frequest" id="frequest" class="form-control" placeholder="REQ112">

                                                @error('frequest')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="allocation">Allocation Month *</label>
                                                <input type="text" name="allocation" id="allocation" class="form-control" placeholder="244January2021">

                                                @error('allocation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-4 mb-4">
                                            <div class="col-lg-6">
                                                <label for="issue_date">Issue Date *</label>
                                                <input type="date" name="issue_date" id="issue_date" class="form-control" placeholder="02-07-21">

                                                @error('issue_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="row mb-4 mb-4">
                                            <div class="col-lg-12">
                                                <label for="type">Request Type *</label>
                                                <input type="text" name="type" id="type" class="form-control" placeholder="Meat Humber">

                                                @error('type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-4 mb-4">
                                            <div class="col-lg-12">
                                                <label for="mtype">Meat Type *</label>
                                                <input type="text" name="mtype" id="mtype" class="form-control" placeholder="Meat Type">

                                                @error('mtype')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                    </fieldset>

                                    <h3>Authentication</h3>
                                    <fieldset>
                                        <div class="row">

                                            <div class="col-lg-6">
                                                <label for="issue_date">Select Collection *</label> <br>
                                                <div class="form-check form-check-inline col-lg-3">
                                                    <input class="form-check-input" type="radio" name="iscollector" id="inlineRadio1" value="self" checked>
                                                    <label class="form-check-label" for="inlineRadio1">Self</label>
                                                </div>
                                                <div class="form-check form-check-inline col-lg-3">
                                                    <input class="form-check-input" type="radio" onchange="showDiv('hidden_div',this)" name="iscollector" id="inlineRadio2" value="other">
                                                    <label class="form-check-label" for="inlineRadio2">Other</label>
                                                </div>

                                                @error('iscollector')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong> {{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div id="hidden_div">
                                                <div class="col-lg-12">
                                                <fieldset class="scheduler-border">
                                                    <legend class="scheduler-border">Beneficiary Details</legend>
                                                    <div class="control-group">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label for="collected_by">Beneficiary Name</label>
                                                                <select name="collected_by" id="collected_by" class="form-control" style="width: 100%;">
                                                                    <option value="">Please select employee beneficiary</option>
                                                                </select>

                                                                @error('collected_by')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong> {{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <p class="ml-3 d-block"><strong style="font-weight: bold; font-size:18px;">Note : </strong> Please enter authoriser verification pin to proceed further into the application</p>
                                                <div>
                                                    <label for="pin">Enter Verification Pin</label>
                                                    <input type="password" name="pin" id="pin" class="form-control" placeholder="1234">
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>
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

<script src="{{asset('plugins/jquery-steps/jquery.steps.min.js')}}"></script>
<script>
    $(function ()
    {
        $("#form-horizontal").steps({
            headerTag: "h3",
            bodyTag: "fieldset",
            transitionEffect: "slide",
            onFinished: function (event, currentIndex)
            {
                var form = $(this);
                form.submit();
            }
        });

            $('#paynumber').select2({
                placeholder:'Select requested employee paynumber'
            }).change(function(){
                var id = $(this).val();
                var _token = $("input[name='_token']").val();
                if(id){
                    $.ajax({
                        type:"get",
                        url:"/get-food-request/"+id,
                        _token: _token ,
                        success:function(res)
                        {
                            if(res)
                            {
                                $("#frequest").empty();
                                $.each(res,function(key, value){

                                    $("#frequest").val(value);
                                });

                            }
                        }

                    });

                    $.ajax({
                        type:"get",
                        url:"/getfrequestallocation/"+id,
                        _token: _token ,
                        success:function(res)
                        {
                            if(res)
                            {
                                $("#allocation").empty();
                                $.each(res,function(key, value){

                                    $("#allocation").val(value);
                                });

                            }
                        }

                    });

                    $.ajax({
                        type:"get",
                        url:"/getmeattype/"+id,
                        _token: _token ,
                        success:function(res)
                        {
                            if(res)
                            {
                                $("#mtype").empty();
                                $.each(res,function(key, value){

                                    $("#mtype").val(" 1. "+key+" 2. "+value);
                                });

                            }
                        }

                    });

                    $.ajax({
                        type:"get",
                        url:"/get-request-type/"+id,
                        _token: _token ,
                        success:function(res)
                        {
                            if(res)
                            {
                                $("#type").empty();
                                $.each(res,function(key, value){

                                    $("#type").val(value);
                                });

                            }
                        }

                    });

                    $.ajax({
                        type:"get",
                        url:"/getuserbeneficiaries/"+id,
                        _token: _token ,
                        success:function(res) {
                            if(res) {
                                $("#collected_by").empty();
                                $.each(res,function(key, value){
                                    $("#collected_by").append('<option value="'+key+'">'+key+' - '+value+'</option>');
                                });
                            }
                        }

                    });

                    $.ajax({
                        type:"get",
                        url:"/get-jobcard-request/"+id,
                        _token: _token ,
                        success:function(res) {
                            if(res) {
                                $("#jobcard").empty();
                                $.each(res,function(key, value){
                                    $("#jobcard").val(value);
                                });
                            }
                        }

                    });
                }
            });

        $('#collected_by').select2({
            placeholder: 'Please select employee beneficiary',
        });
    });
</script>

<script>

    function showDiv(divId, element)
    {
        document.getElementById(divId).style.display = element.value == 'other' ? 'block' : 'none';
    }

</script>


@endsection
