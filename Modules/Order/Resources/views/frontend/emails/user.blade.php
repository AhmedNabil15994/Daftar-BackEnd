@component('mail::message')

  <h2> <center> {{ __('order::frontend.orders.emails.users.header') }} </center> </h2>
  <h4> <center> # {{ $order['id'] }} </center> </h4>

  @component('mail::table')
      | {{ __('order::frontend.orders.invoice.product_title') }} | {{__('order::dashboard.orders.show.items.price')}}  | {{ __('order::frontend.orders.invoice.product_qty') }}  | {{ __('order::frontend.orders.invoice.product_total') }} |
      | :--:   |:----:| :----:| :---:  |
     @foreach ($order->orderProducts as $orderProduct)
        {{ $orderProduct->product->translate(locale())->title }} | {{ $orderProduct->sale_price }} KWD | {{ $orderProduct->qty }} | {{$orderProduct->total}} KWD
    @endforeach

  @endcomponent

  @component('mail::table')
      | {{ __('order::frontend.orders.invoice.total') }}       | {{ $order['total'] }} |
      | :--:                                                   |:----:                 |
      | {{ __('order::frontend.orders.invoice.subtotal') }}    | {{ $order['subtotal'] }} |
      | {{ __('order::frontend.orders.invoice.shipping') }}    | {{ $order['shipping'] }} |
      | {{ __('order::frontend.orders.invoice.method') }}      | {{ucfirst($order->transactions->method)}}|
  @endcomponent

@endcomponent
