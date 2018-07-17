<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="logs-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.user_code') </th>
                <th class="th_grid">@lang('models.operation_code') </th>
                <th class="th_grid">@lang('models.created_at')</th>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{!! $log->description !!}</td>
                    <td>{!! $log->user_id !!}</td>
                    <td>{!! $log->operation_code !!}</td>
                    <td>{!! $log->created_at !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>