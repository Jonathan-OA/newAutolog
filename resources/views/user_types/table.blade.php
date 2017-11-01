<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="userTypes-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.active') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($userTypes as $userType)
                <tr>
                    <td>{!! $userType->code !!}</td>
                    <td>{!! $userType->description !!}</td>
                    <td>{!! $userType->active !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>