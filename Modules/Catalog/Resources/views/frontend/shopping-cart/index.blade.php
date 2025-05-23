@extends('apps::frontend.layouts.app')
@section('title', __('catalog::frontend.cart.title') )
@section('content')

<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header">
            <h1>{{ __('catalog::frontend.cart.title') }}</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="account-setting">
        <div class="row">
            @include('apps::frontend.layouts._alerts')
            @if (count(Cart::getContent()) <= 0)
              <div class="col-md-12">
                <div class="title-top">
                    <h3 class="title-block title-with-board">
                        <span> {{ __('catalog::frontend.cart.title') }} </span>
                    </h3>
                </div>
                <div class="empty-address">
                    <i class="ti-shopping-cart"></i>
                    <h6>{{ __('catalog::frontend.cart.empty') }}</h6>
                </div>
              </div>
            @else
              <div class="col-md-12">
                  <div class="title-top">
                      <h3 class="title-block title-with-board">
                          <span>
                              {{ __('catalog::frontend.cart.title') }}
                              <span class="cart-counter">({{ count(Cart::getContent()) }})</span>
                          </span>
                      </h3>
                      <a href="{{ url(route('frontend.shopping-cart.clear')) }}">
                          <div class="cart-del-items"><span><i class="fa fa-trash-o"></i>
                            {{ __('catalog::frontend.cart.clear') }} </span></div>
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
                                              <a href="#"><img src="{{url($item->attributes->image)}}" alt="p8"></a>
                                          </div>

                                      </div>
                                      <div class="product-innfo">
                                          <div class="product-name">
                                              <a href="#">{{ $item->attributes->product->translate(locale())->title }}</a>
                                          </div>
                                          <span class="price price-dark">
                                              <ins> {{ $item->price }} {{ __('apps::frontend.general.kwd') }}</ins>
                                          </span>
                                          <span class="notes price-dark">
                                              {{__('catalog::frontend.products.notes')}}:  {{$item->attributes->notes}}
                                          </span>
                                          @if ($item->attributes->type == 'variants')
                                            <div class="product-name">
                                              @foreach ($item->attributes->variant->productValues as $key2 => $value2)
                                                <i>
                                                  {{ $value2->optionValue->option->translate(locale())->title }} :
                                                  <b>{{ $value2->optionValue->translate(locale())->title }}</b>
                                                </i>
                                              @endforeach
                                            </div>
                                          @endif
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class=>
                                          <form class="form" action="{{ url(route('frontend.shopping-cart.create-or-update',$item->attributes->product->translate(locale())->slug)) }}" method="POST">
                                              @csrf
                                              <div class="input-group" style="display: block;">
                                                <div class="quantity">
                                                    <div class="buttons-added">
                                                        <a href="#" class="update-qty sign plus"><i class="fa fa-plus"></i></a>
                                                        <input type="text" value="{{ $item->quantity }}" name="qty" class="input-text qty text fffff" size="1" min="1">
                                                        <a href="#" class=" update-qty sign minus"><i class="fa fa-minus"></i></a>
                                                    </div>
                                                </div>
                                                <a href="{{ url(route('frontend.shopping-cart.delete',$item->id)) }}" class="wishlist remove-wishlist" title="delete">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      @endforeach
                  </div>
                  <div class="conti-shoping-op">
                      <div class="col-md-7"></div>
                      <div class="col-md-5">
                          <p>
                              <span class="left">{{ __('catalog::frontend.cart.subtotal') }}</span>
                              <span class="right total-cart">{{ Cart::getSubTotal() }}</span> {{ __('apps::frontend.general.kwd') }}
                          </p>
                          <a href="{{ url(route('frontend.order.address.index')) }}" class="proc-ch-out">
                              {{ __('catalog::frontend.cart.go_to_checkout') }}
                          </a>
                      </div>
                  </div>
              </div>
            @endif
       </div>
   </div>
</div>

@stop


@section('scripts')
  <script>
      $(document).on('click', '.quantity .plus, .quantity .minus', function (e) {

            var token = $(this).closest('.form').find('input[name="_token"]').val();
            var action = $(this).closest('.form').attr('action');
            var qty    = $(this).closest('.quantity').find('.qty').val();

            e.preventDefault();

            $.ajax({
                method  : "POST",
                url     : action,
                data: {
                  "qty"    : qty,
                  "_token": token,
                },
                beforeSend : function(){
                  $(".inner-page").addClass('disabled');
                  $('#loading').removeClass('hidden');
                },
                success:function(data){
                  updateTotalCart();
                  shoppingCart();
                  $('.add_to_cart').prop('disabled',false);
                },
                error: function(data){
                  displayErrorsUpdateQty(data);
                  $('.add_to_cart').prop('disabled',false);
                },
                complete:function(data){
                  $(".inner-page").removeClass('disabled');
                  $('#loading').addClass('hidden');
                },
            });

      });

      function displayErrorsUpdateQty(data)
      {
          console.log($.parseJSON(data.responseText));

          var getJSON = $.parseJSON(data.responseText);

          var output = '<ul>';

          for (var error in getJSON.errors){
              output += "<li>" + getJSON.errors[error] + "</li>";
          }

          output += '</ul>';

          var wrapper = document.createElement('div');
          wrapper.innerHTML = output;

          swal({
            content: wrapper,
            icon: "error",
            dangerMode: true,
          })
      }

    	function updateTotalCart()
    	{
    		$.ajax({
    	        url: '{{ url(route('frontend.shopping-cart.total')) }}',
    	        type: "GET",
    	        success:function(res){
                $('.total-cart').html(res);
    	        },
    	        error:function(res){
    	        }
    	    });
    	}

  </script>
@stop
