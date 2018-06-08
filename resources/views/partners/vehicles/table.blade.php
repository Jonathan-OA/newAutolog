<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="vehicles-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.company_id') </th>
        <th class="th_grid">@lang('models.courier_id') </th>
        <th class="th_grid">@lang('models.vehicle_type_id') </th>
        <th class="th_grid">@lang('models.number_plate') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($vehicles as $vehicle)
                <tr>
                    <td>{!! $vehicle->company_id !!}</td>
            <td>{!! $vehicle->courier_id !!}</td>
            <td>{!! $vehicle->vehicle_type_id !!}</td>
            <td>{!! $vehicle->number_plate !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>