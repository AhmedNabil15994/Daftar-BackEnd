@extends('apps::frontend.layouts.app')
@section('title', $vendor->translate(locale())->title)
@section('content')
@section('seo')
    @include('meta::manager', [
        'title' => $vendor->translate(locale())->title,
        'keywords' => $vendor->translate(locale())->seo_keywords,
        'description' => $vendor->translate(locale())->seo_description,
        'image' => url($vendor->image),
    ])
@append

<div class="banner-home library-head-banner">
    <div class="container">
        <div class="library-header">
            <div class="row">
                <div class="col-xs-8">
                    <div class="row library-details">
                        <div class="col-md-3 col-xs-3">
                            <h3>{{ __('vendor::frontend.vendors.order_limit') }}</h3>
                            <div class="block-dec">
                                <p>{{ $vendor->order_limit }} {{ __('apps::frontend.general.kwd') }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-3">
                            <h3> {{ __('vendor::frontend.vendors.payments') }}</h3>
                            <div class="block-dec">
                                <div class="pay-men">
                                    @foreach ($vendor->payments as $payment)
                                        <a href="#"><img src="{{ url($payment->image) }}"
                                                alt="{{ $payment->code }}"></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">

    {{-- Categoris Banner --}}
    <div class="library-cat-block">
        <div class="owl-carousel library_categories">
            <div class="item">
                <a href="{{ url(route('frontend.vendors.index', $vendor->translate(locale())->slug)) }}">
                    <img src="{{ url('/frontend/en/images/categories/1.png') }}" alt="" />
                    <h3>{{ __('vendor::frontend.vendors.all_categories') }}</h3>
                </a>
            </div>
            @if (isset($categories))
                @foreach ($categories->mainCategoriesOfVendorProducts($vendor) as $category)
                    <div class="item">
                        <a
                            href="{{ url(
                                route('frontend.categories.index', [$vendor->translate(locale())->slug, $category->translate(locale())->slug]),
                            ) }}">
                            <img src="{{ url($category->image) }}" alt="" />
                            <h6>{{ $category->translate(locale())->title }}</h6>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- SEARCH BAR --}}
    <div class="library-search">
        <div class="subscribe-form">
            <form method="get" action="{{ url(route('frontend.search.index')) }}">
                <input type="text" class="form-control" name="search"
                    placeholder="{{ __('apps::frontend.home.search_btn') }}">
                <button type="submit" class="btn">{{ __('apps::frontend.home.search_btn') }}</button>
            </form>
        </div>
    </div>

    <div class="inner-page row">

        @include('apps::frontend.layouts._alerts')

        {{-- SIDEBAR FILTER --}}
        <div class="col-md-3">
            <div class="content-sidebar">
                <form action="{{ url(route('frontend.filters.index', $vendor->translate(locale())->slug)) }}"
                    method="get">
                    <h4 class="widget-title">{{ __('vendor::frontend.vendors.filters') }}</h4>
                    <div class="panel-group" id="accordionNo">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapseCategory" class="collapseWill">
                                        <span class="colles-block"></span>
                                        {{ __('vendor::frontend.vendors.filters_by_categories') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseCategory" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="smoothscroll maxheight300 color-filter">
                                        <div class="checkboxes one-in-row">

                                            @if (isset($categories))
                                                @foreach ($categories->mainCategoriesOfVendorProducts($vendor) as $categoryFilter)
                                                    <input id="check-{{ $categoryFilter->id }}" type="checkbox"
                                                        name="categories[]" value="{{ $categoryFilter->id }}">
                                                    <label for="check-{{ $categoryFilter->id }}">
                                                        {{ $categoryFilter->translate(locale())->title }}
                                                    </label>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (isset($brands))
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapseColor" class="collapseWill">
                                            <span class="colles-block"></span>
                                            {{ __('vendor::frontend.vendors.filters_by_brands') }}
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseColor" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="smoothscroll maxheight300 color-filter">
                                            <div class="checkboxes one-in-row">
                                                @foreach ($brands as $brand)
                                                    <input id="check-{{ $brand->id }}" type="checkbox"
                                                        name="brands[]" value="{{ $brand->id }}">
                                                    <label for="check-{{ $brand->id }}">
                                                        {{ $brand->translate(locale())->title }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (isset($products))
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="collapseWill" data-toggle="collapse" href="#collapsePrice">
                                            <span class="colles-block"></span>
                                            {{ __('vendor::frontend.vendors.filters_by_range_price') }}
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapsePrice" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="filter-price">
                                            <div class="filter-options-content">
                                                <div class="price_slider_wrapper">
                                                    <div data-label-reasult=""
                                                        data-min="{{ $products->rangePrice($vendor)['low'] }}"
                                                        data-max="{{ $products->rangePrice($vendor)['high'] }}"
                                                        data-unit="KWD " class="slider-range-price"
                                                        data-value-min="{{ $products->rangePrice($vendor)['low'] }}"
                                                        data-value-max="{{ $products->rangePrice($vendor)['high'] }}">
                                                    </div>
                                                    <div class="price_slider_amount">
                                                        <div style="" class="price_label">
                                                            <span class="from">
                                                                {{ $products->rangePrice($vendor)['low'] }}
                                                            </span>
                                                            -
                                                            <span class="to">
                                                                {{ $products->rangePrice($vendor)['high'] }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="low_price" name="low_price"
                                                        value="">
                                                    <input type="hidden" class="high_price" name="high_price"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <p class="form-row form-row-wide">
                                    <input type="submit" value="{{ __('vendor::frontend.vendors.btn.filter') }}"
                                        class="button-submit btn-block">
                                </p>
                            </div>
                        @endif

                    </div>
                </form>
            </div>
        </div>

        {{-- PRODUCTS LIST OF VENDOR --}}
        <div class="col-md-9">
            <div class="toolbar-products">
                <div class="toolbar-option toolbar-option-top">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <div class="toolbar-per">
                                <span>
                                    {{ $productsList->total() }}
                                    -
                                    {{ __('vendor::frontend.vendors.total_products') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="library-products">
                <div class="row">
                    @foreach ($productsList as $product)
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="product-item">
                                <div class="product-inner">
                                    <div class="product-thumb">
                                        @if (!is_null($product['newArrival']))
                                            <span class="badge-item">
                                                {{ __('vendor::frontend.vendors.new_product') }}
                                            </span>
                                        @endif
                                        <a
                                            href="{{ url(
                                                route('frontend.products.index', [$vendor->translate(locale())->slug, $product->translate(locale())->slug]),
                                            ) }}">
                                            <img src="{{ url($product->image) }}"
                                                alt="{{ $product->translate(locale())->title }}">
                                        </a>
                                    </div>
                                    <div class="product-innfo">
                                        <div class="product-name">
                                            <a
                                                href="{{ url(
                                                    route('frontend.products.index', [$vendor->translate(locale())->slug, $product->translate(locale())->slug]),
                                                ) }}">
                                                {{ $product->translate(locale())->title }}
                                            </a>
                                        </div>
                                        <span class="price">
                                            @if (!is_null($product['offer']))
                                                <ins>
                                                    {{ $product->offer->offer_price }}
                                                    {{ __('apps::frontend.general.kwd') }}
                                                </ins>
                                                <del>
                                                    {{ $product->price }} {{ __('apps::frontend.general.kwd') }}
                                                </del>
                                            @else
                                                <ins>
                                                    {{ $product->price }} {{ __('apps::frontend.general.kwd') }}
                                                </ins>
                                            @endif
                                        </span>
                                        @if ($product->qty > 0)
                                            @if (count($product->variants) <= 0)
                                                <form class="form" method="POST"
                                                    action="{{ url(route('frontend.shopping-cart.create-or-update', $product->translate(locale())->slug)) }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6 col-xs-8">
                                                            <class class="tb-qty" data-title="Quantity">
                                                                <div class="quantity">
                                                                    <div class="buttons-added">
                                                                        <a href="#" class="sign plus">
                                                                            <i class="fa fa-plus"></i>
                                                                        </a>
                                                                        <input type="text"
                                                                            value="{{ Cart::getContent()->get($product->id) ? Cart::getContent()->get($product->id)->quantity : '1' }}"
                                                                            name="qty" class="input-text qty text"
                                                                            size="1" min="1">
                                                                        <a href="#" class="sign minus">
                                                                            <i class="fa fa-minus"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </class>
                                                        </div>
                                                        <div class="col-md-6 col-xs-4">
                                                            @if (Cart::getContent()->get($product->id))
                                                                <button class="btn main-btn-nobg add_to_cart"
                                                                    type="submit">
                                                                    <i class="fa fa-refresh hidden-desk"></i>
                                                                    <span class="hidden-xs">
                                                                        <i class="fa fa-refresh"></i>
                                                                    </span>
                                                                </button>
                                                            @else
                                                                <button class="btn main-btn-nobg add_to_cart"
                                                                    type="submit">
                                                                    <i class="ti-shopping-cart hidden-desk"></i>
                                                                    <span class="hidden-xs">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </span>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            @else
                                                <div class="col-md-12">
                                                    <p class="form-row form-row-wide">
                                                        <a <a
                                                            href="{{ url(
                                                                route('frontend.products.index', [$vendor->translate(locale())->slug, $product->translate(locale())->slug]),
                                                            ) }}">
                                                            <button class="btn main-btn-nobg btn-block"
                                                                type="submit">
                                                                {{ __('vendor::frontend.vendors.product_details') }}
                                                            </button>
                                                        </a>
                                                    </p>
                                                </div>
                                            @endif
                                        @else
                                            <p style="color: red;font-weight: bold;">
                                                {{ __('vendor::frontend.vendors.products.sold_out') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{ $productsList->appends(Request::except('page'))->links() }}
        </div>
    </div>
</div>
@stop

@section('scripts')
<script>
    $(function() {

        var low = $('.slider-range-price').attr('data-value-min');
        var high = $('.slider-range-price').attr('data-value-max');

        $(".low_price").val(low);
        $(".high_price").val(high);

    });

    $('.slider-range-price').each(function() {
        var min = parseInt($(this).data('min'));
        var max = parseInt($(this).data('max'));
        var unit = $(this).data('unit');
        var value_min = parseInt($(this).data('value-min'));
        var value_max = parseInt($(this).data('value-max'));
        var label_reasult = $(this).data('label-reasult');
        var t = $(this);
        $(this).slider({
            range: true,
            min: min,
            max: max,
            values: [value_min, value_max],
            slide: function(event, ui) {
                var result = label_reasult + " <span>" + unit + ui.values[0] +
                    ' </span> - <span> ' + unit + ui.values[1] + '</span>';
                t.closest('.price_slider_wrapper').find('.price_slider_amount').html(result);
                $(".low_price").val(ui.values[0]);
                $(".high_price").val(ui.values[1]);
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        if ($(window).width() < 768) {
            $(".panel-collapse").removeClass("in");
        }
    });
</script>
@stop
