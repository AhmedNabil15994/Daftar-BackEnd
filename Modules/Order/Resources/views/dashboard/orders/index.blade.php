@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.orders.index.title'))
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('order::dashboard.orders.index.title') }}</a>
                    </li>
                </ul>
            </div>

            @permission('statistics')
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                            <div class="visual">
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $successOrders }}">0</span>
                                </div>
                                <div class="desc">{{ __('order::dashboard.orders.index.statistics.success_orders') }}</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 yellow" href="#">
                            <div class="visual">
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $failedOrders }}">0</span>
                                </div>
                                <div class="desc">{{ __('order::dashboard.orders.index.statistics.failed_orders') }}</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $canceledOrders }}">0</span>
                                </div>
                                <div class="desc">{{ __('order::dashboard.orders.index.statistics.canceled_orders') }}</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $returnedOrders }}">0</span> KWD
                                </div>
                                <div class="desc">{{ __('order::dashboard.orders.index.statistics.returned_orders') }}</div>
                            </div>
                        </a>
                    </div>

                </div>
            @endpermission

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">


                        {{-- DATATABLE FILTER --}}
                        <div class="row">
                            <div class="portlet box grey-cascade">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>
                                        {{ __('apps::dashboard.datatable.search') }}
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="filter_data_table">
                                        <div class="panel-body">
                                            <form id="formFilter" class="horizontal-form">
                                                <div class="form-body">

                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{ __('apps::dashboard.datatable.form.date_range') }}
                                                                </label>
                                                                <div id="reportrange" class="btn default form-control">
                                                                    <i class="fa fa-calendar"></i> &nbsp;
                                                                    <span> </span>
                                                                    <b class="fa fa-angle-down"></b>
                                                                    <input type="hidden" name="from">
                                                                    <input type="hidden" name="to">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{ __('apps::dashboard.datatable.form.soft_deleted') }}
                                                                </label>
                                                                <div class="mt-radio-list">
                                                                    <label class="mt-radio">
                                                                        {{ __('apps::dashboard.datatable.form.delete_only') }}
                                                                        <input type="radio" value="only"
                                                                            name="deleted" />
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio">
                                                                        {{ __('apps::dashboard.datatable.form.with_deleted') }}
                                                                        <input type="radio" value="with"
                                                                            name="deleted" />
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{ __('apps::dashboard.datatable.form.drivers') }}
                                                                </label>
                                                                <select name="driver" id="single"
                                                                    class="form-control select2-allow-clear">
                                                                    <option value="">
                                                                        {{ __('apps::dashboard.datatable.form.select') }}
                                                                    </option>
                                                                    @foreach ($drivers as $driver)
                                                                        <option value="{{ $driver['id'] }}">
                                                                            {{ $driver->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{ __('apps::dashboard.datatable.form.status') }}
                                                                </label>
                                                                <select name="status_id" id="single"
                                                                    class="form-control select2-allow-clear">
                                                                    <option value="">
                                                                        {{ __('apps::dashboard.datatable.form.select') }}
                                                                    </option>
                                                                    @foreach ($statuses as $status)
                                                                        <option value="{{ $status['id'] }}">
                                                                            {{ $status->translate(locale())->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{ __('apps::dashboard.datatable.form.payments') }}
                                                                </label>
                                                                <select name="payment_type" id="payments"
                                                                    class="form-control select2-allow-clear">
                                                                    <option value="">
                                                                        {{ __('apps::dashboard.datatable.form.select') }}
                                                                    </option>
                                                                    @foreach ($payments as $payment)
                                                                        <option value="{{ $payment['code'] }}">
                                                                            {{ $payment->code }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{ __('apps::dashboard.datatable.form.payment_status') }}
                                                                </label>
                                                                <select name="payment_status" id="paymentStatus"
                                                                    class="form-control select2-allow-clear">
                                                                    <option value="">
                                                                        {{ __('apps::dashboard.datatable.form.select') }}
                                                                    </option>
                                                                    <option value="paid">
                                                                        {{ __('apps::dashboard.datatable.form.paid') }}
                                                                    </option>
                                                                    <option value="unpaid">
                                                                        {{ __('apps::dashboard.datatable.form.unpaid') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{ __('apps::dashboard.datatable.form.vendors') }}
                                                                </label>
                                                                <select name="vendor_id" id="vendors"
                                                                    class="form-control select2-allow-clear">
                                                                    <option value="">
                                                                        {{ __('apps::dashboard.datatable.form.select') }}
                                                                    </option>
                                                                    @foreach ($vendors as $vendor)
                                                                        <option value="{{ $vendor['id'] }}">
                                                                            {{ $vendor->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                            <div class="form-actions">
                                                <button class="btn btn-sm green btn-outline filter-submit margin-bottom"
                                                    id="search">
                                                    <i class="fa fa-search"></i>
                                                    {{ __('apps::dashboard.datatable.search') }}
                                                </button>
                                                <button class="btn btn-sm red btn-outline filter-cancel">
                                                    <i class="fa fa-times"></i>
                                                    {{ __('apps::dashboard.datatable.reset') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END DATATABLE FILTER --}}

                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">
                                    {{ __('order::dashboard.orders.index.title') }}
                                </span>
                            </div>
                        </div>

                        {{-- DATATABLE CONTENT --}}
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <a href="javascript:;" onclick="CheckAll()">
                                                {{ __('apps::dashboard.general.select_all_btn') }}
                                            </a>
                                        </th>
                                        <th>#</th>
                                        <th>{{ __('order::dashboard.orders.datatable.created_at') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.total') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.method') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.shipping') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.status') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.delivery_status') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.time') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.driver') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.options') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        @include('order::dashboard.shared._bulk_order_actions', ['printPage' => 'orders'])

                        {{--  <div class="row">
                            <div class="form-group">
                                <button type="submit" id="deleteChecked" class="btn red btn-sm"
                                        onclick="deleteAllChecked('{{ url(route('dashboard.orders.deletes')) }}')">
                                    {{__('apps::dashboard.datatable.delete_all_btn')}}
                                </button>
                            </div>
                        </div>  --}}

                    </div>
                </div>
            </div>


        </div>
    </div>
@stop

@section('scripts')

    @include('order::dashboard.shared._bulk_order_actions_js')

    <script>
        function tableGenerate(data = '') {

            var dataTable =
                $('#dataTable').DataTable({

                    "createdRow": function(row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }

                        if (data["unread"] == false) {
                            $(row).addClass('danger');
                        }
                    },
                    ajax: {
                        url: "{{ url(route('dashboard.orders.datatable')) }}",
                        type: "GET",
                        data: {
                            req: data,
                        },
                    },
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ ucfirst(LaravelLocalization::getCurrentLocaleName()) }}.json"
                    },
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    responsive: !0,
                    order: [
                        [1, "desc"]
                    ],
                    columns: [{
                            data: 'id',
                            className: 'dt-center'
                        },
                        {
                            data: 'id',
                            className: 'dt-center'
                        },
                        {
                            data: 'created_at',
                            className: 'dt-center'
                        },
                        {
                            data: 'total',
                            className: 'dt-center'
                        },
                        {
                            data: 'transaction',
                            className: 'dt-center',
                            orderable: false
                        },
                        {
                            data: 'shipping',
                            className: 'dt-center',
                            orderable: false
                        },
                        {
                            data: 'order_status_id',
                            className: 'dt-center',
                            orderable: false
                        },
                        {
                            data: 'delivery_status',
                            className: 'dt-center',
                            orderable: false
                        },
                        {
                            data: 'time',
                            className: 'dt-center',
                            orderable: false
                        },
                        {
                            data: 'driver',
                            className: 'dt-center',
                            orderable: false
                        },
                        {
                            data: 'id'
                        },
                    ],
                    columnDefs: [{
                            targets: 0,
                            width: '30px',
                            className: 'dt-center',
                            orderable: false,
                            render: function(data, type, full, meta) {
                                return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" value="` + data + ` class="group-checkable" name="ids">
                                    <span></span>
                                    </label>
                                `;
                            },
                        },
                        {
                            targets: -1,
                            responsivePriority: 1,
                            width: '13%',
                            title: '{{ __('order::dashboard.orders.datatable.options') }}',
                            className: 'dt-center',
                            orderable: false,
                            render: function(data, type, full, meta) {

                                var printUrl = '{{ url(route('dashboard.orders.print_selected_items')) }}' +
                                    '?page=ordres' + '&ids=' + data;

                                var showUrl = '{{ route('dashboard.orders.show', ':id') }}';
                                showUrl = showUrl.replace(':id', data);

                                return `
                                @permission('show_orders')
                                    <a href="` + showUrl + `" class="btn btn-sm btn-warning" title="Show">
                                    <i class="fa fa-eye"></i>
                                    </a>
                                @endpermission
                                <a href="` + printUrl + `" class="btn btn-sm btn-default" title="Print">
                                    <i class="fa fa-print"></i>
                                </a>
                                `;

                            },
                        },
                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, 500],
                        ['10', '25', '50', '100', '500']
                    ],
                    buttons: [{
                            extend: "pageLength",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.pageLength') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                            }
                        },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.print') }}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                            }
                        },
                        {
                            extend: "pdfHtml5",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.pdf') }}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "{{ __('apps::dashboard.datatable.excel') }}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.colvis') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                            }
                        }
                    ]
                });
        }

        jQuery(document).ready(function() {
            tableGenerate();
        });
    </script>

@stop
