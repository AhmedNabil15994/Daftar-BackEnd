@extends('apps::frontend.layouts.app')
@section('title', $page->translate(locale())->title)
@section('content')
@section('seo')
  @include('meta::manager', [
      'title'         => $page->translate(locale())->title,
      'keywords'      => $page->translate(locale())->seo_keywords,
      'description'   => $page->translate(locale())->seo_description,
      'image'         => url(config('setting.logo')),
  ])
@append

<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ $page->translate(locale())->title }}</h1>
        </div>
    </div>
</div>


<div class="innerPage">
    <div class="container">
        <div class="sig-page-section">
          {!! $page->translate(locale())->description !!}
        </div>
    </div>
</div>
@stop
