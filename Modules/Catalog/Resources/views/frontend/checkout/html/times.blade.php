<div class="col-md-6">
    <p class="form-row">
        <label>
            {{ __('catalog::frontend.checkout.form.time') }}
            <span class="note-impor">*</span>
        </label>
        <select class="select-detail" name="time">
            <option value="">{{ __('catalog::frontend.checkout.form.time') }}</option>
            @foreach ($times as $time)
                <option value="{{ $time['time_from'] . ' - ' . $time['time_to'] }}"
                    {{ !is_null(old('time')) ? (old('time') == $time['time_from'] . ' - ' . $time['time_to'] ? 'selected' : '') : (strtotime($selectedTime) == strtotime($time['time_to']) ? 'selected' : '') }}>
                    {{ __('catalog::frontend.checkout.form.time_from') . ' ' . $time['time_from'] . ' ' . __('catalog::frontend.checkout.form.time_to') . ' ' . $time['time_to'] }}
                </option>
            @endforeach
        </select>
    </p>
</div>
