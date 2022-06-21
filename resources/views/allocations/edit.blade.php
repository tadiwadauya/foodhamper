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
                    <h5>Allocations</h5>
                    <span class="pcoded-mtext"> Add Allocation</span>
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
                        <a href="{{ url('allocations') }}">Allocations</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('allocations/create') }}">Add New</a>
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
                            <h4 style="margin-bottom:0">Update {{ $allocation->paynumber }} Allocation</h4>
                            <p class="pt-3">Please be advised that you should only update the last allocation of the user e.g <strong style="font-weight: bold;"> @php echo date('FY'); @endphp </strong></p>
                            <p><b style="font-weight: bold;">NB : </b> System automatically increments allocations based on the latest allocation.</p>
                        </div>
                        <div class="card-block" style="padding-top: 7px;margin-top:0;">
                            <h4 class="sub-title"></h4>
                            <form method="POST" action="{{ route('allocations.update',$allocation->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="paynumber" class="col-sm-2 col-form-label"
                                        >Paynumber : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="text" disabled="" name="paynumber" class="form-control" value="{{ $allocation->paynumber }}">
                                    </div>
                                    @error('paynumber')
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
                                        <input type="text" disabled="" class="form-control" value="{{ $allocation->allocation }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="meet_a" class="col-sm-2 col-form-label"
                                        >Meat Type 1 : </label
                                    >
                                    <div class="col-sm-10">
                                        <select name="meet_a" id="meet_a" class="form-control @error('meet_a') is-invalid @enderror" required="" style="width: 100%;">
                                            <option value="{{ $allocation->meet_a }}">{{ $allocation->meet_a }}</option>
                                            <option value="beef">Beef</option>
                                            <option value="chicken">Chicken</option>
                                            <option value="pork">Pork</option>
                                        </select>
                                    </div>
                                    @error('meet_a')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="meet_b" class="col-sm-2 col-form-label"
                                        >Meat Type 2 : </label
                                    >
                                    <div class="col-sm-10">
                                        <select name="meet_b" id="meet_b" class="form-control @error('meet_b') is-invalid @enderror" required="" style="width: 100%;">
                                            <option value="{{ $allocation->meet_b }}">{{ $allocation->meet_b }}</option>
                                            <option value="beef">Beef</option>
                                            <option value="chicken">Chicken</option>
                                            <option value="pork">Pork</option>
                                        </select>
                                    </div>
                                    @error('meet_b')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row justify-content-end">
                                    <button class="btn waves-effect btn-round waves-light btn-sm mr-4 btn-success">Update Allocation</button>
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
        $('#meet_a').select2({
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#meet_b').select2({
        });
    });
</script>
@endsection
