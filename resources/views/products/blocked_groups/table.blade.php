<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="blockedGroups-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.deposit_code') </th>
                <th class="th_grid">@lang('models.sector_code') </th>
                <th class="th_grid">@lang('models.group_code') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($blockedGroups as $blockedGroup)
                <tr>
                    <td>{!! $blockedGroup->deposit_code !!}</td>
                    <td>{!! $blockedGroup->sector_code !!}</td>
                    <td>{!! $blockedGroup->group_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>