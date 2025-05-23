<?php

view()->composer(['area::dashboard.cities.*'], \Modules\Area\ViewComposers\Dashboard\CountryComposer::class);

view()->composer([
  'area::dashboard.states.*',
  'vendor::dashboard.delivery-charges.*'
],
\Modules\Area\ViewComposers\Dashboard\CityComposer::class);

view()->composer([
  'catalog::frontend.address.index',
  'user::frontend.profile.addresses.address'
],

\Modules\Area\ViewComposers\FrontEnd\CityComposer::class);
