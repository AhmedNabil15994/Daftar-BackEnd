<div class="title-wi_btn">
    <button type="button" class="btn main-btn" data-toggle="modal" data-target="#exampleModalLong">
        {{ __('catalog::frontend.address.btn.add_modal') }}
    </button>
</div>
<br>
@foreach ($addresses as $address)
<div class="form-row choose-add-box">
    <div class="checkboxes radios">
        <input id="add-{{ $address->id }}" type="radio" name="address" value="{{ $address->id }}">
        <label for="add-{{ $address->id }}">
            <div class="address-item">
                <div class="row address-option-row">
                    <div class="col-md-4 filed-title">
                        {{ __('catalog::frontend.address.list.state') }}
                    </div>
                    <div class="col-md-8 color-brown">{{$address->state->translate(locale())->title}}</div>
                </div>
                <div class="row address-option-row">
                    <div class="col-md-4 filed-title">
                        {{ __('catalog::frontend.address.list.street') }}
                    </div>
                    <div class="col-md-8">{{$address->street}}</div>
                </div>
                <div class="row address-option-row">
                    <div class="col-md-4 filed-title">
                        {{ __('catalog::frontend.address.list.block') }}
                    </div>
                    <div class="col-md-8">{{$address->block}} </div>
                </div>
                <div class="row address-option-row">
                    <div class="col-md-4 filed-title">
                        {{ __('catalog::frontend.address.list.mobile') }}
                    </div>
                    <div class="col-md-8">{{$address->mobile}} </div>
                </div>
                <div class="row address-option-row">
                    <div class="col-md-4 filed-title">
                        {{ __('catalog::frontend.address.list.address_details') }}
                    </div>
                    <div class="col-md-8">{{$address->address}} </div>
                </div>
            </div>
        </label>
    </div>
</div>
@endforeach
