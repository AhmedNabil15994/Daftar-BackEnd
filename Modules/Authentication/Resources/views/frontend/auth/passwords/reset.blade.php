@extends('apps::frontend.layouts.app')
@section('title', __('authentication::frontend.reset.title') )
@section('content')
<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ __('authentication::frontend.reset.title') }}</h1>
        </div>
    </div>
</div>
<div class="inner-page login-page">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-form">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        <center>
                            {{ session('status') }}
                        </center>
                    </div>
                    @endif
                    <h5 class="title-login">{{ __('authentication::frontend.reset.title') }}</h5>
                    <form class="login" method="POST" action="{{ route('frontend.password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <p class="form-row form-row-wide">
                            <label>
                                {{ __('authentication::frontend.reset.form.email') }}
                                <span class="note-impor">*</span>
                            </label>
                            <input type="email" value="{{ $email ?? old('email') }}" autocomplete="off" name="email" class="input-text @error('email') is-invalid @enderror">
                            @error('email')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </p>

                        <p class="form-row form-row-wide">
                            <label>
                                {{ __('authentication::frontend.reset.form.password') }}
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
                                {{ __('authentication::frontend.reset.form.password_confirmation') }}
                                <span class="note-impor">*</span>
                            </label>
                            <input type="password" name="password_confirmation" class="input-text  @error('token') is-invalid @enderror">
                            @error('token')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </p>

                        <p class="form-row">
                            <input type="submit" value="{{  __('authentication::frontend.reset.form.btn.reset') }}" class="button-submit btn-block">
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
