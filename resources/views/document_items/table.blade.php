<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="documentItems-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.product_code') </th>
                <th class="th_grid">@lang('models.qty') </th>
                <th class="th_grid">@lang('models.uom_code') </th>
                <th class="th_grid">@lang('models.document_status_id') </th>
                <th class="th_grid">@lang('models.batch') </th>
                <th class="th_grid">@lang('models.qty_conf') </th>
                <th class="th_grid">@lang('models.qty_ship') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($documentItems as $documentItem)
                <tr>
                    <td>{!! $documentItem->product_code !!}</td>
                    <td>{!! $documentItem->qty !!}</td>
                    <td>{!! $documentItem->uom_code !!}</td>
                    <td>{!! $documentItem->document_status_id !!}</td>
                    <td>{!! $documentItem->batch !!}</td>
                    <td>{!! $documentItem->qty_conf !!}</td>
                    <td>{!! $documentItem->qty_ship !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>