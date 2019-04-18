<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered  table-striped" id="groups-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.product_type_code') </th>
                <th class="th_grid">@lang('models.label_type_code') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($groups as $group)
                <tr>
                    <td>{!! $group->code !!}</td>
                    <td>{!! $group->description !!}</td>
                    <td>{!! $group->product_type_code !!}</td>
                    <td>{!! $group->label_type_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>