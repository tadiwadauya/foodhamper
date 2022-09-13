@extends('layouts.app')

@section('template_title')
    Create new jobcard
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
                        <h5>Jobcards</h5>
                        <span class="pcoded-mtext"> Add Job card</span>
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
                            <a href="{{ url('jobcards') }}">Jobcards</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('jobcards/create') }}">Add New</a>
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
                                    <h4 style="font-size:18px;">Create new jobcard <span class="float-right"><a
                                                href="{{ url('jobcards') }}"
                                                class="btn d-inline btn-sm btn-light btn-round waves-effect waves-dark">Back
                                                to Job Cards</a></span></h4>
                                </div>
                                <div class="card-block pt-0 mt-0">
                                    <h4 class="sub-title"></h4>
                                    <form method="POST" action="{{ route('jobcards.store') }}">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="card_number" class="col-sm-2 col-form-label">Job Card Number :
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" name="card_number" id="card_number"
                                                    class="form-control @error('card_number') is-invalid @enderror"
                                                    placeholder="e.g 121211121" required="" />
                                            </div>
                                            @error('card_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> {{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="date_opened" class="col-sm-2 col-form-label">Date Opened : </label>
                                            <div class="col-sm-10">
                                                <input type="date" name="date_opened" id="date_opened"
                                                    class="form-control @error('date_opened') is-invalid @enderror"
                                                    required="" />
                                            </div>
                                            @error('date_opened')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> {{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="card_month" class="col-sm-2 col-form-label">Month : </label>
                                            <div class="col-sm-10">
                                                <select name="card_month" id="card_month" class="form-control"
                                                    style="width: 100%;">
                                                    <option value="">Select month of issue</option>
                                                    <option value="January@php echo date('Y') @endphp">
                                                        January@php echo date('Y') @endphp</option>
                                                    <option value="February@php echo date('Y') @endphp">
                                                        February@php echo date('Y') @endphp</option>
                                                    <option value="March@php echo date('Y') @endphp">March@php echo date('Y') @endphp
                                                    </option>
                                                    <option value="April@php echo date('Y') @endphp">April@php echo date('Y') @endphp
                                                    </option>
                                                    <option value="May@php echo date('Y') @endphp">May@php echo date('Y') @endphp
                                                    </option>
                                                    <option value="June@php echo date('Y') @endphp">June@php echo date('Y') @endphp
                                                    </option>
                                                    <option value="July@php echo date('Y') @endphp">July@php echo date('Y') @endphp
                                                    </option>
                                                    <option value="August@php echo date('Y') @endphp">
                                                        August@php echo date('Y') @endphp</option>
                                                    <option value="September@php echo date('Y') @endphp">
                                                        September@php echo date('Y') @endphp</option>
                                                    <option value="October@php echo date('Y') @endphp">
                                                        October@php echo date('Y') @endphp</option>
                                                    <option value="November@php echo date('Y') @endphp">
                                                        November@php echo date('Y') @endphp</option>
                                                    <option value="December@php echo date('Y') @endphp">
                                                        December@php echo date('Y') @endphp</option>
                                                </select>
                                            </div>
                                            @error('card_month')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> {{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="card_type" class="col-sm-2 col-form-label">Job Card Type : </label>
                                            <div class="col-sm-10">
                                                <select name="card_type" id="card_type" class="form-control"
                                                    style="width: 100%;">
                                                    <option value="">Please select jobcard type</option>
                                                    <option value="Meat">Meat Humber</option>
                                                    <option value="Food">Food Humber</option>
                                                </select>
                                            </div>
                                            @error('card_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> {{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="quantity" class="col-sm-2 col-form-label">Quantity : </label>
                                            <div class="col-sm-10">
                                                <input type="number" name="quantity" id="quantity"
                                                    class="form-control @error('quantity') is-invalid @enderror"
                                                    required="" />
                                            </div>
                                            @error('quantity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> {{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row justify-content-end">
                                            <button
                                                class="btn waves-effect btn-round waves-light btn-sm btn-success mr-3">Add
                                                Job Card</button>
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
            $('#card_month').select2({
                placeholder: 'select jobcard month'
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#card_type').select2({
                placeholder: 'select job card type'
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#card_month').select2({
                placeholder: 'select month'
            });
        });
    </script>
@endsection
