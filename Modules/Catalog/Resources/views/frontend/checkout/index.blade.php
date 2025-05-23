@extends('apps::frontend.layouts.app')
@section('title', __('catalog::frontend.checkout.index.title'))
@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')

    <div class="banner-home library-head-banner page-head">
        <div class="container">
            <div class="library-header ">
                <h1>{{ __('catalog::frontend.checkout.index.title') }}</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="account-setting">
            <div class="row">
                @include('apps::frontend.layouts._alerts')
                <div class="col-md-12">
                    <div class="title-top">
                        <h3 class="title-block title-with-board">
                            <span>{{ __('catalog::frontend.checkout.index.title') }} </span>
                        </h3>
                    </div>
                    <div class="equal-container list-favs">
                        @foreach (Cart::getContent() as $item)
                            <div class="product-item style-2 favorite-item">
                                <div class="product-inner">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="product-thumb">
                                                <div class="thumb-inner">
                                                    <a href="#"><img src="{{ url($item->attributes->image) }}"
                                                            alt="p8"></a>
                                                </div>
                                            </div>
                                            <div class="product-innfo">
                                                <div class="product-name">
                                                    <a
                                                        href="#">{{ $item->attributes->product->translate(locale())->title }}</a>
                                                </div>
                                                <span class="price price-dark">
                                                    @if ($item->getPriceSumWithConditions() != $item->getPriceSum())
                                                        <del>{{ $item->price }}
                                                            {{ __('apps::frontend.general.kwd') }}</del>
                                                        /
                                                        <ins>
                                                            {{ $item->getPriceWithConditions() }}
                                                            {{ __('apps::frontend.general.kwd') }}
                                                        </ins>
                                                        <br>
                                                        <ins>
                                                            {{ $item->getPriceWithConditions() }} *
                                                            {{ $item->quantity }} =
                                                            {{ $item->getPriceSumWithConditions() }}
                                                            {{ __('apps::frontend.general.kwd') }}
                                                        </ins>
                                                    @else
                                                        <ins>
                                                            {{ $item->price }} * {{ $item->quantity }} =
                                                            {{ $item->getPriceSum() }}
                                                            {{ __('apps::frontend.general.kwd') }}
                                                        </ins>
                                                    @endif
                                                </span>
                                                <span class="notes price-dark">
                                                      {{__('catalog::frontend.products.notes')}}:  {{$item->attributes->notes}}
                                                </span>
                                                @if ($item->attributes->type == 'variants')
                                                    <div class="product-name">
                                                        @foreach ($item->attributes->variant->productValues as $key2 => $value2)
                                                            <i>
                                                                {{ $value2->optionValue->option->translate(locale())->title }}
                                                                :
                                                                <b>{{ $value2->optionValue->translate(locale())->title }}</b>
                                                            </i>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ url(route('frontend.shopping-cart.delete', $item->id)) }}"
                                                class="wishlist remove-wishlist" title="delete">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            @if (!Cart::getCondition('coupon_discount') && !Cart::getCondition('coupon_percentage_discount'))
                                <div class="library-search" style="width:100%;">
                                    <div class="subscribe-form">
                                        <form method="post" action="{{ url(route('frontend.check_coupon')) }}">
                                            @csrf
                                            <input type="text" class="form-control" name="code"
                                                placeholder="{{ __('coupon::frontend.coupons.enter') }}">
                                            <button type="submit" class="btn"><i class="fa fa-paper-plane"
                                                    style="color:white"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="conti-shoping-op">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <p>
                                <span class="left">{{ __('catalog::frontend.checkout.subtotal') }}</span>
                                <span class="right">{{ Cart::getSubTotal() }}
                                    {{ __('apps::frontend.general.kwd') }}</span>
                            </p>
                            <p>
                                <span class="left">
                                    {{ __('catalog::frontend.checkout.shipping') }}
                                    {{ isset($address->state) ? '(' . $address->state->translate(locale())->title . ')' : '' }}
                                </span>
                                <span class="right">
                                    {{ Cart::getCondition('delivery_fees')->getValue() }}
                                    {{ __('apps::frontend.general.kwd') }}
                                </span>
                            </p>
                            @if (Cart::getCondition('coupon_discount'))
                                <p>
                                    <span class="left">{{ __('catalog::frontend.checkout.coupon_discount') }} (
                                        {{ Cart::getCondition('coupon_discount')->getAttributes()['coupon']['code'] }}
                                        )</span>
                                    <span class="right"> {{ Cart::getCondition('coupon_discount')->getValue() }}
                                        {{ __('apps::frontend.general.kwd') }}</span>
                                </p>
                            @endif
                            @if (Cart::getCondition('coupon_percentage_discount'))
                                <p>
                                    <span class="left">
                                        {{ __('catalog::frontend.checkout.coupon_discount') }}
                                        (
                                        {{ Cart::getCondition('coupon_percentage_discount')->getAttributes()['coupon']['code'] }}
                                        )
                                    </span>
                                    <span class="right">
                                        {{ Cart::getCondition('coupon_percentage_discount')->getValue() }} %</span>
                                </p>
                            @endif
                            <p>
                                <span class="left">{{ __('catalog::frontend.checkout.total') }}</span>
                                <span class="right">{{ Cart::getTotal() }}
                                    {{ __('apps::frontend.general.kwd') }}</span>
                            </p>
                        </div>
                    </div>

                    <form action="{{ url(route('frontend.orders.create_order')) }}" method="post">
                        @csrf

                        <div class="row">

                            <div class="col-md-6">
                                <p class="form-row">
                                    <label>
                                        {{ __('catalog::frontend.checkout.form.date') }}
                                        <span class="note-impor">*</span>
                                    </label>
                                    <input type="text" name="date" readonly value="{{ $calendarDay ?? date('Y-m-d') }}"
                                        class="select-detail" id="selectShippingDay" min="{{ date('Y-m-d') }}">
                                </p>
                            </div>

                            <div class="times">
                                <div class="col-md-6">
                                    <p class="form-row">
                                        <label>
                                            {{ __('catalog::frontend.checkout.form.time') }}
                                            <span class="note-impor">*</span>
                                        </label>

                                        <select class="select-detail" name="time">
                                            <option value="">{{ __('catalog::frontend.checkout.form.time') }}</option>
                                            @foreach ($times as $time)
                                                <option value="{{ $time['time_from'] . ' - ' . $time['time_to'] }}"
                                                    {{ !is_null(old('time')) ? (old('time') == $time['time_from'] . ' - ' . $time['time_to'] ? 'selected' : '') : (strtotime($selectedTime) == strtotime($time['time_to']) ? 'selected' : '') }}>
                                                    {{ __('catalog::frontend.checkout.form.time_from') . ' ' . $time['time_from'] . ' ' . __('catalog::frontend.checkout.form.time_to') . ' ' . $time['time_to'] }}
                                                </option>
                                            @endforeach
                                        </select>

                                        {{-- <select class="select-detail" name="time">
                                            <option value="">{{ __('catalog::frontend.checkout.form.time') }}</option>
                                            @foreach ($times as $time)
                                                <option
                                                    value="{{ $time->id }}" {{ !is_null(old('time')) ? (old('time') == $time->id ? 'selected' : '') : (strtotime($selectedTime) == strtotime($time->to) ? 'selected' : '') }}>
                                                    {{ date('H:i' , strtotime($time->from)) }}
                                                    - {{ date('H:i' , strtotime($time->to)) }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                    </p>
                                </div>
                            </div>

                        </div>

                        <div class="title-top">
                            <h3 class="title-block title-with-board">
                                <span> {{ __('catalog::frontend.checkout.address.title') }} </span>
                            </h3>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="address-item">
                                        @if (isset($address->state))
                                            <div class="row address-option-row">
                                                <div class="col-md-8 color-brown">
                                                    {{ __('catalog::frontend.address.list.state') }} :
                                                    {{ $address->state->translate(locale())->title }}
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row address-option-row">
                                            <div class="col-md-8">
                                                {{ __('catalog::frontend.address.list.street') }} :
                                                {{ $address['street'] }}
                                            </div>
                                        </div>
                                        <div class="row address-option-row">
                                            <div class="col-md-8">
                                                {{ __('catalog::frontend.address.list.block') }} :
                                                {{ $address['block'] }}
                                            </div>
                                        </div>
                                        <div class="row address-option-row">
                                            <div class="col-md-8">
                                                {{ __('catalog::frontend.address.form.building') }} :
                                                {{ $address['building'] }}
                                            </div>
                                        </div>
                                        <div class="row address-option-row">
                                            <div class="col-md-8">
                                                {{ __('catalog::frontend.address.list.mobile') }} :
                                                {{ $address['mobile'] }}
                                            </div>
                                        </div>
                                        <div class="row address-option-row">
                                            <div class="col-md-8">
                                                {{ __('catalog::frontend.address.list.address_details') }} :
                                                {{ $address['address'] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- <div class="title-top">
                          <b>
                            <i class="fa fa-truck"></i>
                            {{ __('catalog::frontend.checkout.delivery_message') }}
                          </b>
                        </div> --}}

                        <div class="title-top">
                            <h3 class="title-block title-with-board">
                                <span>{{ __('catalog::frontend.checkout.index.payments') }} </span>
                            </h3>
                        </div>

                        <div class="payment-info">
                            <div class="form-row">
                                <label>
                                    {{ __('catalog::frontend.checkout.index.payments') }}
                                    <span class="note-impor">*</span>
                                </label>

                                <div class="checkboxes radios">
                                    <input id="check-knet" type="radio" name="payment" value="knet" checked>
                                    <label
                                        for="check-knet">{{ __('transaction::frontend.transactions.payments.knet') }}</label>
                                </div>

                                {{-- <div class="checkboxes radios">
                                    <input id="check-cash" type="radio" name="payment" value="cash">
                                    <label
                                        for="check-cash">{{ __('transaction::frontend.transactions.payments.cash') }}</label>
                                </div> --}}

                            </div>

                        </div>
                        <button type="submit" class="proc-ch-out">
                            {{ __('catalog::frontend.checkout.index.go_to_payment') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script>
        var allDays = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        var offDays = @json($activeCustomTimeDays); // example: ['mon', 'tue', 'wed', 'thu']

        function disableDates(date) {
            var string = $.datepicker.formatDate('yy-mm-dd', date);
            var filterDate = new Date(string);
            var day = filterDate.getDay();
            return [offDays.includes(allDays[day])];
        }

        $(document).ready(function() {

            $("#selectShippingDay").datepicker({
                minDate: 0,
                dateFormat: "yy-mm-dd",
                beforeShowDay: disableDates,
                //firstDay: 0, // 1 being Monday, 0 being Sunday, 6 being Friday
            });

            $('#selectShippingDay').on('change', function(e) {

                var selected_date = $(this).val();

                $.ajax({
                    url: '{{ url(route('frontend.checkout.custom_delivery_times')) }}',
                    type: 'GET',
                    data: {
                        selected_date: selected_date,
                    },
                    beforeSend: function() {
                        $(".inner-page").addClass('disabled');
                        $('#loading').removeClass('hidden');
                    },
                    success: function(data) {
                        // console.log(data);
                        $('.times').html(data);
                    },
                    error: function(data) {
                        // $('.variant_btn').prop('disabled', true);
                    },
                    complete: function(data) {
                        $(".inner-page").removeClass('disabled');
                        $('#loading').addClass('hidden');
                    },
                });

            });

        });
    </script>
@endsection
