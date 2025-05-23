<div class="tab-pane active fade in" id="global_setting">
    <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.general') }}</h3>
    <div class="col-md-10">
        <div class="form-group">
            <label class="col-md-2">
              {{ __('setting::dashboard.settings.form.locales') }}
            </label>
            <div class="col-md-9">
                <select name="locales[]" id="single" class="form-control select2" multiple="">
                    @foreach (config('core.available-locales') as $key => $language)
                    <option value="{{ $key }}"
                    @if (in_array($key,array_keys(config('laravellocalization.supportedLocales'))))
                    selected
                    @endif>
                        {{ $language['native'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.rtl_locales') }}
            </label>
            <div class="col-md-9">
                <select name="rtl_locales[]" id="single" class="form-control select2" multiple="">
                    @foreach (config('core.available-locales') as $key => $language)
                    <option value="{{ $key }}"
                    @if (in_array($key,config('rtl_locales')))
                    selected
                    @endif>
                        {{ $language['native'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.default_language') }}
            </label>
            <div class="col-md-9">
                <select name="default_locale" id="single" class="form-control select2">
                    @foreach (config('core.available-locales') as $key => $language)
                    <option value="{{ $key }}"
                    @if (config('default_locale') == $key)
                    selected
                    @endif>
                        {{ $language['native'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.last_time_order') }}
            </label>
            <div class="col-md-9">
                <div class="input-group">
                    <input type="text" class="form-control timepicker_15_min" name="last_time_order" autocomplete="off" value="{{config('setting.last_time_order') ? config('setting.last_time_order') : ''}}">
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
                {{ __('setting::dashboard.settings.form.fiexed_delivery') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="fiexed_delivery" autocomplete="off" value="{{config('setting.fiexed_delivery') ? config('setting.fiexed_delivery') : ''}}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.free_delivery') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="free_delivery" autocomplete="off" value="{{config('setting.free_delivery') ? config('setting.free_delivery') : ''}}">
            </div>
        </div>

    </div>
</div>
