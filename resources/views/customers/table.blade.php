<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-striped table-bordered" id="customers-table" cellspacing="0" width="100%">
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
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{!! $customer->code !!}</td>
                    <td>{!! $customer->company_id !!}</td>
                    <td>{!! $customer->name !!}</td>
                    <td>{!! $customer->trading_name !!}</td>
                    <td>{!! $customer->cnpj !!}</td>
                    <td>{!! $customer->state_registration !!}</td>
                    <td>{!! $customer->address !!}</td>
                    <td>{!! $customer->number !!}</td>
                    <td>{!! $customer->neighbourhood !!}</td>
                    <td>{!! $customer->city !!}</td>
                    <td>{!! $customer->state !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>