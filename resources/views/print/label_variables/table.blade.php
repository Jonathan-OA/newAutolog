<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="labelVariables-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.size') </th>
                <th class="th_grid">@lang('models.table') </th>
                <th class="th_grid">@lang('models.field') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($labelVariables as $labelVariable)
                <tr>
                    <td>{!! $labelVariable->code !!}</td>
                    <td>{!! $labelVariable->description !!}</td>
                    <td>{!! $labelVariable->size !!}</td>
                    <td>{!! $labelVariable->table !!}</td>
                    <td>{!! $labelVariable->field !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>