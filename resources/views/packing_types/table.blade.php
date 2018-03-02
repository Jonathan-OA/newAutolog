<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="packingTypes-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.tare') </th>
                <th class="th_grid">@lang('models.capacity_kg') </th>
                <th class="th_grid">@lang('models.capacity_m3') </th>
                <th class="th_grid">@lang('models.capacity_un') </th>
                <th class="th_grid">@lang('models.height') </th>
                <th class="th_grid">@lang('models.width') </th>
                <th class="th_grid">@lang('models.lenght') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($packingTypes as $packingType)
                <tr>
                    <td>{!! $packingType->code !!}</td>
                    <td>{!! $packingType->description !!}</td>
                    <td>{!! $packingType->tare !!}</td>
                    <td>{!! $packingType->capacity_kg !!}</td>
                    <td>{!! $packingType->capacity_m3 !!}</td>
                    <td>{!! $packingType->capacity_un !!}</td>
                    <td>{!! $packingType->height !!}</td>
                    <td>{!! $packingType->width !!}</td>
                    <td>{!! $packingType->lenght !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>