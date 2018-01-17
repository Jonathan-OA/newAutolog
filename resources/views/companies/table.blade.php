<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="companies-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.branch') </th>
                <th class="th_grid">@lang('models.name') </th>
                <th class="th_grid">@lang('models.cnpj') </th>
                <th class="th_grid">@lang('models.trading_name') </th>
                <th class="th_grid">@lang('models.address') </th>
                <th class="th_grid">@lang('models.number') </th>
                <th class="th_grid">@lang('models.neighbourhood') </th>
                <th class="th_grid">@lang('models.city') </th>
                <th class="th_grid">@lang('models.state') </th>
                <th class="th_grid">@lang('models.country') </th>
                <th class="th_grid">@lang('models.zip_code') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($companies as $company)
                <tr>
                    <td>{!! $company->code !!}</td>
                    <td>{!! $company->branch !!}</td>
                    <td>{!! $company->name !!}</td>
                    <td>{!! $company->cnpj !!}</td>
                    <td>{!! $company->trading_name !!}</td>
                    <td>{!! $company->address !!}</td>
                    <td>{!! $company->number !!}</td>
                    <td>{!! $company->neighbourhood !!}</td>
                    <td>{!! $company->city !!}</td>
                    <td>{!! $company->state !!}</td>
                    <td>{!! $company->country !!}</td>
                    <td>{!! $company->zip_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>