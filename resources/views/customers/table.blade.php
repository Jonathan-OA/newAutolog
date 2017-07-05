<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="table-responsive" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="customers-table">
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
            @foreach($customers as $customers)
                <tr>
                    <td>{!! $customers->code !!}</td>
            <td>{!! $customers->company_id !!}</td>
            <td>{!! $customers->name !!}</td>
            <td>{!! $customers->trading_name !!}</td>
            <td>{!! $customers->cnpj !!}</td>
            <td>{!! $customers->state_registration !!}</td>
            <td>{!! $customers->address !!}</td>
            <td>{!! $customers->number !!}</td>
            <td>{!! $customers->neighbourhood !!}</td>
            <td>{!! $customers->city !!}</td>
            <td>{!! $customers->state !!}</td>
            <td>{!! $customers->country !!}</td>
            <td>{!! $customers->zip_code !!}</td>
            <td>{!! $customers->phone1 !!}</td>
            <td>{!! $customers->phone2 !!}</td>
            <td>{!! $customers->active !!}</td>
            <td>{!! $customers->obs1 !!}</td>
            <td>{!! $customers->obs2 !!}</td>
            <td>{!! $customers->obs3 !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>