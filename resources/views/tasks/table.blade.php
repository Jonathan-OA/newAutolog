<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="tasks-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.operation_code') </th>
                <th class="th_grid">@lang('models.start_date') </th>
                <th class="th_grid">@lang('models.end_date') </th>
                <th class="th_grid">@lang('models.orig_location_code') </th>
                <th class="th_grid">@lang('models.dest_location_code') </th>
                <th class="th_grid">@lang('models.task_status_id') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{!! $task->operation_code !!}</td>
                    <td>{!! $task->start_date !!}</td>
                    <td>{!! $task->end_date !!}</td>
                    <td>{!! $task->orig_location_code !!}</td>
                    <td>{!! $task->dest_location_code !!}</td>
                    <td>{!! $task->task_status_id !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>