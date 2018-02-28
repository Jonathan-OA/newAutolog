<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="labels-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.barcode') </th>
                <th class="th_grid">@lang('models.item_code') </th>
                <th class="th_grid">@lang('models.qty') </th>
                <th class="th_grid">@lang('models.uom_code') </th>
                <th class="th_grid">@lang('models.prev_qty') </th>
                <th class="th_grid">@lang('models.prev_uom_code') </th>
                <th class="th_grid">@lang('models.document_id') </th>
                <th class="th_grid">@lang('models.document_item_id') </th>
                <th class="th_grid">@lang('models.origin') </th>
                <th class="th_grid">@lang('models.serial_number') </th>
                <th class="th_grid">@lang('models.batch') </th>
                <th class="th_grid">@lang('models.batch_supplier') </th>
                <th class="th_grid">@lang('models.prod_date') </th>
                <th class="th_grid">@lang('models.due_date') </th>
                <th class="th_grid">@lang('models.ripeness_date') </th>
                <th class="th_grid">@lang('models.critical_date1') </th>
                <th class="th_grid">@lang('models.critical_date2') </th>
                <th class="th_grid">@lang('models.critical_date3') </th>
                <th class="th_grid">@lang('models.label_status_id') </th>
                <th class="th_grid">@lang('models.level') </th>
                <th class="th_grid">@lang('models.travel_id') </th>
                <th class="th_grid">@lang('models.task_id') </th>
                <th class="th_grid">@lang('models.layout_code') </th>
                <th class="th_grid">@lang('models.weight') </th>
                <th class="th_grid">@lang('models.width') </th>
                <th class="th_grid">@lang('models.lenght') </th>
                <th class="th_grid">@lang('models.obs1') </th>
                <th class="th_grid">@lang('models.obs2') </th>
                <th class="th_grid">@lang('models.obs3') </th>
                <th class="th_grid">@lang('models.obs4') </th>
                <th class="th_grid">@lang('models.obs5') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($labels as $label)
                <tr>
                    <td>{!! $label->barcode !!}</td>
                    <td>{!! $label->item_code !!}</td>
                    <td>{!! $label->qty !!}</td>
                    <td>{!! $label->uom_code !!}</td>
                    <td>{!! $label->prev_qty !!}</td>
                    <td>{!! $label->prev_uom_code !!}</td>
                    <td>{!! $label->document_id !!}</td>
                    <td>{!! $label->document_item_id !!}</td>
                    <td>{!! $label->origin !!}</td>
                    <td>{!! $label->serial_number !!}</td>
                    <td>{!! $label->batch !!}</td>
                    <td>{!! $label->batch_supplier !!}</td>
                    <td>{!! $label->prod_date !!}</td>
                    <td>{!! $label->due_date !!}</td>
                    <td>{!! $label->ripeness_date !!}</td>
                    <td>{!! $label->critical_date1 !!}</td>
                    <td>{!! $label->critical_date2 !!}</td>
                    <td>{!! $label->critical_date3 !!}</td>
                    <td>{!! $label->label_status_id !!}</td>
                    <td>{!! $label->level !!}</td>
                    <td>{!! $label->travel_id !!}</td>
                    <td>{!! $label->task_id !!}</td>
                    <td>{!! $label->layout_code !!}</td>
                    <td>{!! $label->weight !!}</td>
                    <td>{!! $label->width !!}</td>
                    <td>{!! $label->lenght !!}</td>
                    <td>{!! $label->text1 !!}</td>
                    <td>{!! $label->text2 !!}</td>
                    <td>{!! $label->text3 !!}</td>
                    <td>{!! $label->text4 !!}</td>
                    <td>{!! $label->text5 !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>