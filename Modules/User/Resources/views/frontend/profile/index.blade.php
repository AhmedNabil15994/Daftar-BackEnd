@extends('apps::frontend.layouts.app')
@section('title', Auth::user()->name )
@section('content')
<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ Auth::user()->name}}</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="account-setting">
        <div class="row">
          @if (session('status'))
          <div class="alert alert-{{session('alert')}}" role="alert">
              <center>
                  {{ session('status') }}
              </center>
          </div>
          @endif
            <div class="col-md-3">
                <div class="content-sidebar user_side">
                    <div class="panel-group" id="accordionNo">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapseCategory" class="collapseWill">
                                        <span> <i class="fa fa-caret-right"></i></span>
                                        {{ __('user::frontend.profile.index.title') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseCategory" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <ul class="categories-content">
                                        <li class="has-child active">
                                            <a href="#">
                                                <i class="ti-user"></i>
                                                {{ __('user::frontend.profile.index.update') }}
                                            </a>
                                        </li>
                                        <li class="has-child">
                                            <a href="{{ url(route('frontend.orders.index')) }}">
                                                <i class="ti-user"></i>
                                                {{ __('user::frontend.profile.index.orders') }}
                                            </a>
                                        </li>
                                        <li class="has-child">
                                            <a href="{{ url(route('frontend.profile.address.index')) }}">
                                                <i class="ti-user"></i>
                                                {{ __('user::frontend.profile.index.addresses') }}
                                            </a>
                                        </li>
                                        <li class="has-child">
                                            <a href="{{ url(route('frontend.favorites.index')) }}">
                                                <i class="ti-user"></i>
                                                {{ __('user::frontend.profile.index.favorites') }}
                                            </a>
                                        </li>
                                        <li class="has-child">
                                            <a onclick="event.preventDefault();document.getElementById('logout').submit();" href="#.">
                                                <i class="ti-key"></i>
                                                {{ __('user::frontend.profile.index.logout') }}
                                            </a>
                                            <form id="logout" action="{{ route('frontend.logout') }}" method="POST">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="title-top">
                    <h3 class="title-block title-with-board">
                        <span>
                            {{ __('user::frontend.profile.index.update') }}
                        </span>
                    </h3>
                </div>
                <form method="post" action="{{ url(route('frontend.profile.update')) }}" class="edit-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('user::frontend.profile.index.form.name') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="text" value="{{ Auth::user()->name }}" name="name" class="input-text @error('name') is-invalid @enderror">

                                @error('name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('user::frontend.profile.index.form.email') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" class="input-text @error('email') is-invalid @enderror">
                                @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('user::frontend.profile.index.form.mobile') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="text" name="mobile" value="{{ Auth::user()->mobile }}" class="input-text @error('mobile') is-invalid @enderror">
                                @error('mobile')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('user::frontend.profile.index.form.current_password') }}
                                </label>
                                <input type="password" name="current_password" class="input-text @error('current_password') is-invalid @enderror">
                                @error('current_password')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('user::frontend.profile.index.form.password') }}
                                </label>
                                <input type="password" name="password" class="input-text @error('password') is-invalid @enderror">
                                @error('password')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('user::frontend.profile.index.form.password_confirmation') }}
                                </label>
                                <input type="password" name="password_confirmation" class="input-text">
                            </p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p class="form-row form-row-wide">
                            <input type="submit" value="{{ __('user::frontend.profile.index.form.btn.update') }}" class="button-submit">
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
