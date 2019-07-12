<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="notifications-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.user_id') </th>
        <th class="th_grid">@lang('models.message') </th>
        <th class="th_grid">@lang('models.visualized') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($notifications as $notification)
                <tr>
                    <td>{!! $notification->user_id !!}</td>
            <td>{!! $notification->message !!}</td>
            <td>{!! $notification->visualized !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>