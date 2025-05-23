@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.orders.show.title'))
@section('content')

    <style type="text/css" media="print">
        @page {
            size: auto;
            margin: 0;
        }

        @media print {
            a[href]:after {
                content: none !important;
            }

            img {
                width: 25%;
            }

            .contentPrint {
                width: 100%;
                /* font-family: tahoma; */
                font-size: 16px;
            }

            .invoice-body td.notbold {
                padding: 2px;
            }

            h2.invoice-title.uppercase {
                margin-top: 0px;
            }

            .invoice-content-2 {
                background-color: #fff;
                padding: 5px 20px;
            }

            .invoice-content-2 .invoice-cust-add,
            .invoice-content-2 .invoice-head {
                margin-bottom: 0px;
            }

            .no-print,
            .no-print * {
                display: none !important;
            }

            .product-img {
                max-width: 150px;
            }
        }
    </style>

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#.">
                            {{ __('order::dashboard.orders.index.title') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('order::dashboard.orders.show.title') }}</a>
                    </li>
                </ul>
            </div>
            <h1 class="page-title"></h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="no-print">
                        <div class="col-md-3">
                            <ul class="ver-inline-menu tabbable margin-bottom-10">
                                <li class="active">
                                    <a data-toggle="tab" href="#order">
                                        <i class="fa fa-cog"></i> {{ __('order::dashboard.orders.show.invoice_vendor') }}
                                    </a>
                                    <span class="after"></span>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#customer_order">
                                        <i class="fa fa-cog"></i> {{ __('order::dashboard.orders.show.invoice_customer') }}
                                    </a>
                                    <span class="after"></span>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#transactions">
                                        <i class="fa fa-cog"></i>
                                        {{ __('transaction::dashboard.orders.show.transactions') }}
                                    </a>
                                    <span class="after"></span>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#drivers">
                                        <i class="fa fa-cog"></i>
                                        {{ __('order::dashboard.orders.show.drivers.assign') }}
                                    </a>
                                    <span class="after"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9 contentPrint">
                        <div class="tab-content">
                            <div class="tab-pane active" id="order">
                                <div class="invoice">
                                    <div class="row invoice-logo">
                                        <div class="col-xs-6">
                                            <p>
                                                <img src="{{ url(config('setting.logo')) }}" class="img-responsive"
                                                    style="max-width: 25%;" />
                                            </p>
                                        </div>
                                        <div class="col-xs-6">
                                            <p> #{{ $order['id'] }} -
                                                {{ date('Y-m-d / H:i:s', strtotime($order->created_at)) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.user.username') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.user.email') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.user.mobile') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold"> {{ $order->orderAddress->username }}
                                                        </td>
                                                        <td class="text-center sbold"> {{ $order->orderAddress->email }}
                                                        </td>
                                                        <td class="text-center sbold"> {{ $order->orderAddress->mobile }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3>{{ __('order::dashboard.orders.show.address.data') }}</h3>
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.address.city') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.address.state') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.address.block') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.address.street') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.address.building') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.address.details') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold">
                                                            {{ $order->orderAddress->state->city->translate(locale())->title }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->orderAddress->state->translate(locale())->title }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->orderAddress->block }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->orderAddress->street }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->orderAddress->building }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->orderAddress->address }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <h3>{{__('order::dashboard.orders.show.other.data')}}</h3>
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.other.total_profit')}}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.other.total_profit_comission')}}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold"> {{ $order->total_profit }} </td>
                                                        <td class="text-center sbold"> {{ $order->total_profit_comission }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        <h3>{{ __('order::dashboard.orders.show.items.data') }}</h3>
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center" style="width:36%">
                                                            #
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.items.title') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.items.price') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.items.qty') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.items.off') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.items.total') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->orderProducts as $product)
                                                        <tr>
                                                            <td class="product-img text-center sbold" style="width:36%">
                                                                <img src="{{ url($product->product->image) }}"
                                                                    alt=""
                                                                    style="/*max-width:30%*/max-width: 150px;">
                                                            </td>
                                                            <td class="sbold">
                                                                <a
                                                                    href="{{ url(route('dashboard.products.edit', $product->product_id)) }}">
                                                                    {{ $product->product->translate(locale())->title }}
                                                                </a>
                                                                @if (is_null($product->orderVariant))
                                                                    <br>{{ $product->product->sku }}
                                                                    <br>{{__('catalog::frontend.products.notes')}}:  {{$product->notes}}
                                                                @endif
                                                                <br>
                                                                @if (!is_null($product->orderVariant))
                                                                    @foreach ($product->orderVariant->orderVariantValues as $value)
                                                                        <i>
                                                                            {{ $value->variantValue->optionValue->option->translate(locale())->title }}
                                                                            :
                                                                            {{ $value->variantValue->optionValue->translate(locale())->title }}
                                                                        </i>

                                                                        <br>{{ $product->orderVariant->variant->sku }}

                                                                        @if (!$loop->last)
                                                                            <br>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td class="text-center sbold"> {{ $product->price }} </td>
                                                            <td class="text-center sbold"> {{ $product->qty }} </td>
                                                            <td class="text-center sbold"> {{ $product->off }} </td>
                                                            <td class="text-center sbold"> {{ $product->total }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.order.subtotal') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.order.shipping') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.order.off') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.order.total') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('transaction::dashboard.orders.show.transaction.method') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.order.delivery_time') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold"> {{ $order->subtotal }} </td>
                                                        <td class="text-center sbold"> {{ $order->shipping }} </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->off }} - <br>

                                                            @if ($order->orderCoupon)
                                                                <a
                                                                    href="{{ url(route('dashboard.coupons.edit', $order->orderCoupon->coupon_id)) }}">
                                                                    {{ $order->orderCoupon->coupon->translate(locale())->title }}
                                                                </a>
                                                            @endif

                                                        </td>
                                                        <td class="text-center sbold"> {{ $order->total }}</td>
                                                        <td class="text-center sbold">
                                                            {{ ucfirst($order->transactions->method) }}</td>
                                                        <td class="text-center sbold">
                                                            {{ $order->date }} / {{ $order->time }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="customer_order">
                                <div class="invoice-content-2 bordered">
                                    <div class="row invoice-head">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="invoice-logo">
                                                <center>
                                                    <img src="{{ url(config('setting.logo')) }}" class="img-responsive"
                                                        alt="" style="max-width: 25%;" />
                                                    <a href="#.">
                                                        <h5>www.daftarkw.com</h5>
                                                    </a>
                                                    <span>
                                                        {{ $order->orderStatus->translate(locale())->title }}
                                                    </span>
                                                </center>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-6">
                                            <span class="bold uppercase">
                                                {{ $order->orderAddress->state->city->translate(locale())->title }} /
                                                {{ $order->orderAddress->state->translate(locale())->title }}
                                            </span>
                                            <br />
                                            <span class="bold">{{ __('order::dashboard.orders.show.address.block') }} :
                                            </span>
                                            {{ $order->orderAddress->block }}
                                            <br />
                                            <span class="bold">{{ __('order::dashboard.orders.show.address.street') }} :
                                            </span>
                                            {{ $order->orderAddress->street }}
                                            <br />
                                            <span class="bold">{{ __('order::dashboard.orders.show.address.building') }}
                                                : </span>
                                            {{ $order->orderAddress->building }}
                                            <br />
                                            <span class="bold">{{ __('order::dashboard.orders.show.address.details') }}
                                                : </span>
                                            {{ $order->orderAddress->address }}
                                        </div>
                                        <div class="col-md-6 col-xs-6">
                                            <div class="company-address">
                                                <h6 class="uppercase">#{{ $order['id'] }}</h6>
                                                <h6 class="uppercase">
                                                    {{ date('Y-m-d / H:i:s', strtotime($order->created_at)) }}</h6>
                                                <span class="bold">
                                                    {{ __('order::dashboard.orders.show.user.username') }} :
                                                </span>
                                                {{ $order->orderAddress->username }}
                                                <br />
                                                <span class="bold">
                                                    {{ __('order::dashboard.orders.show.user.mobile') }} :
                                                </span>
                                                {{ $order->orderAddress->mobile }}
                                                <br />
                                            </div>
                                        </div>
                                        <div class="row invoice-body">
                                            <div class="col-xs-12 table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="invoice-title uppercase text-center"
                                                                style="width:36%">
                                                                #
                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                {{ __('order::dashboard.orders.show.items.title') }}
                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                {{ __('order::dashboard.orders.show.items.price') }}
                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                {{ __('order::dashboard.orders.show.items.qty') }}
                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                {{ __('order::dashboard.orders.show.items.off') }}
                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                {{ __('order::dashboard.orders.show.items.total') }}
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->orderProducts as $product)
                                                            <tr>

                                                                <td class="product-img text-center sbold"
                                                                    style="width:36%">
                                                                    <img src="{{ url($product->product->image) }}"
                                                                        alt=""
                                                                        style="/*max-width:30%*/max-width: 150px;">
                                                                </td>
                                                                <td class="notbold text-center">
                                                                    <a
                                                                        href="{{ url(route('dashboard.products.edit', $product->product_id)) }}">
                                                                        {{ $product->product->translate(locale())->title }}
                                                                    </a>
                                                                    @if (is_null($product->orderVariant))
                                                                        <br>{{ $product->product->sku }}
                                                                    @endif
                                                                    <br>
                                                                    @if (!is_null($product->orderVariant))
                                                                        @foreach ($product->orderVariant->orderVariantValues as $value)
                                                                            <i>
                                                                                {{ $value->variantValue->optionValue->option->translate(locale())->title }}
                                                                                :
                                                                                {{ $value->variantValue->optionValue->translate(locale())->title }}
                                                                            </i>
                                                                            <br>{{ $product->orderVariant->variant->sku }}
                                                                            @if (!$loop->last)
                                                                                <br>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                                <td class="text-center notbold"> {{ $product->price }}
                                                                </td>
                                                                <td class="text-center notbold"> {{ $product->qty }} </td>
                                                                <td class="text-center notbold"> {{ $product->off }} </td>
                                                                <td class="text-center notbold"> {{ $product->total }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bold">
                                                                {{ __('order::dashboard.orders.show.order.total') }}
                                                            </th>
                                                            <th class="text-center bold"></th>
                                                            <th class="text-center bold">
                                                                {{ $order->orderProducts->sum('qty') }}</th>
                                                            <th class="text-center bold"> {{ $order->subtotal }} </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row invoice-subtotal">
                                            <div class="col-xs-2">
                                                <h2 class="invoice-title uppercase">
                                                    {{ __('order::dashboard.orders.show.order.subtotal') }}</h2>
                                                <p class="invoice-desc">{{ $order->subtotal }}</p>
                                            </div>
                                            <div class="col-xs-2">
                                                <h2 class="invoice-title uppercase">
                                                    {{ __('order::dashboard.orders.show.order.shipping') }}</h2>
                                                <p class="invoice-desc">{{ $order->shipping }} </p>
                                            </div>
                                            <div class="col-xs-2">
                                                <h2 class="invoice-title uppercase">
                                                    {{ __('order::dashboard.orders.show.order.off') }}</h2>
                                                <p class="invoice-desc grand-total">{{ $order->off }}</p>
                                            </div>
                                            <div class="col-xs-2">
                                                <h2 class="invoice-title uppercase">
                                                    {{ __('order::dashboard.orders.show.order.total') }}</h2>
                                                <p class="invoice-desc grand-total">{{ $order->total }}</p>
                                            </div>
                                            <div class="col-xs-2">
                                                <h2 class="invoice-title uppercase">
                                                    {{ __('transaction::dashboard.orders.show.transaction.method') }}
                                                </h2>
                                                <p class="invoice-desc grand-total">
                                                    {{ ucfirst($order->transactions->method) }}
                                                </p>
                                            </div>
                                            <div class="col-xs-2">
                                                <h2 class="invoice-title uppercase">
                                                    {{ __('order::dashboard.orders.show.order.delivery_time') }}
                                                </h2>
                                                <p class="invoice-desc grand-total">
                                                    {{ $order->date }} / {{ $order->time }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="transactions">
                                <div class="invoice">
                                    <div class="row invoice-logo">
                                        <div class="col-xs-6">
                                            <p>
                                                <img src="{{ url(config('setting.logo')) }}" class="img-responsive"
                                                    style="width:40%" />
                                            </p>
                                        </div>
                                        <div class="col-xs-6">
                                            <p> #{{ $order['id'] }} -
                                                {{ date('Y-m-d / H:i:s', strtotime($order->created_at)) }}
                                            </p>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row">
                                        <h3>{{ __('transaction::dashboard.orders.show.transactions') }}</h3>
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('transaction::dashboard.orders.show.transaction.payment_id') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('transaction::dashboard.orders.show.transaction.track_id') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('transaction::dashboard.orders.show.transaction.method') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('transaction::dashboard.orders.show.transaction.result') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('transaction::dashboard.orders.show.transaction.ref') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('transaction::dashboard.orders.show.transaction.tran_id') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold">
                                                            {{ $order->transactions->payment_id }}</td>
                                                        <td class="text-center sbold">
                                                            {{ $order->transactions->track_id }}</td>
                                                        <td class="text-center sbold"> {{ $order->transactions->method }}
                                                        </td>
                                                        <td class="text-center sbold"> {{ $order->transactions->result }}
                                                        </td>
                                                        <td class="text-center sbold"> {{ $order->transactions->ref }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->transactions->tran_id }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane" id="drivers">
                                <form id="updateForm" method="POST"
                                    action="{{ url(route('dashboard.orders.update', $order['id'])) }}"
                                    enctype="multipart/form-data" class="horizontal-form">
                                    <div class="no-print">
                                        @csrf
                                        <input name="_method" type="hidden" value="PUT">
                                        <div class="row">

                                            {{-- <div class="col-lg-12 col-xs-12 col-sm-12" style="margin-bottom: 15px;">
                                                <div class="form-group">
                                                    <label class="col-md-2">
                                                        {{ __('order::dashboard.orders.show.drivers.time') }}
                                                    </label>
                                                    <div class="col-md-9">
                                                        <select name="time" id="single"
                                                            class="form-control select2">
                                                            <option value=""></option>
                                                            @foreach ($times as $times)
                                                                <option
                                                                    value="{{ $times->from }} - {{ $times->to }}">
                                                                    {{ $times->from }} - {{ $times->to }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            @permission('edit_delivery_status')
                                                <div class="col-lg-12 col-xs-12 col-sm-12" style="margin-bottom: 15px;">
                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('order::dashboard.orders.show.drivers.delivery_status') }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <select name="delivery_status_id" id="delivery_status"
                                                                class="form-control" required>
                                                                @foreach ($deliveryStatuses as $status)
                                                                    <option value="{{ $status->id }}"
                                                                        {{ $order->delivery_status_id == $status->id ? 'selected' : '' }}>
                                                                        {{ $status->translate(locale())->title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endpermission

                                            <div class="col-lg-12 col-xs-12 col-sm-12" style="margin-bottom: 15px;">
                                                <div class="form-group">
                                                    <label class="col-md-2">
                                                        {{ __('order::dashboard.orders.show.drivers.status') }}
                                                    </label>
                                                    <div class="col-md-9">
                                                        <select name="order_status" id="single" class="form-control"
                                                            required>
                                                            @foreach ($statuses as $status)
                                                                <option value="{{ $status->id }}"
                                                                    {{ $order->order_status_id == $status->id ? 'selected' : '' }}>
                                                                    {{ $status->translate(locale())->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-xs-12 col-sm-12" style="margin-bottom: 15px;">
                                                <div class="form-group">
                                                    <label class="col-md-2">
                                                        {{ __('order::dashboard.orders.show.drivers.title') }}
                                                    </label>
                                                    <div class="col-md-9">
                                                        <select name="user_id" class="form-control">
                                                            <option value="">
                                                                --- {{ __('order::dashboard.orders.show.drivers.title') }}
                                                                ---
                                                            </option>
                                                            @foreach ($drivers as $driver)
                                                                <option value="{{ $driver->id }}"
                                                                    @if ($order->driver) {{ $order->driver->user_id == $driver->id ? 'selected' : '' }} @endif>
                                                                    {{ $driver->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-xs-12 col-sm-12" style="margin-bottom: 15px;">
                                                <div class="form-group">
                                                    <label class="col-md-2">
                                                        {{ __('order::dashboard.orders.show.payment.title') }}
                                                    </label>
                                                    <div class="col-md-9">
                                                        <select name="payment_method" class="form-control">
                                                            <option value="">
                                                                --- {{ __('order::dashboard.orders.show.payment.title') }}
                                                                ---
                                                            </option>
                                                            @foreach ($paymentMethods as $method)
                                                                <option value="{{ $method->code }}"
                                                                    @if ($order->transactions) {{ $order->transactions->method == $method->code ? 'selected' : '' }} @endif>
                                                                    {{ $method->code }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-xs-12 col-sm-12" style="margin-bottom: 15px;">
                                                <div class="form-group">
                                                    <label class="col-md-2">
                                                        {{ __('order::dashboard.orders.show.notes') }}
                                                    </label>
                                                    <div class="col-md-9">
                                                        <textarea name="notes" class="form-control" rows="6">{{ $order->notes }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div id="result" style="display: none"></div>

                                        <div class="progress-info" style="display: none">
                                            <div class="progress">
                                                <span class="progress-bar progress-bar-warning"></span>
                                            </div>
                                            <div class="status" id="progress-status"></div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" id="submit" class="btn green btn-lg">
                                                {{ __('apps::dashboard.general.edit_btn') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
                            {{ __('apps::dashboard.general.print_btn') }}
                            <i class="fa fa-print"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
