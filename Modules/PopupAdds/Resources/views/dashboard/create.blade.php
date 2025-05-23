@extends('apps::dashboard.layouts.app')
@section('title', __('popup_adds::dashboard.popup_adds.routes.create'))
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('dashboard.popup_adds.index')) }}">
                            {{ __('popup_adds::dashboard.popup_adds.routes.index') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('popup_adds::dashboard.popup_adds.routes.create') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.popup_adds.store') }}">
                    @csrf
                    <div class="col-md-12">

                        {{-- RIGHT SIDE --}}
                        <div class="col-md-3">
                            <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                                    </div>
                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li class="active">
                                                    <a href="#general" data-toggle="tab">
                                                        {{ __('popup_adds::dashboard.popup_adds.form.tabs.general') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- PAGE CONTENT --}}
                        <div class="col-md-9">
                            <div class="tab-content">

                                {{-- CREATE FORM --}}
                                <div class="tab-pane active fade in" id="general">
                                    <h3 class="page-title">{{ __('popup_adds::dashboard.popup_adds.form.tabs.general') }}
                                    </h3>
                                    <div class="col-md-10">

                                        <ul class="nav nav-pills">
                                            @foreach (config('translatable.locales') as $k => $code)
                                                <li class="{{ $code == locale() ? 'active' : '' }}">
                                                    <a id="{{ $k }}-general-tab" data-toggle="tab"
                                                        aria-controls="general-tab-{{ $k }}"
                                                        href="#general-tab-{{ $k }}"
                                                        aria-expanded="{{ $code == locale() ? 'true' : 'false' }}">{{ $code }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content px-1 pt-1">

                                            @foreach (config('translatable.locales') as $k => $code)
                                                <div role="tabpanel"
                                                    class="tab-pane {{ $code == locale() ? 'active' : '' }}"
                                                    id="general-tab-{{ $k }}"
                                                    aria-expanded="{{ $code == locale() ? 'true' : 'false' }}"
                                                    aria-labelledby="{{ $k }}-general-tab">

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('popup_adds::dashboard.popup_adds.form.title') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                name="title[{{ $code }}]"
                                                                value="{{ old('title.' . $code) }}" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('popup_adds::dashboard.popup_adds.form.short_description') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                name="short_description[{{ $code }}]"
                                                                value="{{ old('short_description.' . $code) }}" />
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach

                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label
                                                class="col-md-2">{{ __('popup_adds::dashboard.popup_adds.form.popup_adds_type.label') }}</label>
                                            <div class="col-md-9">
                                                <div class="mt-radio-inline">
                                                    <label class="mt-radio">
                                                        <input type="radio" name="popup_adds_type"
                                                            id="externalLinkRadioBtn" value="external"
                                                            onclick="togglePopupAddsType('external')" checked="">
                                                        {{ __('popup_adds::dashboard.popup_adds.form.popup_adds_type.external') }}
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio">
                                                        <input type="radio" name="popup_adds_type"
                                                            id="productLinkRadioBtn" value="product"
                                                            onclick="togglePopupAddsType('product')">
                                                        {{ __('popup_adds::dashboard.popup_adds.form.popup_adds_type.product') }}
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio">
                                                        <input type="radio" name="popup_adds_type"
                                                            id="categoryLinkRadioBtn" value="category"
                                                            onclick="togglePopupAddsType('category')">
                                                        {{ __('popup_adds::dashboard.popup_adds.form.popup_adds_type.category') }}
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio">
                                                        <input type="radio" name="popup_adds_type" id="brandLinkRadioBtn"
                                                            value="brand" onclick="togglePopupAddsType('brand')">
                                                        {{ __('popup_adds::dashboard.popup_adds.form.popup_adds_type.brand') }}
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio">
                                                        <input type="radio" name="popup_adds_type" id="vendorLinkRadioBtn"
                                                            value="vendor" onclick="togglePopupAddsType('vendor')">
                                                        {{ __('popup_adds::dashboard.popup_adds.form.popup_adds_type.vendor') }}
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="externalLinkSection" class="form-group">
                                            <label class="col-md-2">
                                                {{ __('popup_adds::dashboard.popup_adds.form.link') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="link" class="form-control"
                                                    data-name="link">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div id="productsSection" style="display: none;" class="form-group">
                                            <label class="col-md-2">
                                                {{ __('popup_adds::dashboard.popup_adds.form.products') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="product_id" class="select2 form-control"
                                                    data-name="product_id">
                                                    <option value="">
                                                        ---{{ __('popup_adds::dashboard.popup_adds.alert.select_products') }}
                                                        ---
                                                    </option>
                                                    @foreach ($sharedActiveProducts as $k => $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ $product->translate(locale())->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div id="categoriesSection" style="display: none;" class="form-group">
                                            <label class="col-md-2">
                                                {{ __('popup_adds::dashboard.popup_adds.form.categories') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="category_id" class="select2 form-control"
                                                    data-name="category_id">
                                                    <option value="">
                                                        ---{{ __('popup_adds::dashboard.popup_adds.alert.select_categories') }}
                                                        ---
                                                    </option>
                                                    @foreach ($sharedActiveCategories as $k => $category)
                                                        <option value="{{ $category->id }}">
                                                            {{ $category->translate(locale())->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div id="brandsSection" style="display: none;" class="form-group">
                                            <label class="col-md-2">
                                                {{ __('popup_adds::dashboard.popup_adds.form.brands') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="brand_id" class="select2 form-control"
                                                    data-name="brand_id">
                                                    <option value="">
                                                        ---{{ __('popup_adds::dashboard.popup_adds.alert.select_brand') }}
                                                        ---
                                                    </option>
                                                    @foreach ($sharedActiveBrands as $k => $brand)
                                                        <option value="{{ $brand->id }}">
                                                            {{ $brand->translate(locale())->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div id="vendorsSection" style="display: none;" class="form-group">
                                            <label class="col-md-2">
                                                {{ __('popup_adds::dashboard.popup_adds.form.vendors') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="vendor_id" class="select2 form-control"
                                                    data-name="vendor_id">
                                                    <option value="">
                                                        ---{{ __('popup_adds::dashboard.popup_adds.alert.select_vendor') }}
                                                        ---
                                                    </option>
                                                    @foreach ($vendors as $k => $vendor)
                                                        <option value="{{ $vendor->id }}">
                                                            {{ $vendor->translate(locale())->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('popup_adds::dashboard.popup_adds.form.sort') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" name="sort"
                                                    value="0">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('popup_adds::dashboard.popup_adds.form.start_at') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group input-medium date date-picker"
                                                    data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" class="form-control" name="start_at">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('popup_adds::dashboard.popup_adds.form.end_at') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group input-medium date date-picker"
                                                    data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" class="form-control" name="end_at">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('popup_adds::dashboard.popup_adds.form.status') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test"
                                                    data-size="small" name="status">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('popup_adds::dashboard.popup_adds.form.image') }}
                                            </label>
                                            <div class="col-md-9">
                                                @include('core::dashboard.shared.file_upload', [
                                                    'image' => null,
                                                ])
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                {{-- END CREATE FORM --}}

                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg blue">
                                        {{ __('apps::dashboard.general.add_btn') }}
                                    </button>
                                    <a href="{{ url(route('dashboard.popup_adds.index')) }}" class="btn btn-lg red">
                                        {{ __('apps::dashboard.general.back_btn') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        function togglePopupAddsType(type = '') {
            if (type === 'external') {
                $('#externalLinkSection').show();
                $('#productsSection').hide();
                $('#categoriesSection').hide();
                $('#vendorsSection').hide();
                $('#brandsSection').hide();
            } else if (type === 'product') {
                $('#externalLinkSection').hide();
                $('#categoriesSection').hide();
                $('#vendorsSection').hide();
                $('#brandsSection').hide();
                $('#productsSection').show();
            } else if (type === 'category') {
                $('#externalLinkSection').hide();
                $('#productsSection').hide();
                $('#vendorsSection').hide();
                $('#brandsSection').hide();
                $('#categoriesSection').show();
            } else if (type === 'vendor') {
                $('#externalLinkSection').hide();
                $('#productsSection').hide();
                $('#categoriesSection').hide();
                $('#brandsSection').hide();
                $('#vendorsSection').show();
            } else if (type === 'brand') {
                $('#externalLinkSection').hide();
                $('#productsSection').hide();
                $('#categoriesSection').hide();
                $('#vendorsSection').hide();
                $('#brandsSection').show();
            }
        }
    </script>
@endsection
