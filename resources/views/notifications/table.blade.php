<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="notifications-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.message') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($notifications as $notification)
                <tr>
                    <td>{!! $notification->message !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>