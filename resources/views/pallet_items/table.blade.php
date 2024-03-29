<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered  table-striped" id="palletItems-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.pallet_id') </th>
                <th class="th_grid">@lang('models.product_code') </th>
                <th class="th_grid">@lang('models.qty') </th>
                <th class="th_grid">@lang('models.uom_code') </th>
                <th class="th_grid">@lang('models.prim_qty') </th>
                <th class="th_grid">@lang('models.prim_uom_code') </th>
                <th class="th_grid">@lang('models.label_id') </th>
                <th class="th_grid">@lang('models.status') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($palletItems as $palletItem)
                <tr>
                    <td>{!! $palletItem->pallet_id !!}</td>
                    <td>{!! $palletItem->product_code !!}</td>
                    <td>{!! $palletItem->qty !!}</td>
                    <td>{!! $palletItem->uom_code !!}</td>
                    <td>{!! $palletItem->prim_qty !!}</td>
                    <td>{!! $palletItem->prim_uom_code !!}</td>
                    <td>{!! $palletItem->label_id !!}</td>
                    <td>{!! $palletItem->pallet_status_id !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>