@extends('apps::frontend.layouts.app')
@section('title', __('user::frontend.addresses.edit.title'))
@section('content')

<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ __('user::frontend.addresses.edit.title') }}</h1>
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
                                        {{ __('user::frontend.addresses.edit.title') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseCategory" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <ul class="categories-content">
                                        <li class="has-child">
                                            <a href="{{ url(route('frontend.profile.index')) }}">
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
                                        <li class="has-child active">
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
                <form action="{{ url(route('frontend.profile.address.update',$address)) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('user::frontend.addresses.form.email') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="email" value="{{ $address->email }}" autocomplete="off" name="email" class="input-text @error('email') is-invalid @enderror">
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
                                    {{ __('user::frontend.addresses.form.username') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="text" value="{{ $address->username }}" autocomplete="off" name="username" class="input-text @error('username') is-invalid @enderror">
                                @error('username')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('user::frontend.addresses.form.mobile') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="text" value="{{ $address->mobile }}" autocomplete="off" name="mobile" class="input-text @error('mobile') is-invalid @enderror">
                                @error('mobile')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p class="form-row">
                                <label>
                                    {{ __('user::frontend.addresses.form.states') }}
                                    ({{ __('user::frontend.addresses.form.kuwait') }})
                                    <span class="note-impor">*</span>
                                </label>
                                <select class="select-detail" name="state">
                                    <option>{{ __('user::frontend.addresses.form.states') }}</option>
                                    @foreach ($cities as $city)
                                    <optgroup label="{{$city->translate(locale())->title}}">
                                        @foreach ($city->states as $state)
                                        <option value="{{$state->id}}" {{ ($address->state_id == $state->id ? 'selected' : '') }}>
                                            {{ $state->translate(locale())->title }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('user::frontend.addresses.form.block') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="text" value="{{ $address->block }}" autocomplete="off" name="block" class="input-text @error('block') is-invalid @enderror">
                                @error('block')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('user::frontend.addresses.form.street') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="text" value="{{ $address->street }}" autocomplete="off" name="street"  class="input-text @error('street') is-invalid @enderror">
                                @error('street')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('user::frontend.addresses.form.building') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="text" value="{{ $address->building }}" autocomplete="off" name="building" class="input-text @error('building') is-invalid @enderror">
                                @error('building')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('user::frontend.addresses.form.address_details') }}
                                </label>
                                <textarea name="address" class="input-text @error('address') is-invalid @enderror"
                                rows="8" cols="80">{{ $address->address }}</textarea>
                                @error('address')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                        </div>
                    </div>
                    <button type="submit" class="proc-ch-out">
                        {{ __('user::frontend.addresses.btn.edit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
