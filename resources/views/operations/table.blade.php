<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="table-responsive" style="margin: 0 15px 0 15px">
        <table class="table table-striped table-bordered" id="operations-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.type') </th>
                <th class="th_grid">@lang('models.module') </th>
                <th class="th_grid">@lang('models.level') </th>
                <th class="th_grid">@lang('models.action') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.local') </th>
                <th class="th_grid">@lang('models.writes_log') </th>
                <th class="th_grid">@lang('models.enabled') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($operations as $operation)
                <tr class="th_grid">
                    <td class="th_grid">{!! $operation->code !!}</td>
                    <td class="th_grid">{!! $operation->type !!}</td>
                    <td class="th_grid">{!! $operation->module !!}</td>
                    <td class="th_grid">{!! $operation->level !!}</td>
                    <td class="th_grid">{!! $operation->action !!}</td>
                    <td class="th_grid">{!! $operation->description !!}</td>
                    <td class="th_grid">{!! $operation->local !!}</td>
                    <td class="th_grid">{!! $operation->writes_log !!}</td>
                    <td class="th_grid">{!! $operation->enabled !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>