<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="locations-table" cellspacing="0" width="100%">
            <thead>
                 <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.barcode') </th>
                <th class="th_grid">@lang('models.department_code') </th>
                <th class="th_grid">@lang('models.deposit_code') </th>
                <th class="th_grid">@lang('models.sector_code') </th>
                <th class="th_grid">@lang('models.location_type_code') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($locations as $location)
                <tr>
                    <td>{!! $location->code !!}</td>
                    <td>{!! $location->barcode !!}</td>
                    <td>{!! $location->department_code !!}</td>
                    <td>{!! $location->deposit_code !!}</td>
                    <td>{!! $location->sector_code !!}</td>
                    <td>{!! $location->location_type_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>