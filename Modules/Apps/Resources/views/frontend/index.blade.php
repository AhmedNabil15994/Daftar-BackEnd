@extends('apps::frontend.layouts.app')
@section('title', __('apps::frontend.home.title') )
@section('css')
    <style>
        /* Start - Make modal center */
        .modal {
            text-align: center;
            padding: 0 !important;
        }

        .modal:before {
            content: '';
            display: inline-block;
            height: 100%;
            vertical-align: middle;
            margin-right: -4px;
        }

        .modal-dialog {
            display: inline-block;
            text-align: left;
            vertical-align: middle;
        }

        /* End - Make modal center */

    </style>
@endsection
@section('content')

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @foreach ($sliders as $key => $counter)
                <li data-target="#myCarousel" data-slide-to="{{ $key }}" class="{{$key == 0 ? 'active' : ''}}"></li>
            @endforeach
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            @foreach ($sliders as $key2 => $slider)
                <div class="item {{ $key2 == 0 ? 'active' : '' }}">
                    <a href="{{$slider['link']}}">
                        <img src="{{ url($slider['image']) }}">
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container">

        <div class="container">
            <div class="inner-page row">
                @include('apps::frontend.layouts._alerts')
                <div class="col-md-12">
                    <div class="home-products">
                        <div class="row">
                            @foreach ($mainCategories as $mainCategory)
                                <div class="col-md-3 col-xs-6">
                                    <div class="product-item">
                                        <div class="product-inner">
                                            <div class="product-thumb">
                                                <div class="thumb-inner">
                                                    <a href="{{ url(route('frontend.categories.show',$mainCategory->translate(locale())->slug)) }}">
                                                        <img src="{{url($mainCategory->image)}}"
                                                             alt="{{$mainCategory->translate(locale())->title}}">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-innfo">
                                                <div class="product-name">
                                                    <a href="{{ url(route('frontend.categories.show',$mainCategory->translate(locale())->slug)) }}">
                                                        {{$mainCategory->translate(locale())->title}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row home-banner">
            <div class="col-md-12">
                @foreach ($advertisements as $key => $value)
                    <a href="{{ redirectAds($value) }}" target="_blank">
                        <img src="{{url($value->image)}}"/>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{--@if($randomAdvert)
        <!-- Popup Adverts Modal -->
        <div class="modal fade" id="popupAdvertsModal" tabindex="-1" role="dialog"
             aria-labelledby="popupAdvertsModalLabel">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body" style="padding: 0 !important; height: 450px;">
                        <button type="button" class="close btnAdvertClose" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <a href="{{ $randomAdvertLink }}">
                            <img style="width: 100%; height: 100%;"
                                 src="{{ $randomAdvert->image ?? url(config('setting.logo')) }}">
                        </a>
                    </div>
                    --}}{{--<div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>--}}{{--
                </div>
            </div>
        </div>
    @endif--}}

@stop

@section('scripts')
    <script>
        $('#myCarousel').carousel({
            interval: 3000,
            cycle: true
        });

        $(document).ready(function () {
            {{--@if($randomAdvert)
            $('#popupAdvertsModal').modal('show');
            @endif--}}
        });
    </script>
@endsection
