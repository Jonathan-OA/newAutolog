<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="documentts-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.company_id') </th>
        <th class="th_grid">@lang('models.number') </th>
        <th class="th_grid">@lang('models.customer_id') </th>
        <th class="th_grid">@lang('models.supplier_id') </th>
        <th class="th_grid">@lang('models.courier_id') </th>
        <th class="th_grid">@lang('models.invoice') </th>
        <th class="th_grid">@lang('models.serial_number') </th>
        <th class="th_grid">@lang('models.emission_date') </th>
        <th class="th_grid">@lang('models.start_date') </th>
        <th class="th_grid">@lang('models.end_date') </th>
        <th class="th_grid">@lang('models.wave') </th>
        <th class="th_grid">@lang('models.total_volumes') </th>
        <th class="th_grid">@lang('models.total_weight') </th>
        <th class="th_grid">@lang('models.document_status_id') </th>
        <th class="th_grid">@lang('models.total_net_weigth') </th>
        <th class="th_grid">@lang('models.driver_id') </th>
        <th class="th_grid">@lang('models.vehicle_id') </th>
        <th class="th_grid">@lang('models.priority') </th>
        <th class="th_grid">@lang('models.comments') </th>
        <th class="th_grid">@lang('models.document_type_code') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($documentts as $documentt)
                <tr>
                    <td>{!! $documentt->company_id !!}</td>
            <td>{!! $documentt->number !!}</td>
            <td>{!! $documentt->customer_id !!}</td>
            <td>{!! $documentt->supplier_id !!}</td>
            <td>{!! $documentt->courier_id !!}</td>
            <td>{!! $documentt->invoice !!}</td>
            <td>{!! $documentt->serial_number !!}</td>
            <td>{!! $documentt->emission_date !!}</td>
            <td>{!! $documentt->start_date !!}</td>
            <td>{!! $documentt->end_date !!}</td>
            <td>{!! $documentt->wave !!}</td>
            <td>{!! $documentt->total_volumes !!}</td>
            <td>{!! $documentt->total_weight !!}</td>
            <td>{!! $documentt->document_status_id !!}</td>
            <td>{!! $documentt->total_net_weigth !!}</td>
            <td>{!! $documentt->driver_id !!}</td>
            <td>{!! $documentt->vehicle_id !!}</td>
            <td>{!! $documentt->priority !!}</td>
            <td>{!! $documentt->comments !!}</td>
            <td>{!! $documentt->document_type_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>