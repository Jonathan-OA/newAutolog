<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="liberationItems-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.company_id') </th>
        <th class="th_grid">@lang('models.document_id') </th>
        <th class="th_grid">@lang('models.document_item_id') </th>
        <th class="th_grid">@lang('models.product_code') </th>
        <th class="th_grid">@lang('models.pallet_id') </th>
        <th class="th_grid">@lang('models.label_id') </th>
        <th class="th_grid">@lang('models.qty') </th>
        <th class="th_grid">@lang('models.liberation_status_id') </th>
        <th class="th_grid">@lang('models.orig_location_code') </th>
        <th class="th_grid">@lang('models.dest_location_code') </th>
        <th class="th_grid">@lang('models.task_id') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($liberationItems as $liberationItem)
                <tr>
                    <td>{!! $liberationItem->company_id !!}</td>
                    <td>{!! $liberationItem->document_id !!}</td>
                    <td>{!! $liberationItem->document_item_id !!}</td>
                    <td>{!! $liberationItem->product_code !!}</td>
                    <td>{!! $liberationItem->pallet_id !!}</td>
                    <td>{!! $liberationItem->label_id !!}</td>
                    <td>{!! $liberationItem->qty !!}</td>
                    <td>{!! $liberationItem->liberation_status_id !!}</td>
                    <td>{!! $liberationItem->orig_location_code !!}</td>
                    <td>{!! $liberationItem->dest_location_code !!}</td>
                    <td>{!! $liberationItem->task_id !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>