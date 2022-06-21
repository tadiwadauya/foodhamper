@extends('layouts.app')

@section('template_title')
    Edit Jobcard
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
                        <a href="index.html"
                        ><i class="feather icon-home"></i
                        ></a>
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
                            <h4 style="font-size: 18px;">Update job card details</h4>
                            <p> <strong style="font-weight:bold">NB: </strong> Please note that card number, date opened, card type and month can only be updated before the job card is used.</p>
                        </div>
                        <div class="card-block pt-0 mt-0">
                            <h4 class="sub-title"></h4>
                            <form method="POST" action="{{ route('jobcards.update',$jobcard) }}">
                                @csrf
                                @method('put')
                                <div class="form-group row">
                                    <label for="card_number" class="col-sm-2 col-form-label"
                                        >Card Number : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $jobcard->card_number }}" name="card_number" id="card_number" class="form-control @error('card_number') is-invalid @enderror" placeholder="e.g 121211121" required="" />
                                    </div>
                                    @error('card_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="date_opened" class="col-sm-2 col-form-label"
                                        >Date Opened : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="date" value="{{ $jobcard->date_opened }}" name="date_opened" id="date_opened" class="form-control @error('date_opened') is-invalid @enderror" required="" />
                                    </div>
                                    @error('date_opened')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="card_month" class="col-sm-2 col-form-label"
                                        >Card Month : </label
                                    >
                                    <div class="col-sm-10">
                                        <select name="card_month" id="card_month" class="form-control" style="width: 100%;">
                                            <option value="{{ $jobcard->card_month }}">{{ $jobcard->card_month }}</option>
                                            <option value="January@php echo date('Y') @endphp">January@php echo date('Y') @endphp</option>
                                            <option value="February@php echo date('Y') @endphp">February@php echo date('Y') @endphp</option>
                                            <option value="March@php echo date('Y') @endphp">March@php echo date('Y') @endphp</option>
                                            <option value="April@php echo date('Y') @endphp">April@php echo date('Y') @endphp</option>
                                            <option value="May@php echo date('Y') @endphp">May@php echo date('Y') @endphp</option>
                                            <option value="June@php echo date('Y') @endphp">June@php echo date('Y') @endphp</option>
                                            <option value="July@php echo date('Y') @endphp">July@php echo date('Y') @endphp</option>
                                            <option value="July@php echo date('Y') @endphp">August@php echo date('Y') @endphp</option>
                                            <option value="July@php echo date('Y') @endphp">September@php echo date('Y') @endphp</option>
                                            <option value="July@php echo date('Y') @endphp">October@php echo date('Y') @endphp</option>
                                            <option value="July@php echo date('Y') @endphp">November@php echo date('Y') @endphp</option>
                                            <option value="July@php echo date('Y') @endphp">Devember@php echo date('Y') @endphp</option>
                                        </select>
                                    </div>
                                    @error('card_month')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="card_type" class="col-sm-2 col-form-label"
                                        >Card Type : </label
                                    >
                                    <div class="col-sm-10">
                                        <select name="card_type" id="card_type" class="form-control" style="width: 100%;">
                                            <option value="{{ $jobcard->card_type }}">{{ $jobcard->card_type }}</option>
                                            <option value="meet">Meet</option>
                                            <option value="food">Food</option>
                                        </select>
                                    </div>
                                    @error('card_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="quantity" class="col-sm-2 col-form-label"
                                        >Quantity : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="number" value="{{ $jobcard->quantity }}" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" required="" />
                                    </div>
                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="	issued" class="col-sm-2 col-form-label"
                                        >Issued : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="number" value="{{ $jobcard->issued }}" name="issued" id="issued" class="form-control @error('issued') is-invalid @enderror" required="" />
                                    </div>
                                    @error('issued')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="remaining" class="col-sm-2 col-form-label"
                                        >Remaining : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="number" value="{{ $jobcard->remaining }}" name="remaining" id="remaining" class="form-control @error('remaining') is-invalid @enderror" required="" />
                                    </div>
                                    @error('remaining')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="extras_previous" class="col-sm-2 col-form-label"
                                        >Extra Previous : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="number" value="{{ $jobcard->extras_previous }}" name="extras_previous" id="extras_previous" class="form-control @error('extras_previous') is-invalid @enderror" required="" />
                                    </div>
                                    @error('extras_previous')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row justify-content-end">
                                    <button class="btn waves-effect btn-round waves-light btn-sm btn-success mr-3">Update Job Card</button>
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
            placeholder:'select jobcard month'
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#card_type').select2({
            placeholder:'select job card type'
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#card_month').select2({
            placeholder:'select month'
        });
    });
</script>
@endsection
