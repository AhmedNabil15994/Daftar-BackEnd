@extends('apps::frontend.layouts.app')
@section('title', __('catalog::frontend.address.title') )
@section('content')

<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ __('catalog::frontend.address.title') }}</h1>
        </div>
    </div>
</div>


<div class="container">

    @guest
    <div class="inner-page login-page">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="account-setting">
                        <div class="row">
                            <div class="title-top">
                                <h3 class="title-block title-with-board">
                                    <span> {{ __('catalog::frontend.address.form.as_member') }} </span>
                                </h3>
                                <div class="col-md-12">
                                    <p class="form-row form-row-wide">
                                        <a href="{{ url(route('frontend.login','route=address')) }}">
                                            <input type="button" value="{{ __('catalog::frontend.address.form.login') }}" class="button-submit btn-block">
                                        </a>
                                    </p>
                                    <center>OR</center>
                                    <p class="form-row form-row-wide">
                                        <a href="{{ url(route('frontend.register','route=address')) }}">
                                            <input type="button" value="{{ __('catalog::frontend.address.form.register') }}" class="button-submit btn-block">
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <span class="se-vert"></span>
                </div>
                <div class="col-md-6">
                    <div class="account-setting">
                        <div class="row">
                            @include('apps::frontend.layouts._alerts')
                            <div class="title-top">
                                <h3 class="title-block title-with-board">
                                    <span> {{ __('catalog::frontend.address.form.as_guest') }} </span>
                                </h3>
                            </div>
                            <form action="{{ url(route('frontend.order.address.guest.delivery_charge')) }}" method="post">
                                @csrf
                                @include('catalog::frontend.address.user_type.guest')
                                <button type="submit" class="proc-ch-out">
                                    {{ __('catalog::frontend.address.btn.go_to_payment') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endguest

    @auth
    <div class="account-setting">
        <form action="{{ url(route('frontend.order.address.user.delivery_charge')) }}" method="post">
            @csrf
            @include('catalog::frontend.address.user_type.user')
            <button type="submit" class="proc-ch-out">
                {{ __('catalog::frontend.address.btn.go_to_payment') }}
            </button>
        </form>
    </div>
</div>

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url(route('frontend.profile.address.store')) }}" class="edit-form order-address">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <p class="form-row form-row-wide">
                                <label>
                                    {{ __('catalog::frontend.address.form.email') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="email" value="{{ Auth::user()->email }}" autocomplete="off" name="email" class="input-text @error('email') is-invalid @enderror">
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
                                    {{ __('catalog::frontend.address.form.username') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="text" value="{{ Auth::user()->name }}" autocomplete="off" name="username" class="input-text @error('username') is-invalid @enderror">
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
                                    {{ __('catalog::frontend.address.form.mobile') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="text" value="{{ Auth::user()->mobile }}" autocomplete="off" name="mobile" class="input-text @error('mobile') is-invalid @enderror">
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
                                    {{ __('catalog::frontend.address.form.states') }}
                                    ({{ __('catalog::frontend.addresses.form.kuwait') }})
                                    <span class="note-impor">*</span>
                                </label>
                                <select class="select-detail" name="state">
                                    <option>{{ __('catalog::frontend.address.form.states') }}</option>
                                    @foreach ($cities as $city)
                                    <optgroup label="{{$city->translate(locale())->title}}">
                                        @foreach ($city->states as $state)
                                        <option value="{{ $state->id }}" {{ (old('state') == $state->id ? 'selected' : '') }}>
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
                                    {{ __('catalog::frontend.address.form.block') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="text" value="{{ old('block') }}" autocomplete="off" name="block" class="input-text @error('block') is-invalid @enderror">
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
                                    {{ __('catalog::frontend.address.form.street') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="text" value="{{ old('street') }}" autocomplete="off" name="street" class="input-text @error('street') is-invalid @enderror">
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
                                    {{ __('catalog::frontend.address.form.building') }}
                                    <span class="note-impor">*</span>
                                </label>
                                <input type="text" value="{{ old('building') }}" autocomplete="off" name="building" class="input-text @error('building') is-invalid @enderror">
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
                                    {{ __('catalog::frontend.address.form.address_details') }}
                                </label>
                                <textarea name="address" class="input-text @error('address') is-invalid @enderror"
                                rows="8" cols="80">{{ old('address') }}</textarea>
                                @error('address')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                        </div>
                    </div>
                    <button type="submit" class="proc-ch-out">
                        {{ __('catalog::frontend.address.btn.add') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth

@stop
