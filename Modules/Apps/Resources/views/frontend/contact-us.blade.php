@extends('apps::frontend.layouts.app')
@section('title', __('apps::frontend.contact_us.title') )
@section('content')

<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ __('apps::frontend.contact_us.title') }}</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="innerPage contact">
        <div class="row">
            <div class="col-md-8">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    <center>
                        {{ session('status') }}
                    </center>
                </div>
                @endif
                <div class="title-top">
                    <h3 class="title-block title-with-board">
                        <span>{{ __('apps::frontend.contact_us.title_2')}}</span>
                    </h3>
                </div>
                <form class="form-contact" action="{{ url(route('frontend.send-contact-us')) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-info">
                                <p class="form-row form-row-wide">
                                    <label>
                                        {{ __('apps::frontend.contact_us.form.username')}}
                                        <span class="note-impor">*</span>
                                    </label>
                                    <input type="text" name="username" class="input-text @error('email') is-invalid @enderror" value="{{ old('username') }}">
                                    @error('username')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </p>
                                <p class="form-row form-row-wide">
                                    <label>
                                        {{ __('apps::frontend.contact_us.form.email')}}
                                        <span class="note-impor">*</span>
                                    </label>
                                    <input type="email" name="email" class="input-text @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </p>
                                <p class="form-row form-row-wide">
                                    <label>
                                        {{ __('apps::frontend.contact_us.form.mobile')}}
                                        <span class="note-impor">*</span>
                                    </label>
                                    <input type="text" name="mobile" class="input-text @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}">
                                    @error('mobile')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('apps::frontend.contact_us.form.message')}}
                                    <span class="note-impor">*</span>
                                </label>
                                <textarea aria-invalid="false" class="textarea-control @error('message') is-invalid @enderror" name="message">{{ old('message') }}</textarea>
                                @error('message')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                            <p class="form-row">
                                <input type="submit" value="{{ __('apps::frontend.contact_us.form.btn.send')}}" class="button-submit  btn-block">
                            </p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <div class="title-top">
                    <h3 class="title-block title-with-board">
                        <span> {{ __('apps::frontend.contact_us.info.title')}}</span>
                    </h3>
                </div>
                <ul class="contact-details">
                    <li>
                        <i class="ti-mobile"></i>
                        <strong>{{ __('apps::frontend.contact_us.info.mobile')}} :</strong>
                        <span>{{config('setting.contact_us.whatsapp')}}</span>
                    </li>
{{--                    <li>--}}
{{--                        <i class="ti-email"></i>--}}
{{--                        <strong>{{ __('apps::frontend.contact_us.info.email')}} :</strong>--}}
{{--                        <span>{{config('setting.contact_us.email')}}</span>--}}
{{--                    </li>--}}
                </ul>
            </div>
        </div>
    </div>
</div>

@stop
