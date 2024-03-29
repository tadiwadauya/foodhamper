@extends('layouts.app')

@section('template_title')
    Showing all jobcards
@endsection

@section('template_linked_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/datatables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/buttons.datatables.min.css') }}">
@endsection

@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            @include('partials.form-status')
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>Jobcards</h5>
                        <span class="pcoded-mtext"> Overview of jobcards Opened</span>
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
                                <div class="card-header" style="margin-bottom: 0;padding-bottom:0;">
                                    <h4 style="font-size:16px;margin-bottom:0;">Showing all jobcards</h4>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="basic-btn" class="table table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Card Number</th>
                                                    <th>Date Opened</th>
                                                    <th>Month</th>
                                                    <th>Card Type</th>
                                                    <th>Quantity</th>
                                                    <th>Issued</th>
                                                    <th>Remaining</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($jobcards)
                                                    @php
                                                        $i = 1;
                                                    @endphp

                                                    @foreach ($jobcards as $jobcard)
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $jobcard->card_number }}</td>
                                                            <td>{{ $jobcard->date_opened }}</td>
                                                            <td>{{ $jobcard->card_month }}</td>
                                                            <td style="text-transform: capitalize;">
                                                                {{ $jobcard->card_type }}</td>
                                                            <td>{{ $jobcard->quantity }}</td>
                                                            <td>{{ $jobcard->issued }}</td>
                                                            <td>{{ $jobcard->remaining }}</td>
                                                            <td style="white-space: nowrap;width:20%;">
                                                                <a href="{{ route('jobcards.edit', $jobcard->id) }}"
                                                                    data-toggle="tooltip" title="Edit Jobcard"
                                                                    class="d-inline btn btn-sm btn-primary"><i
                                                                        class="fa fa-pencil"></i></a>
                                                                <button type="button"
                                                                    class="d-inline btn-sm btn btn-success"
                                                                    data-toggle="modal" data-target="#showJobcard"
                                                                    data-issued="{{ $jobcard->issued }}"
                                                                    data-quantity="{{ $jobcard->quantity }}"
                                                                    data-month="{{ $jobcard->card_month }}"
                                                                    data-dateopened="{{ $jobcard->date_opened }}"
                                                                    data-cardnumber="{{ $jobcard->card_number }}"
                                                                    data-cardtype="{{ $jobcard->card_type }}"><i
                                                                        class="fa fa-eye"></i></button>
                                                                <form method="POST"
                                                                    action="{{ route('jobcards.destroy', $jobcard->id) }}"
                                                                    role="form" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="d-inline btn-sm btn btn-danger"
                                                                        data-toggle="tooltip" title="Delete Job card"><i
                                                                            class="fa fa-trash-o"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>

                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('jobcards.show')

@endsection

@section('footer_scripts')
    <script src="{{ asset('dash_resource/js/jquery.datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/datatables.buttons.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/jszip.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/pdfmake.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/vfs_fonts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/vfs_fonts-2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/buttons.colvis.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/buttons.print.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/buttons.html5.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/datatables.bootstrap4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/datatables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/extension-btns-custom.js') }}" type="text/javascript"></script>

    <script>
        $('#showJobcard').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var cardnumber = button.data('cardnumber')
            var dateopened = button.data('dateopened')
            var month = button.data('month')
            var quantity = button.data('quantity')
            var issued = button.data('issued')
            var cardtype = button.data('cardtype')
            var modal = $(this)
            modal.find('.modal-title').text('Show Jobcard No:  ' + cardnumber)
            modal.find('.card-number').text(cardnumber)
            modal.find('.date-opened').text(dateopened)
            modal.find('.month').text(month)
            modal.find('.quantity').text(quantity)
            modal.find('.issued').text(issued)
            modal.find('.cardtype').text(cardtype)
        })
    </script>
@endsection
