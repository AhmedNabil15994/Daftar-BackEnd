@extends('apps::frontend.layouts.app')
@section('title', $section->translate(locale())->title )
@section('content')
@section('seo')
  @include('meta::manager', [
      'title'         => $section->translate(locale())->title,
      'keywords'      => $section->translate(locale())->seo_keywords,
      'description'   => $section->translate(locale())->seo_description,
      'image'         => url(config('setting.logo')),
  ])
@append
<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ $section->translate(locale())->title }}</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="inner-page row">
        @include('apps::frontend.layouts._alerts')
        <div class="col-md-12">
            <div class="home-products">
                <div class="row">
                    @foreach ($vendors as $vendor)
                    <div class="col-md-3">
                        <div class="product-item">
                            <div class="product-inner">
                                <div class="product-thumb">
                                    <div class="thumb-inner">
                                        <a href="{{ url(route('frontend.vendors.index',$vendor->translate(locale())->slug)) }}">
                                            <img src="{{url($vendor->image)}}" alt="{{$vendor->translate(locale())->title}}">
                                        </a>
                                    </div>
                                </div>
                                <div class="product-innfo">
                                    <div class="product-name">
                                        <a href="{{ url(route('frontend.vendors.index',$vendor->translate(locale())->slug)) }}">
                                            {{$vendor->translate(locale())->title}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            {{ $vendors->links() }}
        </div>
    </div>
</div>

@stop
