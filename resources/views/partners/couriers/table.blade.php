<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered  table-striped" id="couriers-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.name') </th>
                <th class="th_grid">@lang('models.trading_name') </th>
                <th class="th_grid">@lang('models.cnpj') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($couriers as $courier)
                <tr>
                    <td>{!! $courier->code !!}</td>
                    <td>{!! $courier->name !!}</td>
                    <td>{!! $courier->trading_name !!}</td>
                    <td>{!! $courier->cnpj !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>