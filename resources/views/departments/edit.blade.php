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
                    <h5>Departments</h5>
                    <span class="pcoded-mtext"> Edit Department</span>
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
                        <a href="{{ url('departments') }}">Departments</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('departments/create') }}">Add New</a>
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
                            <h4 style="font-size: 18px"> Edit {{ $department->department }} Department</h4>
                        </div>
                        <div class="card-block mt-0 pt-0">
                            <h4 class="sub-title"></h4>
                            <form method="POST" action="{{ route('departments.update',$department->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="department" class="col-sm-2 col-form-label"
                                        >Department Name : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $department->department }}" name="department" id="department" class="form-control @error('department') is-invalid @enderror" placeholder="e.g IT" required="" autofocus/>
                                    </div>
                                    @error('department')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="manager" class="col-sm-2 col-form-label"
                                        >Manager : </label
                                    >
                                    <div class="col-sm-10">
                                        <select name="manager" id="manager" class="form-control">
                                            <option value="{{ $department->manager }}">{{ $department->manager }}</option>
                                            @if ($users)
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->paynumber }}">( {{ $user->paynumber }} ) {{ $user->first_name }} {{ $user->last_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('manager')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="assistant" class="col-sm-2 col-form-label"
                                        >Assistant Manager : </label
                                    >
                                    <div class="col-sm-10">
                                        <select name="assistant" id="assistant" class="form-control">
                                            <option value="{{ $department->assistant }}">{{ $department->assistant }}</option>
                                            @if ($users)
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->paynumber }}">( {{ $user->paynumber }} ) {{ $user->first_name }} {{ $user->last_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('assistant')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row justify-content-end">
                                    <button class="btn waves-effect btn-round waves-light btn-sm mr-4 btn-primary">Update Department</button>
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
