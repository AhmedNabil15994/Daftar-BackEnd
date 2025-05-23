@extends('apps::frontend.layouts.app')
@section('title', $product->translate(locale())->title )
@section('content')
@section('seo')
  @include('meta::manager', [
      'title'         => $product->translate(locale())->title,
      'keywords'      => $product->translate(locale())->seo_keywords,
      'description'   => $product->translate(locale())->seo_description,
      'image'         => url($product->image),
  ])
@append
<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ $product->translate(locale())->title }}</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="inner-page">

        @include('apps::frontend.layouts._alerts')

        <div class="product-details">
            <div class="row">
                <div class="col-md-5">
                    <div class="main-image sp-wrap image_v_active">
                          <a href="{{url($product->image)}}">
                              <img src="{{url($product->image)}}" class="img-responsive" alt="img" data-lightbox="roadtrip">
                          </a>

                          @foreach ($product->images as $key)
                          <a href="{{url($key->image)}}"><img src="{{url($key->image)}}" class="img-responsive" alt="img" data-lightbox="roadtrip"></a>
                          @endforeach
                    </div>
                    <div class="main-image sp-wrap image_v_inactive" style="display:none">
                          <a href="" class="image_v_url">
                              <img src="" class="img-responsive image_v" alt="img" data-lightbox="roadtrip" style="display:none">
                          </a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="entry-summary">
                        <div class="product-name">
                            <h2>{{ $product->translate(locale())->title }}</h2>
                            <h6>{{__('catalog::frontend.products.sku')}} :
                                <i class="sku_v">{{ $product->sku }}</i>
                            </h6>
                        </div>
                        <div class="product-info-main">
                            @if (app('favorite')->get($product->id))
                            <span class="favorite-item"><i class="fa fa-heart"></i></span>
                            @else
                            <a href="{{ url(route('frontend.favorites.add',$product->translate(locale())->slug)) }}" class="favorite">
                                <span class="favorite-item"><i class="ti-heart"></i></span>
                            </a>
                            @endif
                            <div class="product-summ-det">
                                <h5>{{__('catalog::frontend.products.description')}}</h5>
                                <p>{!! $product->translate(locale())->description !!}</p>
                            </div>

                            <div class="product-summ-det">
                                <h5>{{__('catalog::frontend.products.price')}}</h5>
                                <span class="price">
                                    @if (!is_null($product['offer']))
                                    <ins>{{ $product->offer->offer_price }} {{__('apps::frontend.general.kwd')}}</ins>
                                    <del>{{ $product->price }} {{__('apps::frontend.general.kwd')}}</del>
                                    @else
                                    <ins class="price_v">{{ $product->price }}</ins>
                                    <i>{{__('apps::frontend.general.kwd')}}</i>
                                    @endif
                                </span>
                            </div>
                            <form class="form" action="{{ url(route('frontend.shopping-cart.create-or-update',$product->translate(locale())->slug)) }}" method="POST">
                                @csrf
                                <div class="product-summ-det">
                                    <h5>{{__('catalog::frontend.products.add_notes')}}</h5>
                                    <textarea class="form-control" name="notes" placeholder="{{__('catalog::frontend.products.notes')}}" cols="30" rows="5"></textarea>
                                </div>

                                <input type="hidden" class="variant_id" name="variant_id" value="">
                                @if ($product->qty > 0)
                                <div class="product-des">
                                    <div class="quantity">
                                        <div class="buttons-added">
                                            <a href="#" class="sign plus">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                            <input type="text" value="{{ Cart::getContent()->get($product->id) ? Cart::getContent()->get($product->id)->quantity : "1"}}" name="qty" class="input-text qty text" size="1" min="1" max="{{ $product->qty }}">
                                            <a href="#" class="sign minus">
                                                <i class="fa fa-minus"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @if (Cart::getContent()->get($product->id))
                                    <button class="btn main-btn-nobg add_to_cart variant_btn" type="submit">
                                        <i class="fa fa-refresh hidden-desk"></i>
                                              <span class="hidden-xs">
                                                  <i class="fa fa-refresh"></i>
                                              </span>
                                    </button>
                                    @else
                                    <button class="btn main-btn-nobg add_to_cart variant_btn" type="submit">
                                        <i class="fa fa-shopping-cart"></i>
                                    </button>
                                    @endif
                                </div>
                                @else
                                    <p style="color: red;font-weight: bold;">
                                        {{ __('vendor::frontend.vendors.products.sold_out') }}
                                    </p>
                                @endif
                                @if (count($product->variants) > 0)
                                <div class="col-md-12">
                                    @foreach ($options as $option => $val)
                                    <p class="form-row">
                                        <label> {{ $val['option']->translate(locale())->title }}
                                            <span class="note-impor">*</span>
                                        </label>
                                        <select class="select-detail" name="option_value[{{ $val['option']->id }}]">
                                            <option value="">
                                                {{ __('catalog::frontend.products.form.option') }}
                                                {{ $val['option']->translate(locale())->title }}
                                            </option>
                                            @foreach ($val['values'] as $optionValue)
                                            <option value="{{$optionValue->optionValue->id}}">
                                                {{ $optionValue->optionValue->translate(locale())->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </p>
                                    @endforeach
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-recomment">
        <div class="title-top">
            <h3 class="title-block title-with-board">
                <span>{{__('catalog::frontend.products.related_products')}}</span>
            </h3>
        </div>
        <div class="owl-carousel equal-container library-products" id="library-products">
            @foreach ($related as $key)
            <div class="product-item">
                <div class="product-inner">
                    <div class="product-thumb">
                        @if (!is_null($key['newArrival']))
                        <span class="badge-item">
                            {{ __('vendor::frontend.vendors.new_product') }}
                        </span>
                        @endif
                        <a href="{{ url(route('frontend.products.index',[
                          $key->vendor->translate(locale())->slug,
                          $key->translate(locale())->slug
                          ])) }}">
                            <img src="{{url($key->image)}}" alt="{{ $key->translate(locale())->title }}">
                        </a>
                    </div>
                    <div class="product-innfo">
                        <div class="product-name">
                            <a href="{{ url(route('frontend.products.index',[
                            $key->vendor->translate(locale())->slug,
                            $key->translate(locale())->slug
                            ])) }}">
                                {{ $key->translate(locale())->title }}
                            </a>
                        </div>
                        <span class="price price-dark">
                            @if (!is_null($key['offer']))
                            <ins>{{ $key->offer->offer_price }} {{__('apps::frontend.general.kwd')}}</ins>
                            <del>{{ $key->price }} {{__('apps::frontend.general.kwd')}}</del>
                            @else
                            <ins>{{ $key->price }} {{__('apps::frontend.general.kwd')}}</ins>
                            @endif
                        </span>
                        @if (count($key->variants) <= 0) <form class="form" method="POST" action="{{ url(route('frontend.shopping-cart.create-or-update',$key->translate(locale())->slug)) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-xs-8">
                                    <class class="tb-qty" data-title="Quantity">
                                        <div class="quantity">
                                            <div class="buttons-added">
                                                <a href="#" class="sign plus">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <input type="text" value="{{ Cart::getContent()->get($key->id) ? Cart::getContent()->get($key->id)->quantity : "1"}}" name="qty" class="input-text qty text" size="1">
                                                <a href="#" class="sign minus">
                                                    <i class="fa fa-minus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </class>
                                </div>
                                <div class="col-md-6 col-xs-4">
                                    @if (Cart::getContent()->get($key->id))
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
                                      $key->vendor->translate(locale())->slug,
                                      $key->translate(locale())->slug
                                      ])) }}">
                                        <button class="btn main-btn-nobg btn-block" type="submit">
                                            {{ __('vendor::frontend.vendors.product_details') }}
                                        </button>
                                    </a>
                                </p>
                            </div>
                            @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop

