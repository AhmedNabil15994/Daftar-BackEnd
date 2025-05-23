@extends('apps::dashboard.layouts.app')
@section('title', __('deliverytime::dashboard.times.routes.index'))
@section('css')

    <style>
        .is_full_day {
            margin-left: 15px;
            margin-right: 15px;
        }

        /*.collapse-custom-time {
            display: none;
        }*/

        .times-row {
            margin-bottom: 5px;
        }

    </style>

@endsection
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
                        <a href="#">{{ __('deliverytime::dashboard.times.routes.index') }}</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">

                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">
                                    {{ __('deliverytime::dashboard.times.routes.index') }}
                                </span>
                            </div>
                        </div>

                        {{-- DATATABLE CONTENT --}}
                        <div class="portlet-body">
                            <div class="row">

                                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                                    enctype="multipart/form-data" action="{{ route('dashboard.custom_times.update') }}">
                                    @csrf
                                    @method('PUT')

                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('apps::dashboard.availabilities.form.day') }}</th>
                                                <th>{{ __('apps::dashboard.availabilities.form.time_status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (getDays() as $k => $day)
                                                <tr>
                                                    <td>
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" class="group-checkable"
                                                                {{ isset($daysQuery->where('day_code', $k)->first()->status) && $daysQuery->where('day_code', $k)->first()->status == 1 ? 'checked' : '' }}
                                                                value="{{ $k }}" name="days_status[]">
                                                            <span></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        {{ $day }}
                                                    </td>
                                                    <td>

                                                        <div class="form-check form-check-inline">

                                                            {{-- <span class="is_full_day">
                                                                <input class="form-check-input check-time" type="radio"
                                                                    name="is_full_day[{{ $k }}]"
                                                                    id="full_time-{{ $k }}" value="1"
                                                                    {{ $daysQuery->where('day_code', $k)->first() == null || $daysQuery->where('day_code', $k)->first()->is_full_day == 1 ? 'checked' : '' }}
                                                                    onclick="hideCustomTime('{{ $k }}')">
                                                                <label class="form-check-label"
                                                                    for="full_time-{{ $k }}">
                                                                    {{ __('apps::dashboard.availabilities.form.full_time') }}
                                                                </label>
                                                            </span> --}}

                                                            <span class="is_full_day">
                                                                <input class="form-check-input check-time" type="radio"
                                                                    name="is_full_day[{{ $k }}]"
                                                                    id="custom_time-{{ $k }}" value="0"
                                                                    {{ $daysQuery->where('day_code', $k)->first() == null || (isset($daysQuery->where('day_code', $k)->first()->is_full_day) && $daysQuery->where('day_code', $k)->first()->is_full_day == 0) ? 'checked' : '' }}
                                                                    onclick="showCustomTime('{{ $k }}')">
                                                                <label class="form-check-label"
                                                                    for="custom_time-{{ $k }}">
                                                                    {{ __('apps::dashboard.availabilities.form.custom_time') }}
                                                                </label>
                                                            </span>
                                                        </div>

                                                    </td>
                                                </tr>

                                                @if (isset($daysQuery->where('day_code', $k)->first()->is_full_day) && $daysQuery->where('day_code', $k)->first()->is_full_day == 0)
                                                    <tr id="collapse-{{ $k }}" class="">
                                                        <td colspan="3" id="div-content-{{ $k }}">
                                                            <div class="row" style="margin-bottom: 5px;">
                                                                <div class="col-md-3">
                                                                    <button type="button" class="btn btn-success"
                                                                        onclick="addMoreDayTimes(event, '{{ $k }}')">
                                                                        {{ __('apps::dashboard.availabilities.form.btn_add_more') }}
                                                                        <i class="fa fa-plus-circle"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            @foreach ($daysQuery->where('day_code', $k)->first()->custom_times as $key => $time)
                                                                <div class="row times-row"
                                                                    id="rowId-{{ $k }}-{{ $key }}">
                                                                    <div class="col-md-3">
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control timepicker 24_format"
                                                                                name="availability[time_from][{{ $k }}][]"
                                                                                data-name="availability[time_from][{{ $k }}][]"
                                                                                value="{{ $time['time_from'] }}">
                                                                            <span class="input-group-btn">
                                                                                <button class="btn default"
                                                                                    type="button">
                                                                                    <i class="fa fa-clock-o"></i>
                                                                                </button>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control timepicker 24_format"
                                                                                name="availability[time_to][{{ $k }}][]"
                                                                                data-name="availability[time_to][{{ $k }}][]"
                                                                                value="{{ $time['time_to'] }}">
                                                                            <span class="input-group-btn">
                                                                                <button class="btn default"
                                                                                    type="button">
                                                                                    <i class="fa fa-clock-o"></i>
                                                                                </button>
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                    @if ($key != 0)
                                                                        <div class="col-md-3">
                                                                            <button type="button" class="btn btn-danger"
                                                                                onclick="removeDayTimes('{{ $k }}', '{{ $key }}', 'row')">
                                                                                X
                                                                            </button>
                                                                        </div>
                                                                    @endif

                                                                </div>
                                                            @endforeach

                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr id="collapse-{{ $k }}" class="collapse-custom-time">
                                                        <td colspan="3" id="div-content-{{ $k }}">
                                                            <div class="row" style="margin-bottom: 5px;">
                                                                <div class="col-md-3">
                                                                    <button type="button" class="btn btn-success"
                                                                        onclick="addMoreDayTimes(event, '{{ $k }}')">
                                                                        {{ __('apps::dashboard.availabilities.form.btn_add_more') }}
                                                                        <i class="fa fa-plus-circle"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="row times-row" id="rowId-{{ $k }}-0">
                                                                <div class="col-md-3">
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control timepicker 24_format"
                                                                            name="availability[time_from][{{ $k }}][]"
                                                                            data-name="availability[time_from][{{ $k }}][]"
                                                                            value="00">
                                                                        <span class="input-group-btn">
                                                                            <button class="btn default" type="button">
                                                                                <i class="fa fa-clock-o"></i>
                                                                            </button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control timepicker 24_format"
                                                                            name="availability[time_to][{{ $k }}][]"
                                                                            data-name="availability[time_to][{{ $k }}][]"
                                                                            value="23">
                                                                        <span class="input-group-btn">
                                                                            <button class="btn default" type="button">
                                                                                <i class="fa fa-clock-o"></i>
                                                                            </button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="col-md-12">
                                        <div class="form-actions text-center">
                                            @include(
                                                'apps::dashboard.layouts._ajax-msg'
                                            )
                                            <div class="form-group">
                                                <button type="submit" id="submit" class="btn btn-lg green">
                                                    {{ __('apps::dashboard.general.edit_btn') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

    <script>
        var timePicker = $(".timepicker");
        timePicker.timepicker({
            timeFormat: 'HH',
        });

        var rowCountsArray = [];

        function hideCustomTime(id) {
            $("#collapse-" + id).hide();
        }

        function showCustomTime(id) {
            $("#collapse-" + id).show();
        }

        function addMoreDayTimes(e, dayCode) {

            if (e.preventDefault) {
                e.preventDefault();
            } else {
                e.returnValue = false;
            }

            var rowCount = Math.floor(Math.random() * 9000000000) + 1000000000;
            rowCountsArray.push(rowCount);

            var divContent = $('#div-content-' + dayCode);
            var newRow = `
        <div class="row times-row" id="rowId-${dayCode}-${rowCount}">
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" class="form-control timepicker 24_format" name="availability[time_from][${dayCode}][]"
                           data-name="availability[time_from][${dayCode}][]" value="00">
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-clock-o"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" class="form-control timepicker 24_format" name="availability[time_to][${dayCode}][]"
                           data-name="availability[time_to][${dayCode}][]" value="23">
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-clock-o"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-danger" onclick="removeDayTimes('${dayCode}', ${rowCount}, 'row')">X</button>
            </div>
        </div>
        `;

            divContent.append(newRow);

            $(".timepicker").timepicker({
                timeFormat: 'HH',
            });
        }

        function removeDayTimes(dayCode, index, flag = '') {

            if (flag === 'row') {
                $('#rowId-' + dayCode + '-' + index).remove();
                const i = rowCountsArray.indexOf(index);
                if (i > -1) {
                    rowCountsArray.splice(i, 1);
                }
            }

        }
    </script>

@stop
