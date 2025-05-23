@extends('apps::frontend.layouts.app')
@section('title', $category ? $category->translate(locale())->title : '' )
@section('content')

@section('seo')
    @include('meta::manager', [
        'title'         => $category ? $category->translate(locale())->title : '',
        'keywords'      => $category ? $category->translate(locale())->seo_keywords : '',
        'description'   => $category ? $category->translate(locale())->seo_description : '',
        'image'         => $category ? url($category->image) : '',
    ])
@append

<div class="banner-home library-head-banner">
    <div class="container">
        <div class="library-header">
            <div class="row">
                <div class="col-md-2 col-xs-4">
                    <div class="library-thumb" style="background: none;">
                        @if($category)
                            <img src="{{url($category->image)}}" class="img-responsive" alt=""/>
                        @endif
                    </div>
                </div>
                <div class="col-xs-8">
                    <div class="row">
                        <h1 style="margin-top: 34px;">
                            <a href="{{url(route('frontend.home'))}}" style="color:#337ab7">
                                <span>{{__('apps::frontend.nav.home_page')}}</span>
                            </a>
                            @if($category)
                                /
                                @foreach ($category->getParentsAttribute()->reverse() as $all)
                                    <a href="{{ url(route('frontend.categories.show',[
                                $all->translate(locale())->slug
                                ])) }}" style="color:#337ab7">
                                        <span>{{ $all->translate(locale())->title }}</span>
                                    </a>
                                    /
                                @endforeach
                                <span>{{ $category->translate(locale())->title }}</span>
                            @endif
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">

    {{-- Categoris Banner --}}
    @if ($category && count($category->children) > 0)
        <div class="library-cat-block">
            <div class="owl-carousel library_categories">
                @foreach ($category->children as $children)
                    <div class="item">
                        <a href="{{ url(route('frontend.categories.show',[
                $children->translate(locale())->slug
                ])) }}">
                            <img src="{{url($children->image)}}" alt=""/>
                            <h6>{{ $children->translate(locale())->title }}</h6>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="inner-page row">

        @include('apps::frontend.layouts._alerts')

        {{-- SIDEBAR FILTER --}}
        <div class="col-md-3">
            <div class="content-sidebar">
                <form
                    action="{{ url(route('frontend.categories.filters.show', $category ? $category->translate(locale())->slug : null)) }}"
                    method="get">
                    <h4 class="widget-title">{{ __('vendor::frontend.vendors.filters') }}</h4>
                    <div class="panel-group" id="accordionNo">
                        {{-- @if (count($category->children) > 0)
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

                                              @foreach ($category->children as $categoryFilter)
                                              <input id="check-{{$categoryFilter->id}}" type="checkbox" name="categories_filter[]" value="{{ $categoryFilter->id }}">
                                              <label for="check-{{$categoryFilter->id}}">
                                                  {{ $categoryFilter->translate(locale())->title }}
                                              </label>
                                              @endforeach

                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        @endif --}}
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
                                                <input id="check-{{$brand->id}}" type="checkbox" name="brands[]"
                                                       {{ request()->get('brands') && in_array($brand->id, request()->get('brands')) ? 'checked': '' }}
                                                       value="{{ $brand->id }}">
                                                <label for="check-{{$brand->id}}">
                                                    {{ $brand->translate(locale())->title }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                                <div data-label-reasult="" data-min="{{ $rangePrice['low'] }}"
                                                     data-max="{{ $rangePrice['high'] }}" data-unit="KWD "
                                                     class="slider-range-price"
                                                     data-value-min="{{ $rangePrice['low'] }}"
                                                     data-value-max="{{ $rangePrice['high'] }}">
                                                </div>
                                                <div class="price_slider_amount">
                                                    <div style="" class="price_label">
                                                        <span class="from">
                                                            {{ $rangePrice['low'] }}
                                                        </span>
                                                        -
                                                        <span class="to">
                                                            {{ $rangePrice['high'] }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <input type="hidden" class="low_price" name="low_price" value="">
                                                <input type="hidden" class="high_price" name="high_price" value="">
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

                    </div>
                </form>
            </div>
        </div>

        @if(count($productsList) > 0)
            {{-- PRODUCTS LIST OF VENDOR --}}
            <div class="col-md-9">
                <div class="library-products">
                    <div class="toolbar-products">
                        <div class="toolbar-option toolbar-option-top">
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="toolbar-sort">
                                        <span> {{ __('vendor::frontend.vendors.sorting') }} :  </span>
                                        <select class="sorter-options form-control" name="sorting">
                                            <option value="new_arrival"
                                                    @if (app('request')->input('sorting') == 'new_arrival' || app('request')->input('sorting') == '')
                                                    selected
                                                @endif>
                                                {{ __('vendor::frontend.vendors.new_arrival') }}
                                            </option>
                                            <option value="most_selling"
                                                    @if (app('request')->input('sorting') == 'most_selling')
                                                    selected
                                                @endif>
                                                {{ __('vendor::frontend.vendors.most_selling') }}
                                            </option>
                                            <option value="low_price"
                                                    @if (app('request')->input('sorting') == 'low_price')
                                                    selected
                                                @endif>
                                                {{ __('vendor::frontend.vendors.low_price') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row scroll-container">
                        @foreach ($productsList as $product)
                            <div class="scroll-item col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <div class="product-item fixed_heigth_product_item">
                                    <div class="product-inner">
                                        <div class="product-thumb">
                                            @if (!is_null($product['newArrival']))
                                                <span class="badge-item">
                                      {{ __('vendor::frontend.vendors.new_product') }}
                                    </span>
                                            @endif
                                            <a href="{{ url(route('frontend.products.index',[
                                      $product->vendor->translate(locale())->slug,
                                      $product->translate(locale())->slug
                                      ])) }}">
                                                <img src="{{url($product->image)}}"
                                                     alt="{{$product->translate(locale())->title}}">
                                            </a>
                                        </div>
                                        <div class="product-innfo">
                                            <div class="product-name">
                                                <a href="{{ url(route('frontend.products.index',[
                                          $product->vendor->translate(locale())->slug,
                                          $product->translate(locale())->slug
                                          ])) }}">
                                                    {{$product->translate(locale())->title}}
                                                </a>
                                            </div>
                                            <span class="price">
                                        @if (!is_null($product['offer']))
                                                    <ins>
                                            {{ $product->offer->offer_price }} {{__('apps::frontend.general.kwd')}}
                                        </ins>
                                                    <del>
                                            {{ $product->price }} {{__('apps::frontend.general.kwd')}}
                                        </del>
                                                @else
                                                    <ins>
                                            {{ $product->price }} {{__('apps::frontend.general.kwd')}}
                                        </ins>
                                                @endif
                                    </span>
                                            @if ($product->qty > 0)
                                                @if (count($product->variants) <= 0)
                                                    <form class="form" method="POST"
                                                          action="{{ url(route('frontend.shopping-cart.create-or-update',$product->translate(locale())->slug)) }}">
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
                                                                                   value="{{ Cart::getContent()->get($product->id) ? Cart::getContent()->get($product->id)->quantity : "1"}}"
                                                                                   name="qty"
                                                                                   class="input-text qty text"
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
                                                            <a href="{{ url(route('frontend.products.index',[
                                              $product->vendor->translate(locale())->slug,
                                              $product->translate(locale())->slug
                                              ])) }}">
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
                            <div class="col-md-6 col-xs-6">
                                <div class="toolbar-sort">
                                    <span> {{ __('vendor::frontend.vendors.sorting') }} :  </span>
                                    <select class="sorter-options form-control" name="sorting">
                                        <option value="new_arrival"
                                                @if (app('request')->input('sorting') == 'new_arrival' || app('request')->input('sorting') == '')
                                                selected
                                            @endif>
                                            {{ __('vendor::frontend.vendors.new_arrival') }}
                                        </option>
                                        <option value="most_selling"
                                                @if (app('request')->input('sorting') == 'most_selling')
                                                selected
                                            @endif>
                                            {{ __('vendor::frontend.vendors.most_selling') }}
                                        </option>
                                        <option value="low_price" @if (app('request')->input('sorting') == 'low_price')
                                        selected
                                            @endif>
                                            {{ __('vendor::frontend.vendors.low_price') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--{{ $productsList->appends(Request::except('page'))->links() }}--}}
            </div>
        @else
            <b>{{ __('vendor::frontend.vendors.products.not_found') }}</b>
        @endif

    </div>
