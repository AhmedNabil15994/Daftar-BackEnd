<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>

            <li class="nav-item {{ active_menu('home') }}">
                <a href="{{ url(route('dashboard.home')) }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ __('apps::dashboard.home.title') }}</span>
                    <span class="selected"></span>
                </a>
            </li>

            @if (\Auth::user()->can(['show_roles']))
                <li class="heading">
                    <h3 class="uppercase">{{ __('apps::dashboard.aside.tab.roles_permissions') }}</h3>
                </li>
            @endif

            {{-- <li class="nav-item {{ active_menu('permissions') }}">
                <a href="{{ url(route('dashboard.permissions.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard.aside.permissions') }}</span>
                </a>
            </li> --}}

            @permission('show_roles')
                <li class="nav-item {{ active_menu('roles') }}">
                    <a href="{{ url(route('dashboard.roles.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.roles') }}</span>
                    </a>
                </li>
            @endpermission


            @if (\Auth::user()->can(['show_users', 'show_admins', 'show_sellers', 'show_drivers']))
                <li class="heading">
                    <h3 class="uppercase">{{ __('apps::dashboard.aside.tab.users') }}</h3>
                </li>
            @endif

            @permission('show_users')
                <li class="nav-item {{ active_menu('users') }}">
                    <a href="{{ url(route('dashboard.users.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.users') }}</span>
                    </a>
                </li>
            @endpermission


            @permission('show_admins')
                <li class="nav-item {{ active_menu('admins') }}">
                    <a href="{{ url(route('dashboard.admins.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.admins') }}</span>
                    </a>
                </li>
            @endpermission

            @permission('show_sellers')
                <li class="nav-item {{ active_menu('sellers') }}">
                    <a href="{{ url(route('dashboard.sellers.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.sellers') }}</span>
                    </a>
                </li>
            @endpermission

            @permission('show_drivers')
                <li class="nav-item {{ active_menu('drivers') }}">
                    <a href="{{ url(route('dashboard.drivers.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.drivers') }}</span>
                    </a>
                </li>
            @endpermission

            @if (Module::isEnabled('Vendor'))

                @if (\Auth::user()->can(['show_sections', 'show_vendors', 'show_delivery_charges', 'show_times']))
                    <li class="heading">
                        <h3 class="uppercase">{{ __('apps::dashboard.aside.tab.vendors') }}</h3>
                    </li>
                @endif

                @permission('show_sections')
                    <li class="nav-item {{ active_menu('sections') }}">
                        <a href="{{ url(route('dashboard.sections.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.sections') }}</span>
                        </a>
                    </li>
                @endpermission

                {{-- @permission('show_payments')
                <li class="nav-item {{ active_menu('payments') }}">
                    <a href="{{ url(route('dashboard.payments.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.payments') }}</span>
                    </a>
                </li>
                @endpermission --}}

                @permission('show_vendors')
                    <li class="nav-item {{ active_menu('vendors') }}">
                        <a href="{{ url(route('dashboard.vendors.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.vendors') }}</span>
                        </a>
                    </li>
                @endpermission


                @permission('show_delivery_charges')
                    <li class="nav-item {{ active_menu('delivery-charges') }}">
                        <a href="{{ url(route('dashboard.delivery-charges.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.delivery_charges') }}</span>
                        </a>
                    </li>
                @endpermission

                @permission('show_times')
                    <li class="nav-item {{ active_menu('times') }}">
                        <a href="{{ url(route('dashboard.times.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.times') }}</span>
                        </a>
                    </li>
                @endpermission
            @endif

            @if (Module::isEnabled('Subscription'))

                @if (\Auth::user()->can(['show_packages', 'show_subscriptions']))
                    <li class="heading">
                        <h3 class="uppercase">{{ __('apps::dashboard.aside.tab.subscriptions') }}</h3>
                    </li>
                @endif

                @permission('show_packages')
                    <li class="nav-item {{ active_menu('packages') }}">
                        <a href="{{ url(route('dashboard.packages.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.packages') }}</span>
                        </a>
                    </li>
                @endpermission

                @permission('show_subscriptions')
                    <li class="nav-item {{ active_menu('subscriptions') }}">
                        <a href="{{ url(route('dashboard.subscriptions.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.subscriptions') }}</span>
                        </a>
                    </li>
                @endpermission
            @endif

            @if (Module::isEnabled('Area'))

                @if (\Auth::user()->can(['show_cities', 'show_states']))
                    <li class="heading">
                        <h3 class="uppercase">{{ __('apps::dashboard.aside.tab.areas') }}</h3>
                    </li>
                @endif

                {{-- @permission('show_countries')
                <li class="nav-item {{ active_menu('countries') }}">
                    <a href="{{ url(route('dashboard.countries.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.countries') }}</span>
                    </a>
                </li>
                @endpermission --}}

                @permission('show_cities')
                    <li class="nav-item {{ active_menu('cities') }}">
                        <a href="{{ url(route('dashboard.cities.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.cities') }}</span>
                        </a>
                    </li>
                @endpermission

                @permission('show_states')
                    <li class="nav-item {{ active_menu('states') }}">
                        <a href="{{ url(route('dashboard.states.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.states') }}</span>
                        </a>
                    </li>
                @endpermission
            @endif


            @if (Module::isEnabled('Variation'))

                @if (\Auth::user()->can(['show_options']))
                    <li class="heading">
                        <h3 class="uppercase">{{ __('apps::dashboard.aside.tab.variations') }}</h3>
                    </li>
                @endif

                @permission('show_options')
                    <li class="nav-item {{ active_menu('options') }}">
                        <a href="{{ url(route('dashboard.options.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.options') }}</span>
                        </a>
                    </li>
                @endpermission
            @endif


            @if (Module::isEnabled('Catalog'))

                @if (\Auth::user()->can(['show_brands', 'show_categories', 'show_products', 'show_coupon']))
                    <li class="heading">
                        <h3 class="uppercase">{{ __('apps::dashboard.aside.tab.catalog') }}</h3>
                    </li>
                @endif

                @permission('show_brands')
                    <li class="nav-item {{ active_menu('brands') }}">
                        <a href="{{ url(route('dashboard.brands.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.brands') }}</span>
                        </a>
                    </li>
                @endpermission

                @permission('show_categories')
                    <li class="nav-item {{ active_menu('categories') }}">
                        <a href="{{ url(route('dashboard.categories.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.categories') }}</span>
                        </a>
                    </li>
                @endpermission

                @permission('show_products')
                    <li class="nav-item {{ active_menu('products') }}">
                        <a href="{{ url(route('dashboard.products.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.products') }}</span>
                        </a>
                    </li>
                @endpermission

                @permission('show_coupon')
                    <li class="nav-item {{ active_menu('coupons') }}">
                        <a href="{{ url(route('dashboard.coupons.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-calculator"></i>
                            <span class="title">{{ __('apps::dashboard.aside.coupons') }}</span>
                        </a>
                    </li>
                @endpermission
            @endif

            @if (Module::isEnabled('Order'))

                @if (\Auth::user()->can(['show_orders']))
                    <li class="heading">
                        <h3 class="uppercase">{{ __('apps::dashboard.aside.tab.orders') }}</h3>
                    </li>
                @endif

                @permission('show_orders')
                    <li class="nav-item {{ active_menu2('dashboard.orders.success') }}">
                        <a href="{{ url(route('dashboard.orders.success')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.success') }}</span>
                        </a>
                    </li>
                @endpermission

                @permission('show_orders')
                    <li class="nav-item {{ active_menu2('dashboard.orders.index') }}">
                        <a href="{{ url(route('dashboard.orders.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.orders') }}</span>
                        </a>
                    </li>
                @endpermission

                {{-- @permission('show_order_statuses')
                <li class="nav-item {{ active_menu('order-statuses') }}">
                    <a href="{{ url(route('dashboard.order-statuses.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.order_statuses') }}</span>
                    </a>
                </li>
                @endpermission --}}
            @endif

            @if (Module::isEnabled('Transaction'))

                @if (\Auth::user()->can(['show_transactions']))
                    <li class="heading">
                        <h3 class="uppercase">{{ __('apps::dashboard.aside.tab.transactions') }}</h3>
                    </li>
                @endif

                @permission('show_transactions')
                    <li class="nav-item {{ active_menu('transactions') }}">
                        <a href="{{ url(route('dashboard.transactions.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard.aside.transactions') }}</span>
                        </a>
                    </li>
                @endpermission
            @endif

            @if (\Auth::user()->can(['show_products', 'statistics', 'show_orders']))
                <li class="heading">
                    <h3 class="uppercase">{{ __('apps::dashboard.aside.tab.reports') }}</h3>
                </li>
            @endif

            @permission('show_products')
                <li class="nav-item {{ active_menu('qty-product') }}">
                    <a href="{{ url(route('dashboard.qty-product.reports')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.products_reports') }}</span>
                    </a>
                </li>
            @endpermission

            @permission('statistics')
                <li class="nav-item {{ active_menu('order-vendor') }}">
                    <a href="{{ url(route('dashboard.order-vendor.reports')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.orders_reports') }}</span>
                    </a>
                </li>
            @endpermission

            @permission('show_orders')
                <li class="nav-item {{ active_menu2('dashboard.reports.product_sale') }}">
                    <a href="{{ url(route('dashboard.reports.product_sale')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.product_sales_reports') }}</span>
                    </a>
                </li>
            @endpermission

            @permission('show_orders')
                <li class="nav-item {{ active_menu('all_reports') }}">
                    <a href="{{ url(route('dashboard.all_reports.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.reports') }}</span>
                    </a>
                </li>
            @endpermission

            @if (\Auth::user()->can(['show_notifications', 'show_pages', 'show_advertising', 'show_popup_adds', 'show_slider']))
                <li class="heading">
                    <h3 class="uppercase">{{ __('apps::dashboard.aside.tab.other') }}</h3>
                </li>
            @endif

            @permission('show_notifications')
                <li class="nav-item {{ active_menu('notifications') }}">
                    <a href="{{ url(route('dashboard.notifications.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.notifications') }}</span>
                    </a>
                </li>
            @endpermission

            @permission('show_pages')
                <li class="nav-item {{ active_menu('pages') }}">
                    <a href="{{ url(route('dashboard.pages.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.pages') }}</span>
                    </a>
                </li>
            @endpermission

            {{-- @permission('show_advertising')
            <li class="nav-item {{ active_menu('advertising') }}">
                <a href="{{ url(route('dashboard.advertising.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard.aside.advertising') }}</span>
                </a>
            </li>
            @endpermission --}}

            @permission('show_advertising')
                <li class="nav-item {{ active_menu('advertising_groups') }}">
                    <a href="{{ url(route('dashboard.advertising_groups.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.advertising_groups') }}</span>
                    </a>
                </li>
            @endpermission

            @permission('show_popup_adds')
                <li class="nav-item {{ active_menu('popup_adds') }}">
                    <a href="{{ url(route('dashboard.popup_adds.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.popup_adds') }}</span>
                    </a>
                </li>
            @endpermission

            @permission('show_slider')
                <li class="nav-item {{ active_menu('slider') }}">
                    <a href="{{ url(route('dashboard.slider.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.slider') }}</span>
                    </a>
                </li>
            @endpermission

            <li class="nav-item {{ active_menu('setting') }}">
                <a href="{{ url(route('dashboard.setting.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard.aside.setting') }}</span>
                </a>
            </li>

            {{--  <li class="nav-item {{ active_menu('telescope') }}">
                <a href="{{ url(route('telescope')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('apps::dashboard.aside.telescope') }}</span>
                </a>
            </li>  --}}

        </ul>
    </div>
</div>
