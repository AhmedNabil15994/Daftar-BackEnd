<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 footer-logo-icon">
                <img src="{{ url(config('setting.logo')) }}" alt="logo" style="max-width:70%;">
            </div>

            <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 text-center">
                <div class="links">
                    <ul>
                        <li><a href="{{ url(route('frontend.home')) }}"> {{ __('apps::frontend.footer.home_page') }}</a>
                        </li>
                        @foreach ($pages->where('type', 0) as $page)
                            <li>
                                <a href="{{ url(route('frontend.pages.index', $page->translate(locale())->slug)) }}">
                                    {{ $page->translate(locale())->title }}
                                </a>
                            </li>
                        @endforeach
                        <li><a href="{{ url(route('frontend.contact-us')) }}">
                                {{ __('apps::frontend.footer.contact_us') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 text-center">
                <div class="links">
                    <ul>
                        @foreach ($pages->where('type', 1) as $footerPage)
                            <li>
                                <a
                                    href="{{ url(route('frontend.pages.index', $footerPage->translate(locale())->slug)) }}">
                                    {{ $footerPage->translate(locale())->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 footer-subscribe">

                <div class="pay-men text-center">
                    <a href="#"><img src="{{ url('uploads/payments.png') }}" alt="pay1"
                            style="max-width:50%"></a>
                </div>

                <div class="links social-media text-center">

                    @if (!is_null(config('setting.social.facebook')) || config('setting.social.facebook') != '#')
                        <a href="{{ config('setting.social')['facebook'] }}" target="_blank"><i
                                class="fa fa-facebook"></i></a>
                    @endif

                    @if (!is_null(config('setting.social.youtube')) || config('setting.social.youtube') != '#')
                        <a href="{{ config('setting.social')['youtube'] }}" target="_blank"><i
                                class="fa fa-youtube"></i></a>
                    @endif

                    @if (!is_null(config('setting.social.instagram')) || config('setting.social.instagram') != '#')
                        <a href="{{ config('setting.social')['instagram'] }}" target="_blank"><i
                                class="fa fa-instagram"></i></a>
                    @endif

                    @if (!is_null(config('setting.social.twitter')) || config('setting.social.twitter') != '#')
                        <a href="{{ config('setting.social')['twitter'] }}" target="_blank"><i
                                class="fa fa-twitter"></i></a>
                    @endif

                    @if (!is_null(config('setting.social.snapchat')) || config('setting.social.snapchat') != '#')
                        <a href="{{ config('setting.social')['snapchat'] }}" target="_blank"><i
                                class="fa fa-snapchat"></i></a>
                    @endif

                    @if (!is_null(config('setting.contact_us.whatsapp')) || config('setting.contact_us.whatsapp') != '#')
                        <a href="https://wa.me/{{ config('setting.contact_us.whatsapp') }}" target="_blank"><i
                                class="fa fa-whatsapp"></i></a>
                    @endif

                </div>

            </div>
        </div>
    </div>
</footer>


<div class="container" style="padding: 15px;">
    <div class="page-footer-inner" style="text-align: center;">
        {{ date('Y') }} - {{ __('apps::frontend.footer.developed_by') }} &copy;
        <a target="_blank" href="https://www.tocaan.com/" class="font-white">
            {{ __('apps::frontend.footer.tocaan') }}
        </a>
    </div>
</div>
