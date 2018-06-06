<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="allowedTransfers-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.orig_department_code') </th>
                <th class="th_grid">@lang('models.orig_deposit_code') </th>
                <th class="th_grid">@lang('models.dest_department_code') </th>
                <th class="th_grid">@lang('models.dest_deposit_code') </th>
                <th class="th_grid">@lang('models.operation_code') </th>
                <th class="th_grid">@lang('models.reset_stock') </th>
                <th class="th_grid">@lang('models.export_erp') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($allowedTransfers as $allowedTransfer)
                <tr>
                    <td>{!! $allowedTransfer->orig_department_code !!}</td>
                    <td>{!! $allowedTransfer->orig_deposit_code !!}</td>
                    <td>{!! $allowedTransfer->dest_department_code !!}</td>
                    <td>{!! $allowedTransfer->dest_deposit_code !!}</td>
                    <td>{!! $allowedTransfer->operation_code !!}</td>
                    <td>{!! $allowedTransfer->reset_stock !!}</td>
                    <td>{!! $allowedTransfer->export_erp !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>