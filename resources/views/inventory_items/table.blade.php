<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="inventoryItems-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.company_id') </th>
        <th class="th_grid">@lang('models.document_id') </th>
        <th class="th_grid">@lang('models.product_code') </th>
        <th class="th_grid">@lang('models.pallet_id') </th>
        <th class="th_grid">@lang('models.label_id') </th>
        <th class="th_grid">@lang('models.location_code') </th>
        <th class="th_grid">@lang('models.qty_wms') </th>
        <th class="th_grid">@lang('models.inventory_status_id') </th>
        <th class="th_grid">@lang('models.qty_1count') </th>
        <th class="th_grid">@lang('models.user_1count') </th>
        <th class="th_grid">@lang('models.date_1count') </th>
        <th class="th_grid">@lang('models.qty_2count') </th>
        <th class="th_grid">@lang('models.user_2count') </th>
        <th class="th_grid">@lang('models.date_2count') </th>
        <th class="th_grid">@lang('models.qty_3count') </th>
        <th class="th_grid">@lang('models.user_3count') </th>
        <th class="th_grid">@lang('models.date_3count') </th>
        <th class="th_grid">@lang('models.qty_4count') </th>
        <th class="th_grid">@lang('models.user_4count') </th>
        <th class="th_grid">@lang('models.date_4count') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($inventoryItems as $inventoryItem)
                <tr>
                    <td>{!! $inventoryItem->company_id !!}</td>
            <td>{!! $inventoryItem->document_id !!}</td>
            <td>{!! $inventoryItem->product_code !!}</td>
            <td>{!! $inventoryItem->pallet_id !!}</td>
            <td>{!! $inventoryItem->label_id !!}</td>
            <td>{!! $inventoryItem->location_code !!}</td>
            <td>{!! $inventoryItem->qty_wms !!}</td>
            <td>{!! $inventoryItem->inventory_status_id !!}</td>
            <td>{!! $inventoryItem->qty_1count !!}</td>
            <td>{!! $inventoryItem->user_1count !!}</td>
            <td>{!! $inventoryItem->date_1count !!}</td>
            <td>{!! $inventoryItem->qty_2count !!}</td>
            <td>{!! $inventoryItem->user_2count !!}</td>
            <td>{!! $inventoryItem->date_2count !!}</td>
            <td>{!! $inventoryItem->qty_3count !!}</td>
            <td>{!! $inventoryItem->user_3count !!}</td>
            <td>{!! $inventoryItem->date_3count !!}</td>
            <td>{!! $inventoryItem->qty_4count !!}</td>
            <td>{!! $inventoryItem->user_4count !!}</td>
            <td>{!! $inventoryItem->date_4count !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>