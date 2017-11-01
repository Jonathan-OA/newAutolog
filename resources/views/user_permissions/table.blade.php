<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="userPermissions-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.user_type_code') </th>
        <th class="th_grid">@lang('models.operation_code') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($userPermissions as $userPermission)
                <tr>
                    <td>{!! $userPermission->user_type_code !!}</td>
            <td>{!! $userPermission->operation_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>