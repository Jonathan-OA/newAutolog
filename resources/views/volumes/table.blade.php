<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="volumes-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.barcode') </th>
                <th class="th_grid">@lang('models.location_code') </th>
                <th class="th_grid">@lang('models.packing_type_code') </th>
                <th class="th_grid">@lang('models.volume_status_id') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($volumes as $volume)
                <tr>
                    <td>{!! $volume->barcode !!}</td>
                    <td>{!! $volume->location_code !!}</td>
                    <td>{!! $volume->packing_type_code !!}</td>
                    <td>{!! $volume->volume_status_id !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>