<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="locationTypes-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.capacity_kg') </th>
                <th class="th_grid">@lang('models.capacity_m3') </th>
                <th class="th_grid">@lang('models.capacity_qty') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($locationTypes as $locationType)
                <tr>
                    <td>{!! $locationType->code !!}</td>
                    <td>{!! $locationType->description !!}</td>
                    <td>{!! $locationType->capacity_kg !!}</td>
                    <td>{!! $locationType->capacity_m3 !!}</td>
                    <td>{!! $locationType->capacity_qty !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>