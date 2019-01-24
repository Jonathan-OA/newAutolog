<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="labels-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.barcode') </th>
                <th class="th_grid">@lang('models.product_code') </th>
                <th class="th_grid">@lang('models.prev_qty') </th>
                <th class="th_grid">@lang('models.prev_uom_code') </th>
                <th class="th_grid">@lang('models.batch') </th>
                <th class="th_grid">@lang('models.batch_supplier') </th>
                <th class="th_grid">@lang('models.label_status_id') </th>
                <th class="th_grid">@lang('models.due_date') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($labels as $label)
                <tr>
                    <td>{!! $label->barcode !!}</td>
                    <td>{!! $label->product_code !!}</td>
                    <td>{!! $label->prev_qty !!}</td>
                    <td>{!! $label->prev_uom_code !!}</td>
                    <td>{!! $label->batch !!}</td>
                    <td>{!! $label->batch_supplier !!}</td>
                    <td>{!! $label->label_status_id !!}</td>
                    <td>{!! $label->due_date !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>