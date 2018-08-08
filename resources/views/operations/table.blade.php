<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-striped table-bordered" id="operations-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.type') </th>
                <th class="th_grid">@lang('models.module') </th>
                <th class="th_grid">@lang('models.level') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.writes_log') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($operations as $operation)
                <tr >
                    <td >{!! $operation->code !!}</td>
                    <td >{!! $operation->type !!}</td>
                    <td >{!! $operation->module_name !!}</td>
                    <td >{!! $operation->level !!}</td>
                    <td >{!! $operation->description !!}</td>
                    <td >{!! $operation->writes_log !!}</td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>