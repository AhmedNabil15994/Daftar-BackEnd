@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.orders.reports.title'))
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
                        <a href="#">{{__('order::dashboard.orders.reports.title')}}</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">

                        {{-- DATATABLE FILTER --}}
                        <div class="row">
                            <div class="portlet box grey-cascade">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>
                                        {{__('apps::dashboard.datatable.search')}}
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
                                                                    {{__('apps::dashboard.datatable.form.date_range')}}
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
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{__('apps::dashboard.datatable.form.drivers')}}
                                                                </label>
                                                                <select name="driver" id="single" class="form-control">
                                                                    <option value="">
                                                                        {{__('apps::dashboard.datatable.form.select')}}
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
                                                                    {{__('apps::dashboard.datatable.form.vendors')}}
                                                                </label>
                                                                <select name="vendor" id="single" class="form-control">
                                                                    <option value="">
                                                                        {{__('apps::dashboard.datatable.form.select')}}
                                                                    </option>
                                                                    @foreach ($vendors as $vendor)
                                                                        <option value="{{ $vendor['id'] }}">
                                                                            {{ $vendor->translate(locale())->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{__('apps::dashboard.datatable.form.status')}}
                                                                </label>
                                                                <select name="status_id" id="single"
                                                                        class="form-control">
                                                                    <option value="">
                                                                        {{__('apps::dashboard.datatable.form.select')}}
                                                                    </option>
                                                                    @foreach ($orderStatuses as $status)
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
                                                                    {{__('apps::dashboard.datatable.form.payments')}}
                                                                </label>
                                                                <select name="payment_type" id="payments"
                                                                        class="form-control">
                                                                    <option value="">
                                                                        {{__('apps::dashboard.datatable.form.select')}}
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
                                                </div>
                                            </form>
                                            <div class="form-actions">
                                                <button class="btn btn-sm green btn-outline filter-submit margin-bottom"
                                                        id="search">
                                                    <i class="fa fa-search"></i>
                                                    {{__('apps::dashboard.datatable.search')}}
                                                </button>
                                                <button class="btn btn-sm red btn-outline filter-cancel">
                                                    <i class="fa fa-times"></i>
                                                    {{__('apps::dashboard.datatable.reset')}}
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
                                {{__('order::dashboard.orders.reports.title')}}
                            </span>
                            </div>
                        </div>

                        {{-- DATATABLE CONTENT --}}
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTable">
                                <thead>
                                <tr>
                                    <th colspan="6"></th>
                                    <th colspan="6"></th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('order::dashboard.orders.datatable.created_at')}}</th>
                                    <th>{{__('order::dashboard.orders.datatable.driver')}}</th>
                                    <th>{{__('order::dashboard.orders.datatable.subtotal')}}</th>
                                    <th>{{__('order::dashboard.orders.datatable.shipping')}}</th>
                                    <th>{{__('order::dashboard.orders.datatable.total')}}</th>
                                    <th>{{__('order::dashboard.orders.datatable.status')}}</th>
                                    <th>{{__('order::dashboard.orders.datatable.method')}}</th>
                                    <th>{{__('order::dashboard.orders.datatable.time')}}</th>
                                    <th>{{__('order::dashboard.orders.datatable.options')}}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="row">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

    <script>
        function tableGenerate(data = '') {

            var dataTable =
                $('#dataTable').DataTable({
                    ajax: {
                        url: "{{ url(route('dashboard.orders.datatable')) }}",
                        type: "GET",
                        data: {
                            req: data,
                        },
                    },
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
                    },
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    responsive: !0,
                    order: [[0, "desc"]],
                    "headerCallback": function (thead, data, start, end, display) {
                        $(thead).addClass('success');

                        var api = this.api(), data;

                        var intVal = function (i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        var total = api
                            .column(5)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        $(thead).find('th').eq(0).html("{{__('order::dashboard.orders.datatable.total')}}");
                        $(thead).find('th').eq(1).html(parseFloat(total).toFixed(3));

                    },
                    columns: [
                        {data: 'id', className: 'dt-center'},
                        {data: 'created_at', className: 'dt-center'},
                        {data: 'driver', className: 'dt-center', orderable: false},
                        {data: 'subtotal', className: 'dt-center'},
                        {data: 'shipping', className: 'dt-center'},
                        {data: 'total', className: 'dt-center'},
                        {data: 'order_status_id', className: 'dt-center'},
                        {data: 'transaction', className: 'dt-center', orderable: false},
                        {data: 'time', className: 'dt-center'},
                        {data: 'id'},
                    ],
                    columnDefs: [
                        {
                            targets: -1,
responsivePriority:1,
                            width: '13%',
                            title: '{{__('order::dashboard.orders.datatable.options')}}',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {

                                // Show
                                var showUrl = '{{ route("dashboard.orders.show", ":id") }}';
                                showUrl = showUrl.replace(':id', data);

                                return `
                @permission('show_orders')
					<a href="` + showUrl + `" class="btn btn-sm btn-warning" title="Show">
		              <i class="fa fa-eye"></i>
		            </a>
				@endpermission`;

                            },
                        },
                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, 500],
                        ['10', '25', '50', '100', '500']
                    ],
                    buttons: [
                        {
                            extend: "pageLength",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pageLength')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.print')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "pdfHtml5",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pdf')}}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "{{__('apps::dashboard.datatable.excel')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.colvis')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        }
                    ]
                });
        }

        jQuery(document).ready(function () {
            tableGenerate();
        });
    </script>

@stop
