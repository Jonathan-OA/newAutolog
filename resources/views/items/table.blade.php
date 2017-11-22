<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="items-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.company_id') </th>
        <th class="th_grid">@lang('models.code') </th>
        <th class="th_grid">@lang('models.description') </th>
        <th class="th_grid">@lang('models.status') </th>
        <th class="th_grid">@lang('models.item_type_code') </th>
        <th class="th_grid">@lang('models.group_code') </th>
        <th class="th_grid">@lang('models.subgroup_code') </th>
        <th class="th_grid">@lang('models.margin_div') </th>
        <th class="th_grid">@lang('models.cost') </th>
        <th class="th_grid">@lang('models.phase_code') </th>
        <th class="th_grid">@lang('models.abz_code') </th>
        <th class="th_grid">@lang('models.inventory_date') </th>
        <th class="th_grid">@lang('models.due_date') </th>
        <th class="th_grid">@lang('models.critical_date1') </th>
        <th class="th_grid">@lang('models.critical_date2') </th>
        <th class="th_grid">@lang('models.critical_date3') </th>
        <th class="th_grid">@lang('models.ripeness_date') </th>
        <th class="th_grid">@lang('models.obs1') </th>
        <th class="th_grid">@lang('models.obs2') </th>
        <th class="th_grid">@lang('models.obs3') </th>
        <th class="th_grid">@lang('models.obs4') </th>
        <th class="th_grid">@lang('models.obs5') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{!! $item->company_id !!}</td>
            <td>{!! $item->code !!}</td>
            <td>{!! $item->description !!}</td>
            <td>{!! $item->status !!}</td>
            <td>{!! $item->item_type_code !!}</td>
            <td>{!! $item->group_code !!}</td>
            <td>{!! $item->subgroup_code !!}</td>
            <td>{!! $item->margin_div !!}</td>
            <td>{!! $item->cost !!}</td>
            <td>{!! $item->phase_code !!}</td>
            <td>{!! $item->abz_code !!}</td>
            <td>{!! $item->inventory_date !!}</td>
            <td>{!! $item->due_date !!}</td>
            <td>{!! $item->critical_date1 !!}</td>
            <td>{!! $item->critical_date2 !!}</td>
            <td>{!! $item->critical_date3 !!}</td>
            <td>{!! $item->ripeness_date !!}</td>
            <td>{!! $item->obs1 !!}</td>
            <td>{!! $item->obs2 !!}</td>
            <td>{!! $item->obs3 !!}</td>
            <td>{!! $item->obs4 !!}</td>
            <td>{!! $item->obs5 !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>