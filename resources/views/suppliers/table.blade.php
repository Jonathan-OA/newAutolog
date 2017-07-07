<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="table-responsive" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="suppliers-table">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
        <th class="th_grid">@lang('models.company_id') </th>
        <th class="th_grid">@lang('models.name') </th>
        <th class="th_grid">@lang('models.trading_name') </th>
        <th class="th_grid">@lang('models.cnpj') </th>
        <th class="th_grid">@lang('models.state_registration') </th>
        <th class="th_grid">@lang('models.address') </th>
        <th class="th_grid">@lang('models.number') </th>
        <th class="th_grid">@lang('models.neighbourhood') </th>
        <th class="th_grid">@lang('models.city') </th>
        <th class="th_grid">@lang('models.state') </th>
        <th class="th_grid">@lang('models.country') </th>
        <th class="th_grid">@lang('models.zip_code') </th>
        <th class="th_grid">@lang('models.phone1') </th>
        <th class="th_grid">@lang('models.phone2') </th>
        <th class="th_grid">@lang('models.active') </th>
        <th class="th_grid">@lang('models.obs1') </th>
        <th class="th_grid">@lang('models.obs2') </th>
        <th class="th_grid">@lang('models.obs3') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($suppliers as $suppliers)
                <tr>
                    <td>{!! $suppliers->code !!}</td>
            <td>{!! $suppliers->company_id !!}</td>
            <td>{!! $suppliers->name !!}</td>
            <td>{!! $suppliers->trading_name !!}</td>
            <td>{!! $suppliers->cnpj !!}</td>
            <td>{!! $suppliers->state_registration !!}</td>
            <td>{!! $suppliers->address !!}</td>
            <td>{!! $suppliers->number !!}</td>
            <td>{!! $suppliers->neighbourhood !!}</td>
            <td>{!! $suppliers->city !!}</td>
            <td>{!! $suppliers->state !!}</td>
            <td>{!! $suppliers->country !!}</td>
            <td>{!! $suppliers->zip_code !!}</td>
            <td>{!! $suppliers->phone1 !!}</td>
            <td>{!! $suppliers->phone2 !!}</td>
            <td>{!! $suppliers->active !!}</td>
            <td>{!! $suppliers->obs1 !!}</td>
            <td>{!! $suppliers->obs2 !!}</td>
            <td>{!! $suppliers->obs3 !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>