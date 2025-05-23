<div class="row">
    <div class="col-md-6">
        <p class="form-row form-row-wide">
            <label>
                {{ __('catalog::frontend.address.form.email') }}
            </label>
            <input type="email" value="{{ old('email') }}" autocomplete="off" name="email" class="input-text @error('email') is-invalid @enderror">
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
            <input type="text" value="{{ old('username') }}" autocomplete="off" name="username" class="input-text @error('username') is-invalid @enderror">
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
            <input type="text" value="{{ old('mobile') }}" autocomplete="off" name="mobile" class="input-text @error('mobile') is-invalid @enderror">
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
            <select class="select-detail" name="state_id">
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
    <div class="col-md-6">
        <p class="form-row form-row-wide">
            <label>
                {{ __('catalog::frontend.address.form.address_details') }}
            </label>
            <textarea name="address" class="input-text @error('address') is-invalid @enderror" rows="8" cols="80">{{ old('address') }}</textarea>
            @error('address')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </p>
    </div>
</div>
