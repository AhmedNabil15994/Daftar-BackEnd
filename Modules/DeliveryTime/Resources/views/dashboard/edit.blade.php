@extends('apps::dashboard.layouts.app')
@section('title', __('deliverytime::dashboard.times.routes.update'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.times.index')) }}">
                        {{__('deliverytime::dashboard.times.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('deliverytime::dashboard.times.routes.update')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.times.update',$time->id)}}">
                @csrf
                @method('PUT')
                <div class="col-md-12">

                    {{-- RIGHT SIDE --}}
                    <div class="col-md-3">
                        <div class="panel-group accordion scrollable" id="accordion2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                                </div>
                                <div id="collapse_2_1" class="panel-collapse in">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li class="active">
                                                <a href="#global_setting" data-toggle="tab">
                                                    {{ __('deliverytime::dashboard.times.form.tabs.general') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PAGE CONTENT --}}
                    <div class="col-md-9">
                        <div class="tab-content">

                            {{-- UPDATE FORM --}}
                            <div class="tab-pane active fade in" id="global_setting">
                                <h3 class="page-title">{{__('deliverytime::dashboard.times.form.tabs.general')}}</h3>
                                <div class="col-md-10">

                                  <div class="form-group">
                                      <label class="col-md-2">
                                          {{__('deliverytime::dashboard.times.form.from')}}
                                      </label>
                                      <div class="col-md-3">
                                          <div class="input-group">
                                              <input type="text" class="form-control timepicker timepicker-24" name="delivery_from" value="{{ $time->from }}">
                                              <span class="input-group-btn">
                                                  <button class="btn default" type="button">
                                                      <i class="fa fa-clock-o"></i>
                                                  </button>
                                              </span>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label class="col-md-2">
                                          {{__('deliverytime::dashboard.times.form.to')}}
                                      </label>
                                      <div class="col-md-3">
                                          <div class="input-group">
                                              <input type="text" class="form-control timepicker timepicker-24" name="delivery_to" value="{{ $time->to }}">
                                              <span class="input-group-btn">
                                                  <button class="btn default" type="button">
                                                      <i class="fa fa-clock-o"></i>
                                                  </button>
                                              </span>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label class="col-md-2">
                                          {{__('deliverytime::dashboard.times.form.last_order')}}
                                      </label>
                                      <div class="col-md-3">
                                          <div class="input-group">
                                              <input type="text" class="form-control timepicker timepicker-24" name="last_order" value="{{ $time->last_order }}">
                                              <span class="input-group-btn">
                                                  <button class="btn default" type="button">
                                                      <i class="fa fa-clock-o"></i>
                                                  </button>
                                              </span>
                                          </div>
                                      </div>
                                  </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                          {{__('deliverytime::dashboard.times.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status" {{($time->status == 1) ? ' checked="" ' : ''}}>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    @if ($time->trashed())
                                      <div class="form-group">
                                          <label class="col-md-2">
                                            {{__('area::dashboard.update.form.restore')}}
                                          </label>
                                          <div class="col-md-9">
                                              <input type="checkbox" class="make-switch" id="test" data-size="small" name="restore">
                                              <div class="help-block"></div>
                                          </div>
                                      </div>
                                    @endif

                                </div>
                            </div>

                            {{-- END UPDATE FORM --}}

                        </div>
                    </div>

                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg green">
                                    {{__('apps::dashboard.general.edit_btn')}}
                                </button>
                                <a href="{{url(route('dashboard.times.index')) }}" class="btn btn-lg red">
                                    {{__('apps::dashboard.general.back_btn')}}
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@stop
