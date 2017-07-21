<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="table-responsive" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="parameters-table">
            <thead>
                <th class="th_grid">@lang('models.company_id') </th>
        <th class="th_grid">@lang('models.code') </th>
        <th class="th_grid">@lang('models.description') </th>
        <th class="th_grid">@lang('models.value') </th>
        <th class="th_grid">@lang('models.def_value') </th>
        <th class="th_grid">@lang('models.module_name') </th>
        <th class="th_grid">@lang('models.operation_code') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($parameters as $parameters)
                <tr>
                    <td>{!! $parameters->company_id !!}</td>
            <td>{!! $parameters->code !!}</td>
            <td>{!! $parameters->description !!}</td>
            <td>{!! $parameters->value !!}</td>
            <td>{!! $parameters->def_value !!}</td>
            <td>{!! $parameters->module_name !!}</td>
            <td>{!! $parameters->operation_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>