@extends('apps::dashboard.layouts.app')
@section('title', __('catalog::dashboard.products.routes.update'))
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
                        <a href="{{ url(route('dashboard.products.index')) }}">
                            {{ __('catalog::dashboard.products.routes.index') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('catalog::dashboard.products.routes.update') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            @permission('add_products')
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a href="{{ url(route('dashboard.products.clone', $product->id)) }}" class="btn sbold green">
                                    <i class="fa fa-plus"></i> {{ __('apps::dashboard.general.clone') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endpermission

            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.products.update', $product->id) }}">
                    @csrf
                    @method('PUT')
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
                                                    <a href="#global_setting" data-toggle="tab">
                                                        {{ __('catalog::dashboard.products.form.tabs.general') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#categories" data-toggle="tab">
                                                        {{ __('catalog::dashboard.products.form.tabs.categories') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#stock" data-toggle="tab">
                                                        {{ __('catalog::dashboard.products.form.tabs.stock') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#new_arrival" data-toggle="tab">
                                                        {{ __('catalog::dashboard.products.form.tabs.new_arrival') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#variations" data-toggle="tab">
                                                        {{ __('catalog::dashboard.products.form.tabs.variations') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#gallery" data-toggle="tab">
                                                        {{ __('catalog::dashboard.products.form.tabs.gallery') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#seo" data-toggle="tab">
                                                        {{ __('catalog::dashboard.products.form.tabs.seo') }}
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

                                {{-- UPDATE FORM --}}
                                <div class="tab-pane active fade in" id="global_setting">
                                    <h3 class="page-title">{{ __('catalog::dashboard.products.form.tabs.general') }}
                                    </h3>
                                    <div class="col-md-10">
                                        @foreach (config('translatable.locales') as $code)
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.products.form.title') }} -
                                                    {{ $code }}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="title[{{ $code }}]"
                                                        class="form-control" data-name="title.{{ $code }}"
                                                        value="{{ $product->translate($code)->title }}">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @foreach (config('translatable.locales') as $code)
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.products.form.description') }} -
                                                    {{ $code }}
                                                </label>
                                                <div class="col-md-9">
                                                    <textarea name="description[{{ $code }}]" rows="8" cols="80" class="form-control {{ is_rtl($code) }}Editor"
                                                        data-name="description.{{ $code }}">{{ $product->translate($code)->description }}</textarea>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endforeach


                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.products.form.vendors') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="vendor_id" id="single" class="form-control select2"
                                                    data-name="vendor_id">
                                                    <option value=""></option>
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor['id'] }}"
                                                            {{ $product->vendor_id == $vendor->id ? 'selected' : '' }}>
                                                            {{ $vendor->translate(locale())->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.products.form.brands') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="brand_id" id="single" class="form-control select2"
                                                    data-name="brand_id">
                                                    <option value=""></option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand['id'] }}"
                                                            {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                            {{ $brand->translate(locale())->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.products.form.image') }}
                                            </label>
                                            <div class="col-md-9">
                                                @include(
                                                    'core::dashboard.shared.file_upload',
                                                    ['image' => $product->image]
                                                )
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.products.form.sort') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="sort" class="form-control" data-name="sort"
                                                    value="{{ $product->sort }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.products.form.status') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small"
                                                    name="status" {{ $product->status == 1 ? ' checked="" ' : '' }}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.products.form.most_popular') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small"
                                                    name="most_popular"
                                                    {{ $product->most_popular == 1 ? ' checked="" ' : '' }}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="categories">
                                    <h3 class="page-title">{{ __('catalog::dashboard.products.form.tabs.categories') }}
                                    </h3>
                                    <div id="jstree">
                                        @include(
                                            'catalog::dashboard.tree.products.edit',
                                            ['mainCategories' => $mainCategories]
                                        )
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="category_id" id="root_category" value=""
                                            data-name="category_id">
                                        <div class="help-block"></div>
                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="stock">
                                    <h3 class="page-title">{{ __('catalog::dashboard.products.form.tabs.stock') }}</h3>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.products.form.cost_price') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="cost_price" class="form-control"
                                                    data-name="cost_price" value="{{ $product->cost_price }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.products.form.price') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="price" class="form-control" data-name="price"
                                                    value="{{ $product->price }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.products.form.sku') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="sku" class="form-control" data-name="sku"
                                                    value="{{ $product->sku }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.products.form.qty') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="qty" class="form-control" data-name="qty"
                                                    value="{{ $product->qty }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <hr>

                                        <h3 class="page-title">{{ __('catalog::dashboard.products.form.offer') }}</h3>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.products.form.offer_status') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="isUnchecked" id="offer-status"
                                                    name="offer_status"
                                                    @if ($product->offer) {{ $product->offer->status == 1 ? ' checked="" ' : '' }} @endif
                                                    onclick="checkFunction()">
                                                <input type="hidden" class="isUnchecked" name="offer_status" value="0"
                                                    @if ($product->offer) {{ $product->offer->status == 1 ? ' disabled ' : '' }} @endif>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="offer-form" style="display:none;">
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.products.form.offer_price') }}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" id="offer-form" name="offer_price"
                                                        class="form-control" data-name="offer_price" disabled
                                                        value="{{ $product->offer ? $product->offer->offer_price : '' }}">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.products.form.start_at') }}
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group input-medium date date-picker"
                                                        data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                        <input type="text" id="offer-form" class="form-control"
                                                            name="start_at" data-name="start_at" disabled
                                                            value="{{ $product->offer ? $product->offer->start_at : '' }}">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.products.form.end_at') }}
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group input-medium date date-picker"
                                                        data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                        <input type="text" id="offer-form" class="form-control"
                                                            name="end_at" disabled data-name="end_at"
                                                            value="{{ $product->offer ? $product->offer->end_at : '' }}">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="new_arrival">
                                    <h3 class="page-title">
                                        {{ __('catalog::dashboard.products.form.tabs.new_arrival') }}</h3>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.products.form.arrival_status') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" id="new-arraival-status" class="isUnchecked"
                                                    name="arrival_status" onclick="checkFunction()"
                                                    @if ($product->newArrival) {{ $product->newArrival->status == 1 ? ' checked="" ' : '' }} @endif>
                                                <input type="hidden" class="isUnchecked" name="arrival_status" value="0"
                                                    @if ($product->newArrival) {{ $product->newArrival->status == 1 ? ' disabled ' : '' }} @endif>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="arrival-form" style="display:none">
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.products.form.arrival_start_at') }}
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group input-medium date date-picker"
                                                        data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                        <input type="text" class="form-control" name="arrival_start_at"
                                                            disabled id="arrival-form" data-name="arrival_start_at"
                                                            value="{{ $product->newArrival ? $product->newArrival->start_at : '' }}">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.products.form.arrival_end_at') }}
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group input-medium date date-picker"
                                                        data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                        <input type="text" class="form-control" name="arrival_end_at"
                                                            disabled id="arrival-form" data-name="arrival_end_at"
                                                            value="{{ $product->newArrival ? $product->newArrival->end_at : '' }}">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="tab-pane fade in" id="variations">
                                    <h3 class="page-title">
                                        {{ __('catalog::dashboard.products.form.tabs.variations') }}</h3>

                                    {{-- option to add --}}
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="copy_variations_html">
                                                <div class="content">
                                                    <div class="form-group">
                                                        @foreach ($options as $option)
                                                            <div class="col-md-4">
                                                                <div class="mt-element-ribbon bg-grey-steel">
                                                                    <div
                                                                        class="ribbon ribbon-border-hor ribbon-clip ribbon-color-danger uppercase">
                                                                        <div class="ribbon-sub ribbon-clip"></div>
                                                                        {{ $option->translate(locale())->title }}
                                                                    </div>

                                                                    <p class="ribbon-content" style="padding: 8px;">
                                                                    <div class="col-md-offset-2">
                                                                        <div class="mt-checkbox-list">
                                                                            @foreach ($option->values as $value)
                                                                                <label
                                                                                    class="mt-checkbox mt-checkbox-outline">
                                                                                    <input type="checkbox"
                                                                                        name="option_values"
                                                                                        @if ($product->checkIfHaveOption($value->id)) checked @endif
                                                                                        value="{{ $value->id }}"
                                                                                        data-name="option_values[{{ $option->id }}]" />
                                                                                    {{ $value->translate(locale())->title }}
                                                                                    <span></span>
                                                                                </label>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-md-offset-4" style="margin-bottom: 14px;">
                                                        <button type="button" class="btn btn-lg green load_variations">
                                                            <i class="fa fa-refresh"></i>
                                                            Add Variations
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @include(
                                        'catalog::dashboard.products.html.tabs_variations'
                                    )

                                    <div style="display: none" id="result-add-option">
                                        <h2 class="text-center">{{ __('catalog::dashboard.products.form.new_add') }}
                                        </h2>
                                        <div class="html_option_values"></div>
                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="gallery">
                                    <h3 class="page-title">{{ __('catalog::dashboard.products.form.tabs.gallery') }}
                                    </h3>
                                    <div class="col-md-10">
                                        <div class="galleryForm">
                                            @foreach ($product->images as $image)
                                                <div class="form-group">
                                                    <label class="col-md-2">
                                                        {{ __('catalog::dashboard.products.form.image') }}
                                                    </label>
                                                    <div class="input-group col-md-9">
                                                        <input class="form-control images" type="hidden"
                                                            name="images_old[]" data-name="images"
                                                            value="{{ $image->image }}">
                                                        <input class="form-control images" type="file" name="images[]"
                                                            data-name="images" value="{{ url($image->image) }}">
                                                        <div class="help-block"></div>
                                                        <span class="input-group-btn">
                                                            <a data-input="images" data-preview="holder"
                                                                class="btn btn-danger delete-gallery">
                                                                <i class="glyphicon glyphicon-remove"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <span class="holder" style="margin-top:15px;max-height:100px;">
                                                        <img src="{{ url($image->image) }}" alt="" style="height:15rem">
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="getGalleryForm" style="display:none">
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.products.form.image') }}
                                                </label>
                                                <div class="input-group col-md-9">
                                                    <input class="form-control images" type="file" name="images[]"
                                                        data-name="images">
                                                    <div class="help-block"></div>
                                                    <span class="input-group-btn">
                                                        <a data-input="images" data-preview="holder"
                                                            class="btn btn-danger delete-gallery">
                                                            <i class="glyphicon glyphicon-remove"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="button"
                                                class="btn green btn-lg mt-ladda-btn ladda-button btn-circle btn-outline addGallery"
                                                data-style="slide-down" data-spinner-color="#333">
                                                <span class="ladda-label">
                                                    <i class="icon-plus"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="seo">
                                    <h3 class="page-title">{{ __('catalog::dashboard.products.form.tabs.seo') }}</h3>
                                    <div class="col-md-10">

                                        @foreach (config('translatable.locales') as $code)
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.products.form.meta_keywords') }}
                                                    - {{ $code }}
                                                </label>
                                                <div class="col-md-9">
                                                    <textarea name="seo_keywords[{{ $code }}]" rows="8" cols="80" class="form-control"
                                                        data-name="seo_keywords.{{ $code }}">{{ $product->translate($code)->seo_keywords }}</textarea>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @foreach (config('translatable.locales') as $code)
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.products.form.meta_description') }}
                                                    - {{ $code }}
                                                </label>
                                                <div class="col-md-9">
                                                    <textarea name="seo_description[{{ $code }}]" rows="8" cols="80" class="form-control"
                                                        data-name="seo_description.{{ $code }}">{{ $product->translate($code)->seo_description }}</textarea>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                {{-- END UPDATE FORM --}}

                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg green">
                                        {{ __('apps::dashboard.general.edit_btn') }}
                                    </button>
                                    <a href="{{ url(route('dashboard.products.index')) }}" class="btn btn-lg red">
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
        var resultAddVaraivation = $("#result-add-option")
        // CATEGORIES TREE
        $(function() {
            $('#jstree').jstree();

            $('#jstree').on("changed.jstree", function(e, data) {
                $('#root_category').val(data.selected);
            });
        });

        // PRODUCT HAS RELATION WITH OFFER / NEW ARRIVAL
        $(function() {

            @if ($product->offer)
                $("input#offer-form").prop("disabled", false);
                $('.offer-form').css('display', '');
            @endif

            @if ($product->newArrival)
                $("input#arrival-form").prop("disabled", false);
                $('.arrival-form').css('display', '');
            @endif

        });

        // DISABLED OR UNDISABLED OF STATUS FORM
        $("#offer-status").click(function(e) {

            if ($('#offer-status').is(':checked')) {
                $("input#offer-form").prop("disabled", false);
                $('.offer-form').css('display', '');
            } else {
                $("input#offer-form").prop("disabled", true);
                $('.offer-form').css('display', 'none');
            }

        });

        // DISABLED OR UNDISABLED OF STATUS FORM
        $("#new-arraival-status").click(function(e) {

            if ($('#new-arraival-status').is(':checked')) {
                $("input#arrival-form").prop("disabled", false);
                $('.arrival-form').css('display', '');
            } else {
                $("input#arrival-form").prop("disabled", true);
                $('.arrival-form').css('display', 'none');
            }

        });

        // CHANGE STATUS OF CHECKBOX WITH 0 VALUE OR 1
        function checkFunction() {
            $('[name="offer_status"]').change(function() {
                if ($(this).is(':checked'))
                    $(this).next().prop('disabled', true);
                else
                    $(this).next().prop('disabled', false);
            });

            $('[name="arrival_status"]').change(function() {
                if ($(this).is(':checked'))
                    $(this).next().prop('disabled', true);
                else
                    $(this).next().prop('disabled', false);
            });

        }

        // GALLERY FORM / ADD NEW UPLOAD BUTTON
        $(document).ready(function() {
            var html = $("div.getGalleryForm").html();
            $(".addGallery").click(function(e) {
                e.preventDefault();
                $(".galleryForm").append(html);
                $('.lfm').filemanager('image');
            });
        });

        // DELETE UPLOAD BUTTON & IMAGE
        $(".galleryForm").on("click", ".delete-gallery", function(e) {
            e.preventDefault();
            $(this).closest('.form-group').remove();
        });

        var variatns_removed = [];
        var currentVaraition = @json($currentVaration);
        var deleteVaration = [];

        $('.variants-delete').click(function() {
            var val = $(this).closest(".filter").find("input[name='variants_ids[]']").val();
            deleteVaration.push($(this).data("index"))
            console.log(deleteVaration)
            variatns_removed.push(val);
            $("input[name='removed_variants']").val(variatns_removed);
            0
            $(this).closest('.filter').remove();
        });


        // add
        $(".copy_variations_html").on("click", ".delete_options", function(e) {
            e.preventDefault();
            $(this).closest('.form-group').remove();
        });


        $(document).ready(function() {
            $(".load_variations").click(function(e) {
                e.preventDefault();

                var option_values = [];
                var current_option = [];

                if (deleteVaration.length > 0) {
                    for (let index = 0; index < currentVaraition.length; index++) {
                        if (!deleteVaration.includes(index)) {
                            current_option.push(currentVaraition[index])
                        }

                    }
                } else {
                    current_option = currentVaraition
                }

                $.each($("input[name='option_values']:checked"), function() {
                    option_values.push($(this).val());
                });

                $.ajax({
                        type: 'GET',
                        url: '{{ url(route('dashboard.values_by_option_id')) }}',
                        data: {
                            values_ids: option_values,
                            current_option
                        },
                        dataType: 'html',
                        encode: true,
                        beforeSend: function(xhr) {
                            $('.load_variations').prop('disabled', true);
                        }
                    })
                    .done(function(res) {
                        resultAddVaraivation.show()
                        $('.html_option_values').html(res);
                        $('.load_variations').prop('disabled', false);
                    })
                    .fail(function(res) {
                        console.log(res);
                        alert('please select option values');
                    });
            });
        });
    </script>

@endsection
