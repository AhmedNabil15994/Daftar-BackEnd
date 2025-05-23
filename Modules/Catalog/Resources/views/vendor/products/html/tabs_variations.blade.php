<div class="portlet-body">
    <div class="table-container">
        <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
            <thead>
            <tr role="row" class="heading">
                <th width="15%"> #</th>
                <th width="15%"> Price</th>
                <th width="200"> Qty</th>
                <th width="200"> Status</th>
                <th width="10%"> SKU</th>
                <th width="10%"> Image</th>
                <th width="10%"> Delete</th>
            </tr>
            </thead>
            <tbody>
            <input type="hidden" name="removed_variants" value="">
            @foreach ($product->variants as $key => $data)
                <tr role="row" class="filter">
                    <input type="hidden" name="variants_ids[]" value="{{ $data->id }}">
                    <td>
                        @foreach ($data->productValues as $key2 => $value)
                            <input type="hidden" name="option_values_id[{{ $key }}][]"
                                   value="{{ $value->optionValue->id }}">
                            {{$value->optionValue->option->translate(locale())->title}} :
                            {{$value->optionValue->translate(locale())->title}}
                            @if(!$loop->last)
                                <br>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <input type="text" class="form-control form-filter input-sm" name="variation_price[]"
                               value="{{ $data->price }}">
                    </td>
                    <td>
                        <input type="text" class="form-control form-filter input-sm" name="variation_qty[]"
                               value="{{ $data->qty }}">
                    </td>
                    <td>
                        <select name="variation_status[]" class="form-control form-filter input-sm">
                            <option value="">Select</option>
                            <option value="1" {{ $data->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $data->status ? '' : 'selected' }}>Unactive</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control form-filter input-sm" name="variation_sku[]"
                               value="{{ $data->sku }}">
                    </td>
                    <td>
                        <input type="hidden" name="_v_images_hidden[{{ $data['id'] }}]" value="{{ $data->image }}">
                        <input type="file" class="form-control form-filter input-sm" name="_v_images[{{ $data['id'] }}]"
                               onchange="readURL(this, '_vImgUploadPreview-{{$data['id']}}', 'single');">
                        <img id='_vImgUploadPreview-{{$data['id']}}'
                             style="{{ is_null($data->image) ? 'display: none;' : '' }} height: 100px; width: 100%;"
                             src="{{ $data->image ? url($data->image) : '' }}"
                             class="img-preview img-thumbnail"
                             alt="image preview"/>

                        {{--<span class="holder" style="margin-top:15px;max-height:100px;">
                          <img src="{{ $data->image ? url($data->image) : '' }}" alt="" style="width:65%">
                        </span>--}}
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm red btn-outline variants-delete">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
