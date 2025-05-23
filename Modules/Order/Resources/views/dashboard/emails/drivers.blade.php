@component('mail::message')

  <h2> <center> {{ __('order::driver.orders.emails.driver.header') }} </center> </h2>

@component('mail::button', ['url' => url(route('driver.orders.show',$order['id'])) ])
{{ __('order::driver.orders.driver.emails.open_order') }}
@endcomponent


@endcomponent
