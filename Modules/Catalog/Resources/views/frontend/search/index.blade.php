@extends('apps::frontend.layouts.app')
@section('title', __('catalog::frontend.search.index.title') )
@section('content')


    <div class="banner-home library-head-banner page-head">
        <div class="container">
            <div class="library-header ">
                <h1>{{ __('catalog::frontend.search.index.title') }}</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="library-search">
            <div class="subscribe-form">
                <form method="get" action="{{ url(route('frontend.search.index')) }}">
                    <input type="text" class="form-control" name="search"
                           placeholder="{{__('apps::frontend.home.search_holder')}}">
                    <button type="submit" class="btn">{{__('apps::frontend.home.search_btn')}}</button>
                </form>
            </div>
        </div>

        <div class="inner-page row libraries-list">

            <div class="col-md-12">
                <div class="toolbar-products">
                    <div class="toolbar-option toolbar-option-top">
                        <div class="row">
                            <div class="col-md-6 col-xs-6">
                                <div class="toolbar-per">
                                    <span>{{__('catalog::frontend.search.index.title') }} : {{ $request['search'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                @forelse ($vendorsWithProducts as $vendor)
                    <div class="block-recomment">
                        {{--<div class="title-top">
                            <h3 class="title-block">
                                <a href="{{ url(route('frontend.vendors.index',$vendor->translate(locale())->slug)) }}">
                                    <span>{{ $vendor->translate(locale())->title }}</span>
                                </a>
                            </h3>
                        </div>--}}
                        <div class="library-products">
                            <div class="row">
                                @foreach ($vendor->products as $product)
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                        <div class="product-item fixed_heigth_product_item">
                                            <div class="product-inner">
                                                <div class="product-thumb">
                                                    @if (!is_null($product['newArrival']))
                                                        <span class="badge-item">
                                            {{ __('vendor::frontend.vendors.new_product') }}
                                          </span>
                                                    @endif
                                                    <a href="{{ url(route('frontend.products.index',[
                                          $vendor->translate(locale())->slug,
                                          $product->translate(locale())->slug
                                          ])) }}">
                                                        <img src="{{url($product->image)}}"
                                                             alt="{{$product->translate(locale())->title}}">
                                                    </a>
                                                </div>
                                                <div class="product-innfo">
                                                    <div class="product-name">
                                                        <a href="{{ url(route('frontend.products.index',[
                                              $vendor->translate(locale())->slug,
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
                                                                            <button
                                                                                class="btn main-btn-nobg add_to_cart"
                                                                                type="submit">
                                                                                <i class="fa fa-refresh hidden-desk"></i>
                                                                                <span class="hidden-xs">
                                                                <i class="fa fa-refresh"></i>
                                                            </span>
                                                                            </button>
                                                                        @else
                                                                            <button
                                                                                class="btn main-btn-nobg add_to_cart"
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
                                                                <div class="form-row form-row-wide">
                                                                    <a href="{{ url(route('frontend.products.index',[ $vendor->translate(locale())->slug, $product->translate(locale())->slug])) }}">
                                                                        <button class="btn main-btn-nobg btn-block"
                                                                                type="submit">
                                                                            {{ __('vendor::frontend.vendors.product_details') }}
                                                                        </button>
                                                                    </a>
                                                                </div>
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
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="empty-address">
                            <i class="ti-search"></i>
                            <h6>{{ __('catalog::frontend.search.index.empty') }}</h6>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@stop
