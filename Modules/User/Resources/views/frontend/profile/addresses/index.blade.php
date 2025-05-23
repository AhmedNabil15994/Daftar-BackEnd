@extends('apps::frontend.layouts.app')
@section('title', __('user::frontend.addresses.index.title'))
@section('content')

<div class="banner-home library-head-banner page-head">
    <div class="container">
        <div class="library-header ">
            <h1>{{ __('user::frontend.addresses.index.title') }}</h1>
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
                                        {{ __('user::frontend.addresses.index.title') }}
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
                                          <a href="#.">
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
                <div class="row">
                    @foreach ($addresses as $address)
                      <div class="col-md-12">
                          <div class="address-item">
                              <div class="row address-option-row">
                                  <div class="col-md-8 color-brown">{{$address->state->title}}</div>
                              </div>
                              <div class="row address-option-row">
                                  <div class="col-md-8">{{$address->street}}</div>
                              </div>
                              <div class="row address-option-row">
                                  <div class="col-md-8">{{$address->block}}</div>
                              </div>
                              <div class="row address-option-row">
                                  <div class="col-md-8">{{$address->building}}</div>
                              </div>
                              <div class="row address-option-row">
                                  <div class="col-md-8">{{$address->mobile}}</div>
                              </div>
                              <div class="row address-option-row">
                                  <div class="col-md-8">{{$address->address}}</div>
                              </div>
                              <div class="row">
                                  <div class="col-md-12 address-opt">
                                      <a href="{{url(route('frontend.profile.address.edit',$address->id))}}">
                                        <i class="fa fa-edit"></i>
                                        {{ __('user::frontend.addresses.index.btn.edit') }}
                                      </a>
                                      <a href="{{url(route('frontend.profile.address.delete',$address->id))}}">
                                        <i class="fa fa-trash-o"></i>
                                        {{ __('user::frontend.addresses.index.btn.delete') }}
                                      </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop
