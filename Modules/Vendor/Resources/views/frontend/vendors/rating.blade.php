@extends('apps::frontend.layouts.app')
@section('title', __('vendor::frontend.vendors.rating'))
@section('content')

<div class="banner-home library-head-banner">
    <div class="container">
        <div class="library-header">
            <div class="row">
                <div class="col-md-2 col-xs-4">
                    <div class="library-thumb" style="background: none;">
                        <img src="{{url($vendor->image)}}" class="img-responsive" alt="" />
                    </div>
                </div>
                <div class="col-xs-8">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <h1>{{ $vendor->translate(locale())->title }}</h1>
                        </div>
                    </div>
                    <div class="row library-details">
                        <div class="col-md-3 col-xs-3">
                            <h3>{{ __('vendor::frontend.vendors.order_limit') }}</h3>
                            <div class="block-dec">
                                <p>{{ $vendor->order_limit }} {{__('apps::frontend.general.kwd')}}</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-3">
                            <h3> {{ __('vendor::frontend.vendors.payments') }}</h3>
                            <div class="block-dec">
                                <div class="pay-men">
                                    @foreach ($vendor->payments as $payment)
                                    <a href="#"><img src="{{url($payment->image)}}" alt="{{$payment->code}}"></a>
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

    <div class="row">
        <div class="innerPage contact">
            <div class="col-md-12">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    <center>
                        {{ session('status') }}
                    </center>
                </div>
                @endif
                @if (is_null($order->rating) || is_null($vendor->rating))
                  <div class="title-top">
                      <h3 class="title-block title-with-board">
                          <span>{{ __('vendor::frontend.vendors.rating')}}</span>
                      </h3>
                  </div>
                  <form class="form-contact" action="{{ url(route('frontend.vendors.store.rating',$order['id'])) }}" method="post">
                      @csrf

                      <div class="col-md-6 col-md-offset-3">
                          <div class="login-form">
                              @csrf
                              <p class="form-row form-row-wide">
                                  <div class="rate">
                                      <input type="radio" id="star5" name="rate" value="5" />
                                      <label for="star5" title="text">5</label>
                                      <input type="radio" id="star4" name="rate" value="4" />
                                      <label for="star4" title="text">4</label>
                                      <input type="radio" id="star3" name="rate" value="3" />
                                      <label for="star3" title="text">3</label>
                                      <input type="radio" id="star2" name="rate" value="2" />
                                      <label for="star2" title="text">2</label>
                                      <input type="radio" id="star1" name="rate" value="1" />
                                      <label for="star1" title="text">1</label>
                                  </div>
                              </p>
                              <p class="form-row">
                                  <input type="submit" value="{{  __('vendor::frontend.vendors.rating_btn') }}" class="button-submit btn-block">
                              </p>
                          </div>
                      </div>
                  </form>
                @else
                  <div class="title-top">
                      <h3 class="title-block title-with-board">
                          <span>{{ __('vendor::frontend.vendors.rated')}}</span>
                      </h3>
                  </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop

<style>
    * {
        margin: 0;
        padding: 0;
    }

    .rate {
        line-height: 35px;
        float: left;
        height: 46px;
        padding: 8px 10px;
    }

    .rate:not(:checked)>input {
        position: absolute;
        top: -9999px;
    }

    .rate:not(:checked)>label {
        float: right;
        width: 1em;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        font-size: 30px;
        color: #ccc;
    }

    .rate:not(:checked)>label:before {
        content: '★ ';
    }

    .rate>input:checked~label {
        color: #ffc700;
    }

    .rate:not(:checked)>label:hover,
    .rate:not(:checked)>label:hover~label {
        color: #deb217;
    }

    .rate>input:checked+label:hover,
    .rate>input:checked+label:hover~label,
    .rate>input:checked~label:hover,
    .rate>input:checked~label:hover~label,
    .rate>label:hover~input:checked~label {
        color: #c59b08;
    }
</style>
