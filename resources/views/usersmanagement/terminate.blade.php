@extends('layouts.app')

@section('template_title')
    Terminate User
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
                    <h5>Users</h5>
                    <span class="pcoded-mtext"> Terminate Employee</span>
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
                        <a href="{{ url('users') }}">Users</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('users/create') }}">Add New</a>
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
                            <h4 style="font-size: 18px">Terminate Employee Contract</h4>
                            <p>Please select employee pay number first for the temination process</p>
                        </div>
                        <div class="card-block mt-0 pt-0">
                            <h4 class="sub-title"></h4>
                            <form method="POST" action="{{ url('terminate-post') }}" class="needs-validation">
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
                                                    <option value="{{ $user->paynumber }}">( {{ $user->paynumber }} ) {{ $user->first_name }} {{ $user->last_name }}</option>
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
                                    <label for="department" class="col-sm-3 col-form-label"
                                        >Department Name : </label
                                    >
                                    <div class="col-sm-9">
                                        <select name="department" id="department" class="form-control" style="width: 100%;" required="">
                                            <option value="">Please select department manager</option>
                                        </select>
                                    </div>
                                    @error('department')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="reason" class="col-sm-3 col-form-label"
                                        >Reason for Termination : </label
                                    >
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="reason" id="reason" rows="5"></textarea>
                                    </div>

                                    @error('reason')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row justify-content-end">
                                    <button class="btn waves-effect btn-round waves-light btn-sm mr-4 btn-primary">Process Termination</button>
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
        placeholder:'select employee pay number'
    }).change(function(){
        var paynumber = $(this).val();
        var _token = $("input[name='_token']").val();
        if(paynumber){
            $.ajax({
                type:"get",
                url:"/get-user-department/"+paynumber,
                _token: _token ,
                success:function(res) {
                    if(res) {
                        $("#department").empty();
                        $.each(res,function(key, value){
                            $("#department").append('<option value="'+key+'">'+value+'</option>');
                        });
                    }
                }

            });
        }
    });

</script>

<script>
    $(document).ready(function() {
        $('#department').select2({
            placeholder:'Please select department',
        });
    });
</script>
@endsection