</div>
@stop


@section('scripts')
    <script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>

    <script>
        $(function () {

            var low = $('.slider-range-price').attr('data-value-min');
            var high = $('.slider-range-price').attr('data-value-max');

            $(".low_price").val(low);
            $(".high_price").val(high);

        });

        $('.slider-range-price').each(function () {
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
                slide: function (event, ui) {
                    var result = label_reasult + " <span>" + unit + ui.values[0] + ' </span> - <span> ' + unit + ui.values[1] + '</span>';
                    t.closest('.price_slider_wrapper').find('.price_slider_amount').html(result);
                    $(".low_price").val(ui.values[0]);
                    $(".high_price").val(ui.values[1]);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            if ($(window).width() < 768) {
                $(".panel-collapse").removeClass("in");
            }
        });
    </script>

    <script>

        $(document).on('change', '.sorter-options', function (e) {

            var filterValue = ($(this).val());

            $(".inner-page").addClass('disabled');
            $('#loading').removeClass('hidden');

            var url = window.location.href;

            if (url.indexOf("&sorting") > -1) {

                url = url.substring(0, url.indexOf('&sorting'));

            }

            if (url.indexOf("?") > -1) {

                window.location.replace(url + '&sorting=' + filterValue);

            } else {

                window.location.replace(url + '?sorting=' + filterValue);

            }

        });

    </script>

    <script>
        var elem = document.querySelector('.scroll-container');
        var infScroll = new InfiniteScroll(elem, {
            path: function () {
                var pageNumber = this.pageIndex + 1;
                var urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('page') === true) {
                    urlParams.delete('page');
                }
                var params = urlParams.toString() !== '' ? '&' + urlParams.toString() : '';
                return '?page=' + pageNumber + params;
            },
            append: '.scroll-item'
        });
        infScroll.pageIndex = {{ request('page', 1) }}
    </script>
@stop
