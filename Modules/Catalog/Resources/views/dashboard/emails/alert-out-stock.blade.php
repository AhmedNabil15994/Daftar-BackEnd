@component('mail::message')

@component('mail::table')

   | #             | Tile          |
   | ------------- |:-------------:|
   @foreach ($products as $product)
   | {{ $product->id }}     | {{$product->translate(locale())->title }}      |
  @endforeach

@endcomponent

@endcomponent
