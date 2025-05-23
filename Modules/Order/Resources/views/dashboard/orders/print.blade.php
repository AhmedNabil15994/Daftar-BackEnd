<!DOCTYPE html>
<html dir="{{ locale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ locale() == 'ar' ? 'ar' : 'en' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('apps::dashboard.general.print_orders') }} || {{ config('app.name') }} </title>
    <meta name="description" content="">

    @if (locale() == 'ar')
    <link rel="stylesheet" href="{{ url('frontend/ar/css/bootstrap-ar.min.css') }}">
    @else
    <link rel="stylesheet" href="{{ url('frontend/en/css/bootstrap.min.css') }}">
    @endif

    <style>
        @media print {
            .hidden-print {
                display: none !important;
            }
        }
    </style>

    <script>
        window.print();
    </script>

</head>

<body>

    <div class="container" style="margin-top: 10px; margin-bottom: 10px;">

        <div class="row hidden-print">
            <div class="col-md-12 text-center" style="margin-bottom: 10px;">
                <button type="button" class="btn btn-info btn-sm" onclick="window.print();">
                    {{ __('apps::dashboard.general.print_btn') }}
                </button>

                @if (isset(request()->page) && request()->page == 'success')
                    <a href="{{ route('dashboard.orders.success') }}" class="btn btn-danger btn-sm">
                        {{ __('apps::dashboard.general.back_btn') }}
                    </a>
                @else
                    <a href="{{ route('dashboard.orders.index') }}" class="btn btn-danger btn-sm">
                        {{ __('apps::dashboard.general.back_btn') }}
                    </a>
                @endif
            </div>
            <hr width="50%">
        </div>

        @foreach ($orders as $order)
            <div class="invoice-content-2 bordered">
                <div class="row invoice-head">
                    <div class="col-md-12 col-xs-12">
                        <div class="invoice-logo">
                            <center>
                                <img src="{{ url(config('setting.logo')) }}" class="img-responsive" alt=""
                                    style="width: 100px;" />
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
                                        <th class="invoice-title uppercase text-center">
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

                                            <td class="product-img text-center sbold" style="width:50px; height: 50px;">
                                                <img src="{{ url($product->product->image) }}" alt=""
                                                    style="/*max-width:30%*/max-width: 150px;">
                                            </td>
                                            <td class="notbold text-center">
                                                {{ $product->product->translate(locale())->title }}
                                                @if (is_null($product->orderVariant))
                                                     / {{ $product->product->sku }}
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
                        <div class="col-xs-1">
                            <h5 class="invoice-title uppercase">
                                {{ __('order::dashboard.orders.show.order.subtotal') }}</h5>
                            <p class="invoice-desc">{{ $order->subtotal }}</p>
                        </div>
                        <div class="col-xs-2">
                            <h5 class="invoice-title uppercase">
                                {{ __('order::dashboard.orders.show.order.shipping') }}</h5>
                            <p class="invoice-desc">{{ $order->shipping }} </p>
                        </div>
                        <div class="col-xs-2">
                            <h5 class="invoice-title uppercase">
                                {{ __('order::dashboard.orders.show.order.off') }}</h5>
                            <p class="invoice-desc grand-total">{{ $order->off }}</p>
                        </div>
                        <div class="col-xs-2">
                            <h5 class="invoice-title uppercase">
                                {{ __('order::dashboard.orders.show.order.total') }}</h5>
                            <p class="invoice-desc grand-total">{{ $order->total }}</p>
                        </div>
                        <div class="col-xs-2">
                            <h5 class="invoice-title uppercase">
                                {{ __('transaction::dashboard.orders.show.transaction.method') }}
                            </h5>
                            <p class="invoice-desc grand-total">
                                {{ ucfirst($order->transactions->method) }}
                            </p>
                        </div>
                        <div class="col-xs-3">
                            <h5 class="invoice-title uppercase">
                                {{ __('order::dashboard.orders.show.order.delivery_time') }}
                            </h5>
                            <p class="invoice-desc grand-total">
                                {{ $order->date }} / {{ $order->time }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if (!$loop->last)
                <hr style="border: 1px dashed black;">
            @endif
        @endforeach

    </div>

</body>

</html>
