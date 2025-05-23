<!DOCTYPE html>
<html lang="{{ locale() }}" dir="{{ is_rtl() }}">
@yield('seo')
@if (is_rtl() == 'rtl')
  @include('apps::frontend.layouts._head_rtl')
@else
  @include('apps::frontend.layouts._head_ltr')
@endif

<!-- Loading -->
<div id="loading" class="text-center hidden">
  <img src='{{url('uploads/gif/loading.gif')}}' width="64" height="64" />
</div>

<style>
    /* Ajax Disable */
    .inner-page.disabled {
        pointer-events: none;
        opacity: 0.65;
    }
    #loading {
        position: fixed;
        top: calc(50% - 26px);
        left: calc(50% - 26px);
        z-index: 999;
        background: #fff;
    }
</style>

<body>

    <div class="wrapper">

        @include('apps::frontend.layouts._header')

        <div class="site-main">
          @yield('content')
        </div>

        @include('apps::frontend.layouts._footer')
{{--        <a href="https://wa.me/{{ config('setting.contact_us.whatsapp') }}" class="wahtsIcon">--}}
{{--            <i class="fa fa-whatsapp"></i> {{__('apps::frontend.footer.whatsapp')}}--}}
{{--        </a>--}}
    </div>

    <div id="scrollup"><i class="ti-angle-up"></i></div>

    @if (is_rtl() == 'rtl')
      @include('apps::frontend.layouts._jquery_rtl')
    @else
      @include('apps::frontend.layouts._jquery_ltr')
    @endif

    @include('apps::frontend.layouts._js')

</body>
</html>
