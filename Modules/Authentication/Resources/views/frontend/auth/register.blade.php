@extends('apps::frontend.layouts.app')
@section('title', __('authentication::frontend.register.title') )
@section('content')

<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ __('authentication::frontend.register.title') }}</h1>
        </div>
    </div>
</div>
<div class="inner-page login-page">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-form signin-block">
                    <h5 class="title-login">{{ __('authentication::frontend.register.title') }}</h5>
                    <form class="login" method="POST" action="{{ route('frontend.register') }}" autocomplete="off">
                        @csrf
                        <input type="hidden" name="redirect_to" value="{{$request['route']}}">
                        <p class="form-row form-row-wide">
                            <label>
                                {{ __('authentication::frontend.register.form.name') }}
                                <span class="note-impor">*</span>
                            </label>
                            <input type="text" name="name" class="input-text @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </p>
                        <p class="form-row form-row-wide">
                            <label>
                                {{ __('authentication::frontend.register.form.email') }}
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
                                {{ __('authentication::frontend.register.form.mobile') }}
                                <span class="note-impor">*</span>
                            </label>
                            <input type="text" name="mobile" class="input-text @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}">
                            @error('mobile')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </p>
                        <p class="form-row form-row-wide">
                            <label>
                                {{ __('authentication::frontend.register.form.password') }}
                                <span class="note-impor">*</span>
                            </label>
                            <input type="password" name="password" class="input-text @error('password') is-invalid @enderror">
                            @error('password')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </p>
                        <p class="form-row form-row-wide">
                            <label>
                                {{ __('authentication::frontend.register.form.password_confirmation') }}
                                <span class="note-impor">*</span>
                            </label>
                            <input type="password" name="password_confirmation" class="input-text">
                        </p>
                        <p class="form-row form-row-wide">
                            {{ __('authentication::frontend.register.alert.policy_privacy') }}
                            <a href="#">{{ __('authentication::frontend.register.btn.policy_privacy') }}</a>
                        </p>
                        <p class="form-row">
                            <input type="submit" value="{{ __('authentication::frontend.register.btn.register') }}" class="button-submit btn-block">
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
