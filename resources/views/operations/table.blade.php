<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="table-responsive" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="operations-table">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
        <th class="th_grid">@lang('models.type') </th>
        <th class="th_grid">@lang('models.module') </th>
        <th class="th_grid">@lang('models.level') </th>
        <th class="th_grid">@lang('models.action') </th>
        <th class="th_grid">@lang('models.description') </th>
        <th class="th_grid">@lang('models.local') </th>
        <th class="th_grid">@lang('models.writes_log') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($operations as $operations)
                <tr>
                    <td>{!! $operations->code !!}</td>
            <td>{!! $operations->type !!}</td>
            <td>{!! $operations->module !!}</td>
            <td>{!! $operations->level !!}</td>
            <td>{!! $operations->action !!}</td>
            <td>{!! $operations->description !!}</td>
            <td>{!! $operations->local !!}</td>
            <td>{!! $operations->writes_log !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>