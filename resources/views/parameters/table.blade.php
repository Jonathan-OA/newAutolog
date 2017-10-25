<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="parameters-table" cellspacing="0" width="100%">
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
            @foreach($parameters as $parameter)
                <tr>
                    <td>{!! $parameter->company_id !!}</td>
                    <td>{!! $parameter->code !!}</td>
                    <td>{!! $parameter->description !!}</td>
                    <td>{!! $parameter->value !!}</td>
                    <td>{!! $parameter->def_value !!}</td>
                    <td>{!! $parameter->module_name !!}</td>
                    <td>{!! $parameter->operation_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>