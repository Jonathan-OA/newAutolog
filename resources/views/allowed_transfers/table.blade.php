<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="allowedTransfers-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.company_id') </th>
        <th class="th_grid">@lang('models.source_department_code') </th>
        <th class="th_grid">@lang('models.source_deposit_code') </th>
        <th class="th_grid">@lang('models.dest_department_code') </th>
        <th class="th_grid">@lang('models.dest_deposit_code') </th>
        <th class="th_grid">@lang('models.operation_code') </th>
        <th class="th_grid">@lang('models.document_type_code') </th>
        <th class="th_grid">@lang('models.reset_stock') </th>
        <th class="th_grid">@lang('models.export_erp') </th>
        <th class="th_grid">@lang('models.operation_erp') </th>
        <th class="th_grid">@lang('models.cost_center') </th>
        <th class="th_grid">@lang('models.logical_deposit') </th>
        <th class="th_grid">@lang('models.enabled') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($allowedTransfers as $allowedTransfer)
                <tr>
                    <td>{!! $allowedTransfer->company_id !!}</td>
            <td>{!! $allowedTransfer->source_department_code !!}</td>
            <td>{!! $allowedTransfer->source_deposit_code !!}</td>
            <td>{!! $allowedTransfer->dest_department_code !!}</td>
            <td>{!! $allowedTransfer->dest_deposit_code !!}</td>
            <td>{!! $allowedTransfer->operation_code !!}</td>
            <td>{!! $allowedTransfer->document_type_code !!}</td>
            <td>{!! $allowedTransfer->reset_stock !!}</td>
            <td>{!! $allowedTransfer->export_erp !!}</td>
            <td>{!! $allowedTransfer->operation_erp !!}</td>
            <td>{!! $allowedTransfer->cost_center !!}</td>
            <td>{!! $allowedTransfer->logical_deposit !!}</td>
            <td>{!! $allowedTransfer->enabled !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>