@section('scripts')
<script>
    $(document).ready(function() {

        $('.select-detail').on('change', function(e) {

            var wineId = [];
            var pro_id = '{{$product['id']}}';

            $('.select-detail').each(function(index) {
                wineId.push($(this).val());
            });

            if (wineId.length == $('.select-detail').length) {

                $.ajax({
                    url: '{{url(route('frontend.products.variations'))}}',
                    type: 'GET',
                    data: {
                        values: wineId,
                        product_id: pro_id
                    },
                    beforeSend: function() {
                        $(".inner-page").addClass('disabled');
                        $('#loading').removeClass('hidden');
                    },
                    success: function(data) {

                        var imagePath = '{{ url("/", "path-image") }}';
                        imagePath = imagePath.replace('path-image', data['image']);

                        $('.image_v_active').remove();
                        $('.sku_v').html(data['sku']);
                        $('.variant_id').val(data['id']);
                        $('.price_v').html(data['price']);
                        $('.image_v').attr('src', imagePath);
                        $('.image_v_url').attr('href', imagePath);
                        $('.variant_btn').prop('disabled', false);
                        $('.image_v_inactive').css('display','block');
                        $('.image_v').css('display','block');
                    },
                    error: function(data) {
                        $('.variant_btn').prop('disabled', true);
                    },
                    complete: function(data) {
                        $(".inner-page").removeClass('disabled');
                        $('#loading').addClass('hidden');
                    },
                });
            }

        });

    });
</script>
@endsection
