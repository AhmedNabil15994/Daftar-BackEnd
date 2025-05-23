@component('mail::message')

  <h2> <center> {{ __('authentication::api.celebrities.mail.header') }} </center> </h2>

  @component('mail::button', [
    'url' => url(route('dashboard.celebrities.edit',$celebrity['id']))
  ])

    {{ __('authentication::api.celebrities.mail.btn') }}

  @endcomponent

@endcomponent
