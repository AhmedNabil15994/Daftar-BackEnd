@extends('apps::frontend.layouts.app')
@section('title', __('order::frontend.orders.invoice.btn.reorder'))
@section('content')


<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{__('order::frontend.orders.invoice.btn.reorder')}}</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="invoice-page" id="contentPrint">
        <h1 class="invoice-head">{{__('order::frontend.orders.invoice.btn.reorder')}}</h1>
        <div class="invoice-head-rec">
            <div class="row">
              <div class="col-md-12">
                  <div class="library-products">
                    @foreach ($order->orderProducts->chunk(4) as $chunk)
                      <div class="row">
                          @foreach ($chunk as $product)
                          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                              <div class="product-item">
                                  <div class="product-inner">
                                      <div class="product-thumb">
                                          @if (!is_null($product->product['newArrival']))
                                          <span class="badge-item">
                                              {{ __('vendor::frontend.vendors.new_product') }}
                                          </span>
                                          @endif
                                          <a href="#.">
                                              <img src="{{url($product->product->image)}}" alt="{{$product->product->translate(locale())->title}}" style="max-height:100%">
                                          </a>
                                      </div>
                                      <div class="product-innfo">
                                          <div class="product-name">
                                              <a href="#.">
                                                  {{$product->product->translate(locale())->title}}
                                              </a>
                                              @if (!is_null($product->orderVariant))
                                                @foreach ($product->orderVariant->orderVariantValues as $value)
                                                  <i>
                                                    {{ $value->variantValue->optionValue->option->translate(locale())->title }} :
                                                    {{ $value->variantValue->optionValue->translate(locale())->title }}
                                                  </i>
                                                  @if (!$loop->last)
                                                  <br>
                                                  @endif
                                                @endforeach
                                              @endif
                                          </div>
                                          <span class="price">
                                              @if (!is_null($product->product['offer']))
                                              <ins>
                                                  {{ $product->product->offer->offer_price }}
                                                  {{__('apps::frontend.general.kwd')}}
                                              </ins>
                                              <del>
                                                  {{ $product->product->price }} {{__('apps::frontend.general.kwd')}}
                                              </del>
                                              @else
                                              <ins>
                                                  {{ $product->product->price }} {{__('apps::frontend.general.kwd')}}
                                              </ins>
                                              @endif
                                          </span>
                                          @if ($product->product->qty > 0)
                                          @if (count($product->product->variants) <= 0) <form class="form" method="POST" action="{{ url(route('frontend.shopping-cart.create-or-update',$product->product->translate(locale())->slug)) }}">
                                              @csrf
                                              <div class="row">
                                                  <div class="col-md-6 col-xs-8">
                                                      <class class="tb-qty" data-title="Quantity">
                                                          <div class="quantity">
                                                              <div class="buttons-added">
                                                                  <a href="#" class="sign plus">
                                                                      <i class="fa fa-plus"></i>
                                                                  </a>
                                                                  <input type="text" value="{{ Cart::getContent()->get($product->product->id) ? Cart::getContent()->get($product->product->id)->quantity : $product->qty}}" name="qty" class="input-text qty text"
                                                                    size="1" min="1">
                                                                  <a href="#" class="sign minus">
                                                                      <i class="fa fa-minus"></i>
                                                                  </a>
                                                              </div>
                                                          </div>
                                                      </class>
                                                  </div>
                                                  <div class="col-md-6 col-xs-4">
                                                      @if (Cart::getContent()->get($product->product->id))
                                                      <button class="btn main-btn-nobg add_to_cart" type="submit">
                                                          <i class="fa fa-refresh hidden-desk"></i>
                                                          <span class="hidden-xs">
                                                              <i class="fa fa-refresh"></i>
                                                          </span>
                                                      </button>
                                                      @else
                                                      <button class="btn main-btn-nobg add_to_cart" type="submit">
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
                                                      $product->product->vendor->translate(locale())->slug,
                                                      $product->product->translate(locale())->slug
                                                      ])) }}">
                                                          <button class="btn main-btn-nobg btn-block" type="submit">
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
                    @endforeach
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>
@stop
