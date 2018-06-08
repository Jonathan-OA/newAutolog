<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="suppliers-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.name') </th>
                <th class="th_grid">@lang('models.trading_name') </th>
                <th class="th_grid">@lang('models.cnpj') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($suppliers as $supplier)
                <tr>
                    <td>{!! $supplier->code !!}</td>
                    <td>{!! $supplier->name !!}</td>
                    <td>{!! $supplier->trading_name !!}</td>
                    <td>{!! $supplier->cnpj !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>