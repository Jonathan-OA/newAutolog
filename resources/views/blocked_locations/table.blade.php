<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="blockedLocations-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.location_code') </th>
                <th class="th_grid">@lang('models.product_code') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($blockedLocations as $blockedLocation)
                <tr>
                    <td>{!! $blockedLocation->location_code !!}</td>
                    <td>{!! $blockedLocation->product_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>