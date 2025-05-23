<header class="site-header header-option">
    <div class="header-top">
        <div class="container">
            <div class="topp">
                <ul class="header-top-left">
                    <li class="menu-item-has-children arrow">
                        <a href="#">
                            {{ LaravelLocalization::getCurrentLocaleNative() }}
                        </a>
                        <ul class="submenu dropdown-menu">
                            @foreach (config('laravellocalization.supportedLocales') as $localeCode => $properties)
                            @if ($localeCode != locale())
                            <li>
                                <a hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </li>
                    @auth
                    @else
                    <li>
                        <a href="{{ url(route('frontend.register')) }}">
                            {{__('apps::frontend.nav.register')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{ url(route('frontend.login')) }}">
                            {{__('apps::frontend.nav.login')}}
                        </a>
                    </li>
                    @endauth
                </ul>
                <ul class="header-top-right">
                    <li>
                        <a href="#">
                            <i class="ti-mobile"></i> {{config('setting.contact_us.whatsapp')}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- DESKTOP MENU --}}
    <div class="header-content desktop-search">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-3">
                    <div class="logo-header">
                        <a href="{{url(route('frontend.home'))}}">
                            <img src="{{url(config('setting.logo'))}}" alt="logo">
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="library-search desktop-search" style="width:100%;">
                        <div class="subscribe-form">
                            <form method="get" action="{{ url(route('frontend.search.index')) }}">
                                <input type="text" class="form-control" name="search" placeholder="{{__('apps::frontend.home.search_btn')}}">
                                <button type="submit" class="btn">{{__('apps::frontend.home.search_btn')}}</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3">
                    <div class="block-minicart dropdown">
                        @auth
                        <a class="minicart" href="{{ url(route('frontend.profile.index')) }}">
                            <span class="counter qty">
                                <span class="cart-icon"><i class="ti-user"></i></span>
                            </span>
                        </a>
                        @endauth
                        <a class="minicart shopping_cart" href="{{ url(route('frontend.shopping-cart.index')) }}">
                            <span class="counter qty">
                                <span class="cart-icon"><i class="ti-shopping-cart"></i></span>
                                <span class="counter-number">{{ count(Cart::getContent()) }}</span>
                            </span>
                        </a>
                    </div>
                </div>


                <div class="col-lg-12 col-md-12 remenu" style="display: flex;justify-content: center;align-items: center;">
                    <div class="header-menu-nav-inner">
                        <div class="header-menu-nav">
                            <div class="header-menu">
                                <ul class="header-nav cut_plug-nav">
                                    <li class="btn-close hidden-mobile">
                                        <i class="fa fa-times" aria-hidden="true">
                                        </i>
                                    </li>
                                    <li class="menu-item-has-children {{ active_menu('home') }}">
                                        <a href="{{url(route('frontend.home'))}}" class="dropdown-toggle">
                                            {{__('apps::frontend.nav.home_page')}}
                                        </a>
                                        <span class="toggle-submenu hidden-mobile"></span>
                                    </li>

                                    @foreach ($navCategories as $category)
                                    <li class="menu-item-has-children {!! active_menu('categories/'.$category->translate(locale())->slug) !!}">
                                        <a href="{{ url(route('frontend.categories.show',[
                                        $category->translate(locale())->slug
                                        ])) }}" class="dropdown-toggle">
                                            {{$category->translate(locale())->title}}
                                        </a>
                                        <span class="toggle-submenu hidden-mobile"></span>
                                    </li>
                                    @endforeach

                                    {{-- @foreach ($navVendors as $navVendor)
                                    <li class="menu-item-has-children {!! active_menu('vendors') !!}">
                                        <a href="{{ url(route('frontend.vendors.index',$navVendor->translate(locale())->slug)) }}" class="dropdown-toggle">
                                            {{$navVendor->translate(locale())->title}}
                                        </a>
                                        <span class="toggle-submenu hidden-mobile"></span>
                                    </li>
                                    @endforeach --}}

                                    @foreach ($pages->where('type',0) as $headerPage)
                                    <li class="menu-item-has-children {!! active_menu('pages') !!}">
                                        <a href="{{ url(route('frontend.pages.index',$headerPage->translate(locale())->slug)) }}" class="dropdown-toggle">
                                            {{ $headerPage->translate(locale())->title }}
                                        </a>
                                        <span class="toggle-submenu hidden-mobile"></span>
                                    </li>
                                    @endforeach

                                    <li class="menu-item-has-children {!! active_menu('contact-us') !!}">
                                        <a href="{{ url(route('frontend.contact-us')) }}" class="dropdown-toggle">
                                            {{__('apps::frontend.nav.contact_us_page')}}
                                        </a>
                                        <span class="toggle-submenu hidden-mobile"></span>
                                    </li>

                                    <li class="menu-item-has-children arrow lang-switcher">
                                        <a href="#." class="dropdown-toggle">
                                          {{ LaravelLocalization::getCurrentLocaleNative() }}
                                        </a>
                                        <span class="toggle-submenu hidden-mobile"></span>
                                        <ul class="submenu dropdown-menu">
                                            @foreach (config('laravellocalization.supportedLocales') as $localeCode => $properties)
                                            @if ($localeCode != locale())
                                            <li>
                                                <a hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                    {{ $properties['native'] }}
                                                </a>
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </li>

                                </ul>
                            </div>
                            <span data-action="toggle-nav" class="menu-on-mobile hidden-mobile">
                                <span class="btn-open-mobile home-page">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div class="header-content menu-search" style="display:none">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-4 col-xs-4 remenu">
                    <div class="header-menu-nav-inner">
                        <div class="header-menu-nav">
                            <div class="header-menu">
                                <ul class="header-nav cut_plug-nav">
                                    <li class="btn-close hidden-mobile">
                                        <i class="fa fa-times" aria-hidden="true">
                                        </i>
                                    </li>
                                    <li class="menu-item-has-children {{ active_menu('home') }}">
                                        <a href="{{url(route('frontend.home'))}}" class="dropdown-toggle">
                                            {{__('apps::frontend.nav.home_page')}}
                                        </a>
                                        <span class="toggle-submenu hidden-mobile"></span>
                                    </li>

                                    @foreach ($navCategories as $category)
                                    <li class="menu-item-has-children {!! active_menu('categories/'.$category->translate(locale())->slug) !!}">
                                        <a href="{{ url(route('frontend.categories.show',[
                                        $category->translate(locale())->slug
                                        ])) }}" class="dropdown-toggle">
                                            {{$category->translate(locale())->title}}
                                        </a>
                                        <span class="toggle-submenu hidden-mobile"></span>
                                    </li>
                                    @endforeach

                                    {{-- @foreach ($navVendors as $navVendor)
                                    <li class="menu-item-has-children {!! active_menu('vendors') !!}">
                                        <a href="{{ url(route('frontend.vendors.index',$navVendor->translate(locale())->slug)) }}" class="dropdown-toggle">
                                    {{$navVendor->translate(locale())->title}}
                                    </a>
                                    <span class="toggle-submenu hidden-mobile"></span>
                                    </li>
                                    @endforeach --}}

                                    @foreach ($pages->where('type',0) as $headerPage)
                                    <li class="menu-item-has-children {!! active_menu('pages') !!}">
                                        <a href="{{ url(route('frontend.pages.index',$headerPage->translate(locale())->slug)) }}" class="dropdown-toggle">
                                            {{ $headerPage->translate(locale())->title }}
                                        </a>
                                        <span class="toggle-submenu hidden-mobile"></span>
                                    </li>
                                    @endforeach

                                    <li class="menu-item-has-children {!! active_menu('contact-us') !!}">
                                        <a href="{{ url(route('frontend.contact-us')) }}" class="dropdown-toggle">
                                            {{__('apps::frontend.nav.contact_us_page')}}
                                        </a>
                                        <span class="toggle-submenu hidden-mobile"></span>
                                    </li>

                                    <li class="menu-item-has-children arrow lang-switcher">
                                        <a href="#." class="dropdown-toggle">
                                            {{ LaravelLocalization::getCurrentLocaleNative() }}
                                        </a>
                                        <span class="toggle-submenu hidden-mobile"></span>
                                        <ul class="submenu dropdown-menu">
                                            @foreach (config('laravellocalization.supportedLocales') as $localeCode => $properties)
                                            @if ($localeCode != locale())
                                            <li>
                                                <a hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                    {{ $properties['native'] }}
                                                </a>
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </li>

                                </ul>
                            </div>
                            <span data-action="toggle-nav" class="menu-on-mobile hidden-mobile">
                                <span class="btn-open-mobile home-page">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-4">
                    <div class="block-minicart dropdown">
                        @auth
                        <a class="minicart" href="{{ url(route('frontend.profile.index')) }}">
                            <span class="counter qty">
                                <span class="cart-icon"><i class="ti-user"></i></span>
                            </span>
                        </a>
                        @endauth
                        <a class="minicart shopping_cart" href="{{ url(route('frontend.shopping-cart.index')) }}">
                            <span class="counter qty">
                                <span class="cart-icon"><i class="ti-shopping-cart"></i></span>
                                <span class="counter-number">{{ count(Cart::getContent()) }}</span>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-4">
                    <div class="logo-header">
                        <a href="{{url(route('frontend.home'))}}">
                            <img src="{{url(config('setting.logo'))}}" alt="logo">
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="menu-search" style="display:none">
        <div class="col-lg-6 col-md-6">
            <div class="library-search" style="width:100%">
                <div class="subscribe-form">
                    <form method="get" action="{{ url(route('frontend.search.index')) }}">
                        <input type="text" class="form-control" name="search" placeholder="{{__('apps::frontend.home.search_btn')}}">
                        <button type="submit" class="btn">{{__('apps::frontend.home.search_btn')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="header-content menu-search" style="display:none">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>
</header>
