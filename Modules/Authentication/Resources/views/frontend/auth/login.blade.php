@extends('apps::frontend.layouts.app')
@section('title', __('authentication::frontend.login.title') )
@section('content')
<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ __('authentication::frontend.login.title') }}</h1>
        </div>
    </div>
</div>
<div class="inner-page login-page">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-form">
                    <h5 class="title-login">{{ __('authentication::frontend.login.title') }}</h5>
                    <form class="login" method="POST" action="{{ route('frontend.login') }}">
                        @csrf
                        <input type="hidden" name="redirect_to" value="{{$request['route']}}">
                        <p class="form-row form-row-wide">
                            <label>
                                {{ __('authentication::frontend.login.form.email')}}
                                <span class="note-impor">*</span>
                            </label>
                            <input type="email" value="{{ old('email') }}" autocomplete="off" name="email" class="input-text @error('email') is-invalid @enderror">
                            @error('email')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </p>
                        <p class="form-row form-row-wide">
                            <label>
                                {{ __('authentication::frontend.login.form.password')}}
                                <span class="note-impor">*</span>
                            </label>
                            <input type="password" name="password" class="input-text @error('password') is-invalid @enderror">
                            @error('password')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </p>
                        <ul>
                            <li class="inline-block-li checkboxes">
                                <input id="check-er" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="check-er">{{ __('authentication::frontend.login.form.remember_me') }}</label>
                            </li>
                            <li class="inline-block-li forgot-password">
                                <a href="{{ route('frontend.password.request') }}" class="">
                                    {{ __('authentication::frontend.login.form.btn.forget_password') }}
                                </a>
                            </li>
                        </ul>
                        <p class="form-row">
                            <input type="submit" value="{{  __('authentication::frontend.login.form.btn.login') }}" class="button-submit btn-block">
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
