<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="pallets-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.barcode') </th>
                <th class="th_grid">@lang('models.location_code') </th>
                <th class="th_grid">@lang('models.packing_type_code') </th>
                <th class="th_grid">@lang('models.status') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($pallets as $pallet)
                <tr>
                    <td>{!! $pallet->barcode !!}</td>
                    <td>{!! $pallet->location_code !!}</td>
                    <td>{!! $pallet->packing_type_code !!}</td>
                    <td>{!! $pallet->status !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>