@extends('layouts.app')

@section('template_title')
    Assign Beneficiary
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
                    <span class="pcoded-mtext"> Assign Beneficiary</span>
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
                            <h4 style="font-size: 18px">Assign Beneficiary to Employee</h4>
                            <p>Please select employee pay number and Beneficiary name</p>
                        </div>
                        <div class="card-block mt-0 pt-0">
                            <h4 class="sub-title"></h4>
                            <form method="POST" action="{{ url('assign-beneficiary-post') }}" class="needs-validation">
                                @csrf
                                @method('POST')

                                <div class="form-group row">
                                    <label for="paynumber" class="col-sm-3 col-form-label"
                                        >Employee Pay Number : </label
                                    >
                                    <div class="col-sm-9">
                                        <select name="paynumber" id="paynumber" class="form-control" style="width: 100%;" required="">
                                            <option value="">Please select employee pay number</option>
                                            @if ($users)
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">( {{ $user->paynumber }} ) {{ $user->first_name }} {{ $user->last_name }}</option>
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
                                    <label for="beneficiary" class="col-sm-3 col-form-label"
                                        >Beneficiary Name : </label
                                    >
                                    <div class="col-sm-9">
                                        <select name="beneficiary" id="beneficiary" class="form-control" style="width: 100%;" required="">
                                            <option value="">Please select beneficiary</option>
                                            @if ($beneficiaries)
                                                @foreach ($beneficiaries as $item)
                                                    <option value="{{ $item->id }}">{{ $item->full_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('beneficiary')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="id_number" class="col-sm-3 col-form-label"
                                        >ID Number : </label
                                    >
                                    <div class="col-sm-9">
                                        <input type="text" name="id_number" id="id_number" class="form-control">
                                    </div>
                                    @error('id_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row justify-content-end">
                                    <button class="btn waves-effect btn-round waves-light btn-sm mr-4 btn-primary">Assign Beneficiary</button>
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
    $('#beneficiary').select2({
        placeholder:'select benefiary name'
    }).change(function(){
        var beneficiary = $(this).val();
        var _token = $("input[name='_token']").val();
        if(beneficiary){
            $.ajax({
                type:"get",
                url:"/get-beneficiary-id/"+beneficiary,
                _token: _token ,
                success:function(res) {
                    if(res) {
                        $("#id_number").empty();
                        $.each(res,function(key, value){
                            $("#id_number").val(value);
                        });
                    }
                }

            });
        }
    });

</script>

<script>
    $(document).ready(function() {
        $('#paynumber').select2({
            placeholder:'Please select department',
        });
    });
</script>
@endsection
