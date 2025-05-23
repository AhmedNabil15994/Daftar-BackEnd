<div class="col-md-6">
    <p class="form-row">
        <label>
            {{ __('catalog::frontend.checkout.form.time') }}
            <span class="note-impor">*</span>
        </label>
        <select class="select-detail" name="time">
            <option value="">{{ __('catalog::frontend.checkout.form.time') }}</option>
            @foreach ($times as $time)
                <option
                    value="{{ $time->id }}" {{ !is_null(old('time')) ? (old('time') == $time->id ? 'selected' : '') : (strtotime($selectedTime) == strtotime($time->to) ? 'selected' : '') }}>
                    {{ date('H:i' , strtotime($time->from)) }} - {{ date('H:i' , strtotime($time->to)) }}
                </option>
            @endforeach
        </select>
    </p>
</div>
