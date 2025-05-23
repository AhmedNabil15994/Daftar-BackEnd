@extends('apps::frontend.layouts.app')
@section('title', __('order::frontend.orders.index.title'))
@section('content')
<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ __('order::frontend.orders.index.title') }}</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="account-setting">
        <div class="row">
            @if (session('status'))
            <div class="alert alert-{{session('alert')}}" role="alert">
                <center>
                    {{ session('status') }}
                </center>
            </div>
            @endif
            <div class="col-md-3">
                <div class="content-sidebar user_side">
                    <div class="panel-group" id="accordionNo">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapseCategory" class="collapseWill">
                                        <span> <i class="fa fa-caret-right"></i></span>
                                        {{ __('order::frontend.orders.index.title') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseCategory" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <ul class="categories-content">
                                        <li class="has-child">
                                            <a href="{{ url(route('frontend.profile.index')) }}">
                                                <i class="ti-user"></i>
                                                {{ __('user::frontend.profile.index.update') }}
                                            </a>
                                        </li>
                                        <li class="has-child active">
                                            <a href="#.">
                                                <i class="ti-shopping-cart"></i>
                                                {{ __('user::frontend.profile.index.orders') }}
                                            </a>
                                        </li>
                                        <li class="has-child">
                                            <a href="{{ url(route('frontend.profile.address.index')) }}">
                                                <i class="ti-user"></i>
                                                {{ __('user::frontend.profile.index.addresses') }}
                                            </a>
                                        </li>
                                        <li class="has-child">
                                            <a href="{{ url(route('frontend.favorites.index')) }}">
                                                <i class="ti-user"></i>
                                                {{ __('user::frontend.profile.index.favorites') }}
                                            </a>
                                        </li>
                                        <li class="has-child">
                                            <a onclick="event.preventDefault();document.getElementById('logout').submit();" href="#.">
                                                <i class="ti-key"></i>
                                                {{ __('user::frontend.profile.index.logout') }}
                                            </a>
                                            <form id="logout" action="{{ route('frontend.logout') }}" method="POST">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="equal-container list-favs">
                    @foreach ($orders as $order)
                    <div class="product-item style-2 favorite-item">
                        <div class="product-inner">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>#{{ $order->id }}</h4>
                                </div>
                                <div class="col-md-8">
                                    <div class="product-innfo">
                                        <ul>
                                            <li><b>{{ date('d-m-Y' , strtotime($order->created_at)) }}</li>
                                            <li><b>{{ $order->total }} KWD</li>
                                        </ul>
                                        <span class="alert-{{ $order->orderStatus->color_label}}">
                                            {{ $order->orderStatus->translate(locale())->title }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="inner favorite-item-opt">
                                        <a href="{{ url(route('frontend.orders.invoice',$order->id)) }}" class="btn btn-checkout">
                                            <i class="fa fa-eye"></i>
                                            {{ __('order::frontend.orders.index.btn.details') }}
                                        </a>
                                    </div>
                                    <div class="inner favorite-item-opt">
                                        <a href="{{ url(route('frontend.orders.reorder',$order['id'])) }}" class="btn btn-danger">
                                            {{ __('order::frontend.orders.invoice.btn.reorder') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop
