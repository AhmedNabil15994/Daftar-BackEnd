<div class="row">
    <div class="form-group">

        <select name="bulk_action" id="bulkActionsSelect">
            <option value="">
                --- {{ __('apps::dashboard.datatable.actions.bulk_actions') }}---
            </option>
            @permission('edit_delivery_status')
                <option value="edit_delivery_status">{{ __('apps::dashboard.datatable.actions.edit_delivery_status') }}
                </option>
            @endpermission
            <option value="print">{{ __('apps::dashboard.datatable.actions.print') }}</option>
            {{-- <option value="delete">{{__('apps::dashboard.datatable.actions.delete')}}</option> --}}
        </select>

        @permission('edit_delivery_status')
            <select name="delivery_status_id" id="deliveryStatusSelect" style="display: none;">
                <option value="">
                    --- {{ __('apps::dashboard.datatable.actions.choose_status') }}---
                </option>
                @foreach ($deliveryStatuses as $status)
                    <option value="{{ $status->id }}">
                        {{ $status->translate(locale())->title }}
                    </option>
                @endforeach
            </select>
        @endpermission

        <button type="button" class="btn btn-info btn-sm" onclick="onBulkActionsChange('{{ $printPage }}')">
            {{ __('apps::dashboard.datatable.actions.apply') }}
        </button>

        {{-- <button type="button" class="btn btn-info btn-sm"
                onclick="printAllChecked('{{ url(route('dashboard.orders.print_selected_items')) }}', 'orders')">
            {{__('apps::dashboard.datatable.print_all_btn')}}
        </button>

        <button type="submit" id="deleteChecked" class="btn red btn-sm"
                onclick="deleteAllChecked('{{ url(route('dashboard.orders.deletes')) }}')">
            {{__('apps::dashboard.datatable.delete_all_btn')}}
        </button> --}}

    </div>
</div>
