@extends('apps::frontend.layouts.app')
@section('title', __('authentication::frontend.password.title') )
@section('content')
<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ __('authentication::frontend.password.title') }}</h1>
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
                    <h5 class="title-login">{{ __('authentication::frontend.password.title') }}</h5>
                    <form class="login" method="POST" action="{{ route('frontend.password.email') }}">
                        @csrf
                        <p class="form-row form-row-wide">
                            <label>
                                {{  __('authentication::frontend.password.form.email') }}
                                <span class="note-impor">*</span>
                            </label>
                            <input type="email" value="{{ old('email') }}" autocomplete="off" name="email" class="input-text @error('email') is-invalid @enderror">
                            @error('email')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </p>
                        <p class="form-row">
                            <input type="submit" value="{{  __('authentication::frontend.password.form.btn.password') }}" class="button-submit btn-block">
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
