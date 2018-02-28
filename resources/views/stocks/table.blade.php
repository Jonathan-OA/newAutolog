<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="stocks-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.product_code') </th>
                <th class="th_grid">@lang('models.label_id') </th>
                <th class="th_grid">@lang('models.location_code') </th>
                <th class="th_grid">@lang('models.qty') </th>
                <th class="th_grid">@lang('models.uom_code') </th>
                <th class="th_grid">@lang('models.prev_qty') </th>
                <th class="th_grid">@lang('models.prev_uom_code') </th>
                <th class="th_grid">@lang('models.pallet_id') </th>
                <th class="th_grid">@lang('models.document_id') </th>
                <th class="th_grid">@lang('models.document_item_id') </th>
                <th class="th_grid">@lang('models.task_id') </th>
                <th class="th_grid">@lang('models.finality_code') </th>
                <th class="th_grid">@lang('models.user_id') </th>
                <th class="th_grid">@lang('models.operation_code') </th>
                <th class="th_grid">@lang('models.volume_id') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($stocks as $stock)
                <tr>
                    <td>{!! $stock->product_code !!}</td>
                    <td>{!! $stock->label_id !!}</td>
                    <td>{!! $stock->location_code !!}</td>
                    <td>{!! $stock->qty !!}</td>
                    <td>{!! $stock->uom_code !!}</td>
                    <td>{!! $stock->prev_qty !!}</td>
                    <td>{!! $stock->prev_uom_code !!}</td>
                    <td>{!! $stock->pallet_id !!}</td>
                    <td>{!! $stock->document_id !!}</td>
                    <td>{!! $stock->document_item_id !!}</td>
                    <td>{!! $stock->task_id !!}</td>
                    <td>{!! $stock->finality_code !!}</td>
                    <td>{!! $stock->user_id !!}</td>
                    <td>{!! $stock->operation_code !!}</td>
                    <td>{!! $stock->volume_id !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>