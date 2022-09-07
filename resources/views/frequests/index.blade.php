a@extends('layouts.app')

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
                        <h5>Requested Hampers</h5>
                        <span class="pcoded-mtext"> Overview Of Requested food Hampers</span>
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
                            <a href="{{ url('frequests') }}">Food Requests</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('frequests/create') }}">Add New</a>
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
                                    <h4 style="font-size:16px;margin-bottom:0;">Showing all Hampers distributed
                                        <span class="float-right mr-2"><a href="{{ url('delete_unattended_requests') }}"
                                                class="btn btn-danger btn-sm btn-round"><i class="fa fa-trash-o"></i>Delete
                                                Requests</a></span>
                                    </h4>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="basic-btn" class="table table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Paynumber</th>
                                                    <th>Name</th>
                                                    <th>Department</th>
                                                    <th>Allocation</th>
                                                    <th>Approved By</th>
                                                    <th>Requested On</th>
                                                    <th>Issued On</th>
                                                    <th>Status</th>
                                                    <th>Request Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($frequests)
                                                    @php
                                                        $i = 1;
                                                    @endphp

                                                    @foreach ($frequests as $frequest)
                                                        @php
                                                            $user = \App\Models\User::where('paynumber', $frequest->paynumber)->first();
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $frequest->paynumber }}</td>
                                                            <td>
                                                                {{ !empty($user->full_name) ? $user->full_name : '' }}
                                                            </td>
                                                            <td>{{ $frequest->department }}</td>
                                                            <td>{{ $frequest->allocation }}</td>
                                                            <td>
                                                                @if ($frequest->status == 'approved' || $frequest->status == 'collected')
                                                                    {{ $frequest->approve->name }}
                                                                @endif
                                                            </td>
                                                            <td>{{ $frequest->created_at }}</td>
                                                            <td>
                                                                {{ $frequest->issued_on }}
                                                            </td>
                                                            <td>
                                                                @if ($frequest->status == 'not approved')
                                                                    @php
                                                                        $badgeClass = 'warning';
                                                                    @endphp
                                                                @elseif($frequest->status == 'approved')
                                                                    @php
                                                                        $badgeClass = 'success';
                                                                    @endphp
                                                                @elseif($frequest->status == 'rejected')
                                                                    @php
                                                                        $badgeClass = 'danger';
                                                                    @endphp
                                                                @else
                                                                    @php $badgeClass = 'default' @endphp
                                                                @endif
                                                                <span
                                                                    class="badge badge-{{ $badgeClass }}">{{ $frequest->status }}</span>
                                                            </td>
                                                            <td>{{ $frequest->type }}</td>
                                                            <td style="white-space: nowrap;width:20%;">
                                                                <a href="{{ url('approve-request/' . $frequest->id) }}"
                                                                    data-toggle="tooltip" title="Approve Request"
                                                                    class="d-inline btn btn-sm btn-primary"><i
                                                                        class="fa fa-pencil"></i></a>
                                                                <a href="{{ url('reject-request/' . $frequest->id) }}"
                                                                    data-toggle="tooltip" title="Reject Request"
                                                                    class="d-inline btn btn-success btn-sm">x</a>
                                                                <form method="POST"
                                                                    action="{{ route('frequests.destroy', $frequest->id) }}"
                                                                    class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="d-inline btn-sm btn btn-danger"
                                                                        data-toggle="tooltip" title="Delete Request"><i
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
@endsection
