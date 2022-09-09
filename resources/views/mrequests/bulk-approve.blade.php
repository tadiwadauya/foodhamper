@extends('layouts.app')

@section('template_linked_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/datatables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/buttons.datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
@endsection

@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            @include('partials.form-status')
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>Food Distribution</h5>
                        <span class="pcoded-mtext"> Food humber distribution overview</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
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
                                <div class="card-header" style="border-bottom: 1px solid #dee2e6;">
                                    <h4>Bulk Approval</h4>
                                    <p>Select requests to approve , once finish click process distribution</p>
                                </div>
                                <form action="{{ url('multi-insert-post') }}" method="POST" role="form"
                                    class="needs-validation">
                                    <div class="card-block">


                                        @csrf
                                        <table class="table" style="border-top: none;">
                                            <thead>
                                                <tr>
                                                    <th style="border-top: none;"><input class='check_all' type='checkbox'
                                                            onclick="select_all()" /></th>
                                                    <th style="border-top: none;">Paynumber</th>
                                                    <th style="border-top: none;">Department </th>
                                                    <th style="border-top: none;">Name </th>
                                                    <th style="border-top: none;">Allocation </th>
                                                    <th style="border-top: none;">Requested On </th>
                                                    <th style="border-top: none;">Requested By </th>
                                                    <th style="border-top: none;">Type </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type='checkbox' class='chkbox' /></td>
                                                    <td><input type="text" class="form-control autocomplete_txt"
                                                            data-type="paynumber" name="paynumber[]" id="paynumber_1"></td>
                                                    <td><input type="text" class="form-control" data-type="department"
                                                            name="department[]" id="department_1"></td>
                                                    <td><input type="text" class="form-control" data-type="name"
                                                            name="name[]" id="name_1"></td>
                                                    <td><input type="text" class="form-control" data-type="allocation"
                                                            name="allocation[]" id="allocation_1"></td>
                                                    </td>
                                                    <td><input type="text" class="form-control" data-type="created_at"
                                                            name="created_at[]" id="created_at_1"></td>
                                                    </td>
                                                    <td><input type="text" class="form-control" data-type="done_by"
                                                            name="done_by[]" id="done_by_1"></td>
                                                    </td>
                                                    <td><input type="text" class="form-control" data-type="reqtype"
                                                            name="reqtype[]" id="reqtype_1"></td>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class='btn btn-sm btn-danger delete'>- Delete</button>
                                        <button type="button" class='btn btn-sm btn-success addbtn'>+ Add More</button>

                                    </div>
                                    <div class="card-footer" style="border-top: 1px solid #dee2e6;">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <button type="reset" class="btn btn-sm btn-secondary">Clear</button>
                                            </div>
                                            <div class="col-lg-6 text-right">
                                                <button type="submit" class="btn btn-sm btn-primary mr-2" name="save"
                                                    id="save">Process Distribution</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('select2/js/select2.min.js') }}"></script>
    <script type="text/javascript" language="javascript">
        $(".delete").on('click', function() {
            $('.chkbox:checkbox:checked').parents("tr").remove();
            $('.check_all').prop("checked", false);
        });
        let i = $('table tr').length;
        $(".addbtn").on('click', function() {
            count = $('table tr').length;

            let data = "<tr><td><input type='checkbox' class='chkbox'/></td>";
            data +=
                '<td><input type="text" class="form-control autocomplete_txt" data-type="paynumber" name="paynumber[]" id="paynumber_' +
                i + '"></td>';
            data +=
                '<td><input type="text" class="form-control" data-type="department" name="department[]" id="department_' +
                i + '" ></td>';
            data += '<td><input type="text" class="form-control" data-type="name" name="name[]" id="name_' + i +
                '" ></td>';
            data +=
                '<td><input type="text" class="form-control" data-type="allocation" name="allocation[]" id="allocation_' +
                i + '" ></td></td>';
            data +=
                '<td><input type="text" class="form-control" data-type="created_at" name="created_at[]" id="created_at_' +
                i + '" ></td></td>';
            data +=
                '<td><input type="text" class="form-control" data-type="done_by" name="done_by[]" id="done_by_' +
                i + '" ></td></td>';
            data +=
                '<td><input type="text" class="form-control" data-type="reqtype" name="reqtype[]" id="reqtype_' +
                i + '" ></td></td>';
            $('table').append(data);
            i++;
        });

        function select_all() {
            $('input[class=chkbox]:checkbox').each(function() {
                if ($('input[class=check_all]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }

        //autocomplete script
        $(document).on('focus', '.autocomplete_txt', function() {
            type = $(this).data('type');

            if (type == 'paynumber') autoType = 'paynumber';

            $(this).autocomplete({
                minLength: 1,
                source: function(request, response) {
                    $.ajax({
                        type: 'GET',
                        url: "{{ URL::to('searchallocation') }}",
                        dataType: "json",
                        data: {
                            term: request.term,
                            type: type,
                        },
                        success: function(data) {
                            let array = $.map(data, function(item) {
                                return {
                                    label: item['paynumber'],
                                    value: item['id'],
                                    data: item
                                }
                            });
                            response(array)
                        }
                    });

                },
                select: function(event, ui) {
                    let data = ui.item.data;
                    id_arr = $(this).attr('id');
                    id = id_arr.split("_");
                    elementId = id[id.length - 1];

                    $('#paynumber_' + elementId).val(data.paynumber);
                    $('#department_' + elementId).val(data.department);
                    $('#name_' + elementId).val(data.name);
                    $('#allocation_' + elementId).val(data.allocation);
                    $('#created_at_' + elementId).val(data.created_at);
                    $('#done_by_' + elementId).val(data.done_by);
                    $('#reqtype_' + elementId).val(data.reqtype);
                    console.log(data.paynumber);
                }
            });
        });
    </script>
@endsection
