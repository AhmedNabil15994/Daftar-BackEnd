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
            @foreach ($res as $key2 => $value2)

                @if (is_array($value2))
                    <tr role="row" class="filter">
                        <td>
                            @foreach ($value2 as $optionValue)
                                <input type="hidden" name="option_values_id[{{ $key2 }}][]" value="{{ $optionValue }}">
                                {{ $optionValues->findOptionValueById($optionValue)->option->translate(locale())->title }}
                                :
                                {{ $optionValues->findOptionValueById($optionValue)->translate(locale())->title }}
                                @if (!$loop->last)
                                    <br>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <input type="text" class="form-control form-filter input-sm" name="variation_price[]">
                        </td>
                        <td>
                            <input type="text" class="form-control form-filter input-sm" name="variation_qty[]">
                        </td>
                        <td>
                            <select name="variation_status[]" class="form-control form-filter input-sm">
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="0">Unactive</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control form-filter input-sm" name="variation_sku[]">
                        </td>
                        <td>
                            <input type="file" class="form-control form-filter input-sm" name="v_images[]"
                                   onchange="readURL(this, 'vImgUploadPreview-{{$key2}}', 'single');">
                            <img id='vImgUploadPreview-{{$key2}}'
                                 style="display: none; height: 100px; width: 100%;"
                                 src="#"
                                 class="img-preview img-thumbnail"
                                 alt="image preview"/>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm red btn-outline variants-delete">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>
                @else
                    <tr role="row" class="filter">
                        <td>
                            <input type="hidden" name="option_values_id[{{ $key2 }}][]" value="{{ $value2 }}">
                            {{ $optionValues->findOptionValueById($value2)->option->translate(locale())->title }} :
                            {{ $optionValues->findOptionValueById($value2)->translate(locale())->title }}
                        </td>
                        <td>
                            <input type="text" class="form-control form-filter input-sm" name="variation_price[]">
                        </td>
                        <td>
                            <input type="text" class="form-control form-filter input-sm" name="variation_qty[]">
                        </td>
                        <td>
                            <select name="variation_status[]" class="form-control form-filter input-sm">
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="0">Unactive</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control form-filter input-sm" name="variation_sku[]">
                        </td>
                        <td>
                            <input type="file" class="form-control form-filter input-sm" name="v_images[]"
                                   onchange="readURL(this, 'vImgUploadPreview-{{$key2}}', 'single');">
                            <img id='vImgUploadPreview-{{$key2}}'
                                 style="display: none; height: 100px; width: 100%;"
                                 src="#"
                                 class="img-preview img-thumbnail"
                                 alt="image preview"/>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm red btn-outline variants-delete">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>
                @endif

            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $('.lfm').filemanager('image');

    $('.variants-delete').click(function () {
        $(this).closest('.filter').remove();
    });
</script>
