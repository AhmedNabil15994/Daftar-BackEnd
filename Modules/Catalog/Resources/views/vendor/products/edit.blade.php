@extends('apps::vendor.layouts.app')
@section('title', __('catalog::vendor.products.routes.update'))
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('vendor.home')) }}">{{ __('apps::vendor.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('vendor.products.index')) }}">
                            {{__('catalog::vendor.products.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('catalog::vendor.products.routes.update')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="{{route('vendor.products.update',$product->id)}}">
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
                                                        {{ __('catalog::vendor.products.form.tabs.general') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#categories" data-toggle="tab">
                                                        {{ __('catalog::vendor.products.form.tabs.categories') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#stock" data-toggle="tab">
                                                        {{ __('catalog::vendor.products.form.tabs.stock') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#new_arrival" data-toggle="tab">
                                                        {{ __('catalog::vendor.products.form.tabs.new_arrival') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#variations" data-toggle="tab">
                                                        {{ __('catalog::vendor.products.form.tabs.variations') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#gallery" data-toggle="tab">
                                                        {{ __('catalog::vendor.products.form.tabs.gallery') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#seo" data-toggle="tab">
                                                        {{ __('catalog::vendor.products.form.tabs.seo') }}
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
                                    <h3 class="page-title">{{__('catalog::vendor.products.form.tabs.general')}}</h3>
                                    <div class="col-md-10">
                                        @foreach (config('translatable.locales') as $code)
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::vendor.products.form.title')}} - {{ $code }}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="title[{{$code}}]" class="form-control"
                                                           data-name="title.{{$code}}"
                                                           value="{{ $product->translate($code)->title }}">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @foreach (config('translatable.locales') as $code)
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::vendor.products.form.description')}} - {{ $code }}
                                                </label>
                                                <div class="col-md-9">
                                                    <textarea name="description[{{$code}}]" rows="8" cols="80"
                                                              class="form-control {{is_rtl($code)}}Editor"
                                                              data-name="description.{{$code}}">{{ $product->translate($code)->description }}</textarea>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::vendor.products.form.vendors')}}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="vendor_id" id="single" class="form-control select2"
                                                        data-name="vendor_id">
                                                    <option value=""></option>
                                                    @foreach ($vendors as $vendor)
                                                        <option
                                                            value="{{ $vendor['id'] }}" {{ ($product->vendor_id == $vendor->id) ? 'selected' : '' }}>
                                                            {{ $vendor->translate(locale())->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::vendor.products.form.brands')}}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="brand_id" id="single" class="form-control select2"
                                                        data-name="brand_id">
                                                    <option value=""></option>
                                                    @foreach ($brands as $brand)
                                                        <option
                                                            value="{{ $brand['id'] }}" {{ ($product->brand_id == $brand->id) ? 'selected' : '' }}>
                                                            {{ $brand->translate(locale())->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::vendor.products.form.image')}}
                                            </label>
                                            <div class="col-md-9">
                                                @include('core::dashboard.shared.file_upload', ['image' => $product->image])
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::vendor.products.form.sort') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="sort" class="form-control"
                                                    data-name="sort" value="{{ $product->sort }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::vendor.products.form.status')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small"
                                                       name="status" {{($product->status == 1) ? ' checked="" ' : ''}}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="categories">
                                    <h3 class="page-title">{{__('catalog::vendor.products.form.tabs.categories')}}</h3>
                                    <div id="jstree">
                                        @include('catalog::vendor.tree.products.edit',['mainCategories' => $mainCategories])
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="category_id" id="root_category" value=""
                                               data-name="category_id">
                                        <div class="help-block"></div>
                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="stock">
                                    <h3 class="page-title">{{__('catalog::vendor.products.form.tabs.stock')}}</h3>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::vendor.products.form.cost_price')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="cost_price" class="form-control"
                                                       data-name="cost_price" value="{{ $product->cost_price }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::vendor.products.form.price')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="price" class="form-control" data-name="price"
                                                       value="{{ $product->price }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::vendor.products.form.sku')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="sku" class="form-control" data-name="sku"
                                                       value="{{ $product->sku }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::vendor.products.form.qty')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="qty" class="form-control" data-name="qty"
                                                       value="{{ $product->qty }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <hr>

                                        <h3 class="page-title">{{__('catalog::vendor.products.form.offer')}}</h3>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::vendor.products.form.offer_status')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="isUnchecked" id="offer-status"
                                                       name="offer_status" @if ($product->offer)
                                                       {{($product->offer->status == 1) ? ' checked="" ' : ''}}
                                                       @endif onclick="checkFunction()">
                                                <input type="hidden" class="isUnchecked" name="offer_status"
                                                       value="0" @if ($product->offer)
                                                    {{($product->offer->status == 1) ? ' disabled ' : ''}}
                                                    @endif>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="offer-form" style="display:none;">
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::vendor.products.form.offer_price')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" id="offer-form" name="offer_price"
                                                           class="form-control" data-name="offer_price" disabled
                                                           value="{{ $product->offer ? $product->offer->offer_price : ''}}">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::vendor.products.form.start_at')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group input-medium date date-picker"
                                                         data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                        <input type="text" id="offer-form" class="form-control"
                                                               name="start_at" data-name="start_at" disabled
                                                               value="{{ $product->offer ? $product->offer->start_at : ''}}">
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
                                                    {{__('catalog::vendor.products.form.end_at')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group input-medium date date-picker"
                                                         data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                        <input type="text" id="offer-form" class="form-control"
                                                               name="end_at" disabled data-name="end_at"
                                                               value="{{ $product->offer ? $product->offer->end_at  : ''}}">
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
                                    <h3 class="page-title">{{__('catalog::vendor.products.form.tabs.new_arrival')}}</h3>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::vendor.products.form.arrival_status')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" id="new-arraival-status" class="isUnchecked"
                                                       name="arrival_status"
                                                       onclick="checkFunction()" @if ($product->newArrival)
                                                    {{($product->newArrival->status == 1) ? ' checked="" ' : ''}}
                                                    @endif >
                                                <input type="hidden" class="isUnchecked" name="arrival_status"
                                                       value="0" @if ($product->newArrival)
                                                    {{($product->newArrival->status == 1) ? ' disabled ' : ''}}
                                                    @endif>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="arrival-form" style="display:none">
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::vendor.products.form.arrival_start_at')}}
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
                                                    {{__('catalog::vendor.products.form.arrival_end_at')}}
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
                                    <h3 class="page-title">{{__('catalog::vendor.products.form.tabs.variations')}}</h3>

                                    @include('catalog::vendor.products.html.tabs_variations')
                                </div>

                                <div class="tab-pane fade in" id="gallery">
                                    <h3 class="page-title">{{__('catalog::vendor.products.form.tabs.gallery')}}</h3>
                                    <div class="col-md-10">
                                        <div class="galleryForm">
                                            @foreach ($product->images as $image)
                                                <div class="form-group">
                                                    <label class="col-md-2">
                                                        {{__('catalog::dashboard.products.form.image')}}
                                                    </label>
                                                    <div class="input-group col-md-9">
                                                        <input class="form-control images" type="hidden"
                                                               name="images_old[]" data-name="images"
                                                               value="{{$image->image}}">
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
                                                    {{__('catalog::dashboard.products.form.image')}}
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
                                    <h3 class="page-title">{{__('catalog::vendor.products.form.tabs.seo')}}</h3>
                                    <div class="col-md-10">

                                        @foreach (config('translatable.locales') as $code)
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::vendor.products.form.meta_keywords')}} - {{ $code }}
                                                </label>
                                                <div class="col-md-9">
                                                    <textarea name="seo_keywords[{{$code}}]" rows="8" cols="80"
                                                              class="form-control"
                                                              data-name="seo_keywords.{{$code}}">{{ $product->seo_keywords }}</textarea>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @foreach (config('translatable.locales') as $code)
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::vendor.products.form.meta_description')}}
                                                    - {{ $code }}
                                                </label>
                                                <div class="col-md-9">
                                                    <textarea name="seo_description[{{$code}}]" rows="8" cols="80"
                                                              class="form-control"
                                                              data-name="seo_description.{{$code}}">{{ $product->seo_description }}</textarea>
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
                                @include('apps::vendor.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg green">
                                        {{__('apps::vendor.general.edit_btn')}}
                                    </button>
                                    <a href="{{url(route('vendor.products.index')) }}" class="btn btn-lg red">
                                        {{__('apps::vendor.general.back_btn')}}
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
        // CATEGORIES TREE
        $(function () {
            $('#jstree').jstree();

            $('#jstree').on("changed.jstree", function (e, data) {
                $('#root_category').val(data.selected);
            });
        });

        // PRODUCT HAS RELATION WITH OFFER / NEW ARRIVAL
        $(function () {

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
        $("#offer-status").click(function (e) {

            if ($('#offer-status').is(':checked')) {
                $("input#offer-form").prop("disabled", false);
                $('.offer-form').css('display', '');
            } else {
                $("input#offer-form").prop("disabled", true);
                $('.offer-form').css('display', 'none');
            }

        });

        // DISABLED OR UNDISABLED OF STATUS FORM
        $("#new-arraival-status").click(function (e) {

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
            $('[name="offer_status"]').change(function () {
                if ($(this).is(':checked'))
                    $(this).next().prop('disabled', true);
                else
                    $(this).next().prop('disabled', false);
            });

            $('[name="arrival_status"]').change(function () {
                if ($(this).is(':checked'))
                    $(this).next().prop('disabled', true);
                else
                    $(this).next().prop('disabled', false);
            });

        }

        // GALLERY FORM / ADD NEW UPLOAD BUTTON
        $(document).ready(function () {
            var html = $("div.getGalleryForm").html();
            $(".addGallery").click(function (e) {
                e.preventDefault();
                $(".galleryForm").append(html);
                $('.lfm').filemanager('image');
            });
        });

        // DELETE UPLOAD BUTTON & IMAGE
        $(".galleryForm").on("click", ".delete-gallery", function (e) {
            e.preventDefault();
            $(this).closest('.form-group').remove();
        });

        var variatns_removed = [];

        $('.variants-delete').click(function () {
            var val = $(this).closest(".filter").find("input[name='variants_ids[]']").val();
            variatns_removed.push(val);
            $("input[name='removed_variants']").val(variatns_removed);

            $(this).closest('.filter').remove();
        });
    </script>

@endsection
