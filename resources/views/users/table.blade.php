<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="users-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.name') </th>
                <th class="th_grid">@lang('models.email') </th>
                <th class="th_grid">@lang('models.user_type_code') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{!! $user->code !!}</td>
                    <td>{!! $user->name !!}</td>
                    <td>{!! $user->email !!}</td>
                    <td>{!! $user->user_type_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>