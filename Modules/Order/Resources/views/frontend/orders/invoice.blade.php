@extends('apps::frontend.layouts.app')
@section('title', $order->id)
@section('content')
  <script language="javascript" type="text/javascript">
  function printerDiv(divID) {
    var divElements = document.getElementById(divID).innerHTML;
    var oldPage = document.body.innerHTML;
         document.body.innerHTML =
         "<html><head><title></title></head><body>" +
         divElements + "</body>";
    window.print();
    document.body.innerHTML = oldPage;
  }
  </script>

<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>#{{ $order->id }}</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="invoice-page" id="contentPrint">
        <h1 class="invoice-head">{{ __('order::frontend.orders.invoice.title') }}</h1>
        <div class="invoice-head-rec">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ url(config('setting.logo')) }}" class="img-responsive">
                </div>
            </div>
        </div>

        <div class="invoice-body">
            <div class="row">
                <div class="col-md-5">
                    <h1>{{ __('order::frontend.orders.invoice.title') }}</h1>
                    <address class="norm">
                        <p>
                            <b>{{ __('order::frontend.orders.invoice.username') }} : </b>
                            {{ $order->orderAddress->username }}
                        </p>
                        <p>
                            <b>{{ __('order::frontend.orders.invoice.email') }} :</b>
                            {{ $order->orderAddress->email }}
                        </p>
                        <p>
                            <b>{{ __('order::frontend.orders.invoice.mobile') }} :</b>
                            {{ $order->orderAddress->mobile }}
                        </p>
                        <p>
                          <b>{{ __('order::frontend.orders.invoice.address') }} :</b>
                          {{ $order->orderAddress->state->translate(locale())->title }},
                          {{ $order->orderAddress->state->city->translate(locale())->title }}
                        <p>
                        <p>
                            <b>{{ __('order::frontend.orders.invoice.block') }} :</b>
                            {{ $order->orderAddress->block }}
                        </p>

                        <p>
                            <b>{{ __('order::frontend.orders.invoice.street') }} :</b>
                            {{ $order->orderAddress->street }}
                        </p>

                        <p>
                            <b>{{ __('order::frontend.orders.invoice.building') }} :</b>
                            {{ $order->orderAddress->building }}
                        </p>

                        <p>
                            <b>{{ __('order::frontend.orders.invoice.details') }} :</b>
                            {{ $order->orderAddress->address }}
                        </p>
                    </address>
                </div>
                <div class="col-md-7">
                    <table class="meta">
                        <tr>
                            <th><span>#</span></th>
                            <td><span>{{$order->id}}</span></td>
                        </tr>
                        <tr>
                            <th><span>{{ __('order::frontend.orders.invoice.date') }}</span></th>
                            <td><span>{{$order->created_at}}</span></td>
                        </tr>
                        <tr>
                            <th><span>{{ __('order::frontend.orders.invoice.total') }}</span></th>
                            <td><span id="prefix">KWD </span><span> {{$order->total}}</span></td>
                        </tr>
                    </table>
                </div>
            </div>

            <table class="inventory">
                <thead>
                    <tr>
                        <th><span>#</span></th>
                        <th><span>{{ __('order::frontend.orders.invoice.product_title') }}</span></th>
                        <th><span>{{ __('order::frontend.orders.invoice.product_qty') }}</span></th>
                        <th><span>{{ __('order::frontend.orders.invoice.product_total') }}</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderProducts as $key => $orderProduct)
                    <tr>
                        <td><span>{{++$key}}</span></td>
                        <td>
                            <span>{{$orderProduct->product->translate(locale())->title}}</span>
                        </td>
                        <td><span>{{ $orderProduct->qty }}</span></td>
                        <td><span data-prefix>KWD </span><span> {{ $orderProduct->total }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="balance">
                <tr>
                    <th><span>{{ __('order::frontend.orders.invoice.subtotal') }}</span></th>
                    <td><span data-prefix> KWD </span><span> {{$order->subtotal}}</span></td>
                </tr>
                <tr>
                    <th><span>{{ __('order::frontend.orders.invoice.shipping') }}</span></th>
                    <td><span data-prefix>KWD </span><span> {{$order->shipping}}</span></td>
                </tr>
                <tr>
                    <th><span>{{ __('order::frontend.orders.invoice.method') }}</span></th>
                    <td><span data-prefix></span><span> {{ucfirst($order->transactions->method)}}</span></td>
                </tr>
                <tr>
                    <th><span>{{ __('order::frontend.orders.invoice.total') }}</span></th>
                    <td><span data-prefix>KWD </span><span> {{$order->total}}</span></td>
                </tr>
                <tr>
                    <th><span>{{ __('order::frontend.orders.invoice.date') }}</span></th>
                    <td><span> {{$order->date}}</span></td>
                </tr>
                <tr>
                    <th><span>{{ __('order::dashboard.orders.show.order.delivery_time') }}</span></th>
                    <td><span> {{$order->time}}</span></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="invoice-footer">
        <a class="btn main-btn print-rec" onclick="javascript:printerDiv('contentPrint')">
            <i class="fa fa-print"></i> {{ __('order::frontend.orders.invoice.btn.print') }}
        </a>
        {{-- @if ($order->order_status_id != 7)
          <a class="btn main-btn print-rec" href="{{ url(route('frontend.orders.reorder',$order['id'])) }}">
              <i class="fa fa-print"></i> {{ __('order::frontend.orders.invoice.btn.reorder') }}
          </a>
        @endif --}}
    </div>
</div>
@stop
