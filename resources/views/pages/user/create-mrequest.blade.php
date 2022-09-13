@extends('layouts.app')

@section('template_title')
    Create new food request
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
                    <h5>Meat Requests</h5>
                    <span class="pcoded-mtext"> Add New</span>
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
                        <a href="{{ url('create-user-mrequest') }}">Add New</a>
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
                            <h4 style="font-size:18px;">Create new humber request <span>
                                @if ( $settings->meat_available == 1)
                                    <span class="badge badge-success">Status - [ You can request for both food and meat hamper]</span>
                                @elseif ($settings->food_available == 1)
                                    <span class="badge badge-warning">Status - [ You can request for food hamper only]</span>
                                @elseif ($settings->meat_available == 1)
                                    <span class="badge badge-warning">Status - [ You can request for meat hamper only]</span>
                                @else
                                    <span class="badge badge-danger">Status - [ Hampers are currently Unavailable]</span>
                                @endif
                            </span>

                            <p class="pt-2">Please note that if request type is extra humber , allocation is not considered.</p>
                        </div>
                        <div class="card-block" style="padding-top: 0;margin-top:0;">
                            <h4 class="sub-title"></h4>
                            <form method="POST" action="{{ route('mrequests.store') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="paynumber" class="col-sm-2 col-form-label"
                                        >Pay Number : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control  @error('paynumber') is-invalid @enderror" name="paynumber" value="{{ Auth::user()->paynumber }}" readonly id="paynumber">
                                    </div>

                                    @error('paynumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="department" class="col-sm-2 col-form-label"
                                        >Department : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="text" readonly name="department" id="department" value="{{ Auth::user()->department->name }}" class="form-control @error('department') is-invalid @enderror" placeholder="e.g Accounts" required="" />
                                    </div>
                                    @error('department')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label"
                                        >Name : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="text" readonly name="name" id="username" value="{{ Auth::user()->name}}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g Vincent" required="" />
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="allocation" class="col-sm-2 col-form-label"
                                        >Allocation : </label
                                    >
                                    <div class="col-sm-10">
                                        <select name="allocation" id="allocation" class="form-control" style="width: 100%">
                                            <option value="">Please select allocation</option>
                                            @foreach ( $meatallocations as $meatallocation)
                                                <option value="{{ $meatallocation->meatallocation }}">{{ $meatallocation->meatallocation }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('allocation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row justify-content-end">
                                    <button class="btn waves-effect btn-round waves-light btn-sm mr-4 btn-primary"
                                    @if ($settings->food_available == 0 && $settings->meat_available == 0)
                                        disabled
                                    @else

                                    @endif
                                    >Send Request</button>
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
    $('#type').select2();

    $('#allocation').select2();
</script>
@endsection
