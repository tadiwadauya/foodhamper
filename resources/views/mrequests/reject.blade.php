@extends('layouts.app')

@section('template_title')
    Reject Request no: {{ $mrequest->request }}
@endsection

@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            @include('partials.form-status')
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>Food Requests</h5>
                        <span class="pcoded-mtext"> Reject Request for {{ $mrequest->user->full_name }}</span>
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
                            <a href="{{ url('mrequests') }}">Food Requests</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('mrequests/create') }}">Add New</a>
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
                                    <h4 style="font-size:18px;">Reject Request</h4>
                                    @if ($mrequest->status == 'approved' || $mrequest->status == 'collected')
                                        <p>Please note, the selected request has been <strong class="d-inline"
                                                style="font-weight: bold; text-transform:uppercase;">{{ $mrequest->status }}</strong>
                                            already.</p>
                                    @endif
                                </div>
                                <div class="card-block" style="padding-top: 0;margin-top:0;">
                                    <h4 class="sub-title"></h4>
                                    <form method="POST" action="{{ route('mrequests.update', $mrequest->id) }}">
                                        @csrf
                                        @method('put')
                                        <div class="form-group row">
                                            <label for="paynumber" class="col-sm-2 col-form-label">Paynumber : </label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{ $mrequest->paynumber }}" name="paynumber"
                                                    id="paynumber"
                                                    class="form-control @error('paynumber') is-invalid @enderror"
                                                    required="" />
                                            </div>
                                            @error('paynumber')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> {{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 col-form-label">Full Name : </label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{ $mrequest->user->full_name }}"
                                                    name="name" id="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    required="" />
                                            </div>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> {{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group row">
                                            <label for="department" class="col-sm-2 col-form-label">Department : </label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{ $mrequest->user->department->name }}"
                                                    name="department" id="department"
                                                    class="form-control @error('department') is-invalid @enderror"
                                                    required="" />
                                            </div>
                                            @error('department')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> {{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group row">
                                            <label for="reason" class="col-sm-2 col-form-label">Reason For Rejection :
                                            </label>
                                            <div class="col-sm-10">
                                                <textarea name="reason" id="reason" class="form-control" rows="5"></textarea>
                                            </div>
                                            @error('reason')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> {{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group row justify-content-end">
                                            <button class="btn waves-effect btn-round waves-light btn-sm mr-4 btn-primary"
                                                @if ($mrequest->status == 'approved' || $mrequest->status == 'collected') disabled @endif>Reject Request</button>
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
@endsection
