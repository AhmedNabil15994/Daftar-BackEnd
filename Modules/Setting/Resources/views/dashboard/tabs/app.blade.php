<div class="tab-pane fade" id="app">
    <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.app') }}</h3>
    <div class="col-md-10">
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.app_name') }} - {{ locale() }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="translate[app_name]" value="{{ config('app.name') }}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.contacts_email') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="contact_us[email]" value="{{config('setting.contact_us.email') ? config('setting.contact_us.email') : ''}}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.contacts_whatsapp') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="contact_us[whatsapp]" value="{{config('setting.contact_us.whatsapp') ? config('setting.contact_us.whatsapp') : ''}}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.alert_stock') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="store[alert_stock]" value="{{config('setting.store.alert_stock') ? config('setting.store.alert_stock') : ''}}" />
            </div>
        </div>
    </div>
</div>
