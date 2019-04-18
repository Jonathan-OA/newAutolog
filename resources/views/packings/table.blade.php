<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered  table-striped" id="packings-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.level') </th>
                <th class="th_grid">@lang('models.product_code') </th>
                <th class="th_grid">@lang('models.uom_code') </th>
                <th class="th_grid">@lang('models.barcode') </th>
                <th class="th_grid">@lang('models.prev_qty') </th>
                <th class="th_grid">@lang('models.conf_batch') </th>
                <th class="th_grid">@lang('models.conf_serial') </th>
                <th class="th_grid">@lang('models.conf_batch_supplier') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($packings as $packing)
                <tr>
                    <td>{!! $packing->company_id !!}</td>
                    <td>{!! $packing->level !!}</td>
                    <td>{!! $packing->product_code !!}</td>
                    <td>{!! $packing->uom_code !!}</td>
                    <td>{!! $packing->barcode !!}</td>
                    <td>{!! $packing->prev_qty !!}</td>
                    <td>{!! $packing->conf_batch !!}</td>
                    <td>{!! $packing->conf_serial !!}</td>
                    <td>{!! $packing->conf_batch_supplier !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>