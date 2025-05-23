@extends('apps::frontend.layouts.app')
@section('title', __('catalog::frontend.favorites.title') )
@section('content')

<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ __('catalog::frontend.favorites.title') }}</h1>
        </div>
    </div>
</div>


<div class="container">
    <div class="account-setting">

        <div class="row">

            @include('apps::frontend.layouts._alerts')

            @if (count(app('favorite')->getContent()) <= 0) <div class="col-md-12">
                <div class="title-top">
                    <h3 class="title-block title-with-board">
                        <span> {{ __('catalog::frontend.favorites.title') }} </span>
                    </h3>
                </div>
                <div class="empty-address">
                    <i class="ti-shopping-cart"></i>
                    <h6>{{ __('catalog::frontend.favorites.empty') }}</h6>
                </div>
        </div>
        @else

        <div class="col-md-12">
            <div class="title-top">
                <h3 class="title-block title-with-board">
                    <span>
                        {{ __('catalog::frontend.favorites.title') }}
                        <span class="cart-counter">({{ count(app('favorite')->getContent()) }})</span>
                    </span>
                </h3>
                <a href="{{ url(route('frontend.favorites.clear')) }}">
                    <div class="cart-del-items"><span><i class="fa fa-trash-o"></i> {{ __('catalog::frontend.favorites.clear') }} </span></div>
                </a>
            </div>

            <div class="equal-container list-favs">
                @foreach ($items as $item)
                <div class="product-item style-2 favorite-item">
                    <div class="product-inner">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-thumb">
                                    <div class="thumb-inner">
                                        <a href="{{ url(route('frontend.products.index',[
                                          $item->attributes->product->vendor->translate(locale())->slug,
                                          $item->attributes->product->translate(locale())->slug
                                          ])) }}">
                                            <img src="{{url($item->attributes->image)}}" alt="p8"></a>
                                    </div>

                                </div>
                                <div class="product-innfo">

                                    <div class="product-name">
                                        <a href="{{ url(route('frontend.products.index',[
                                          $item->attributes->product->vendor->translate(locale())->slug,
                                          $item->attributes->product->translate(locale())->slug
                                          ])) }}">
                                            {{ $item->attributes->product->translate(locale())->title }}
                                        </a>
                                    </div>

                                    <span class="price price-dark">
                                        <ins> {{ $item->price }} {{ __('apps::frontend.general.kwd') }}</ins>
                                    </span>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inner favorite-item-opt">
                                    <a href="{{ url(route('frontend.favorites.delete',$item->id)) }}" class="wishlist remove-wishlist" title="delete">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
</div>

@stop
