<div class="tab-pane fade" id="logo">

    <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.logo') }}</h3>

    <div class="col-md-10">

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.logo') }}
            </label>
            <div class="col-md-9 {{ $errors->has('images.logo') ? 'has-error' : '' }}">
                @include('core::dashboard.shared.file_upload', ['image' => config('setting.logo') ?? null, 'name' => 'images[logo]', 'imgUploadPreviewID' => 'imgUploadPreview-logo'])
                @if($errors->has('images.logo'))
                    <div class="help-block">{{ $errors->first('images.logo') }}</div>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.favicon') }}
            </label>
            <div class="col-md-9 {{ $errors->has('images.favicon') ? 'has-error' : '' }}">
                @include('core::dashboard.shared.file_upload', ['image' => config('setting.favicon') ?? null, 'name' => 'images[favicon]', 'imgUploadPreviewID' => 'imgUploadPreview-favicon'])
                @if($errors->has('images.favicon'))
                    <div class="help-block">{{ $errors->first('images.favicon') }}</div>
                @endif
            </div>
        </div>

    </div>
</div>
