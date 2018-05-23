<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="volumeItems-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.company_id') </th>
        <th class="th_grid">@lang('models.volume_id') </th>
        <th class="th_grid">@lang('models.product_code') </th>
        <th class="th_grid">@lang('models.qty') </th>
        <th class="th_grid">@lang('models.uom_code') </th>
        <th class="th_grid">@lang('models.prim_qty') </th>
        <th class="th_grid">@lang('models.prim_uom_code') </th>
        <th class="th_grid">@lang('models.label_id') </th>
        <th class="th_grid">@lang('models.activity_id') </th>
        <th class="th_grid">@lang('models.status') </th>
        <th class="th_grid">@lang('models.turn') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($volumeItems as $volumeItem)
                <tr>
                    <td>{!! $volumeItem->company_id !!}</td>
            <td>{!! $volumeItem->volume_id !!}</td>
            <td>{!! $volumeItem->product_code !!}</td>
            <td>{!! $volumeItem->qty !!}</td>
            <td>{!! $volumeItem->uom_code !!}</td>
            <td>{!! $volumeItem->prim_qty !!}</td>
            <td>{!! $volumeItem->prim_uom_code !!}</td>
            <td>{!! $volumeItem->label_id !!}</td>
            <td>{!! $volumeItem->activity_id !!}</td>
            <td>{!! $volumeItem->status !!}</td>
            <td>{!! $volumeItem->turn !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>