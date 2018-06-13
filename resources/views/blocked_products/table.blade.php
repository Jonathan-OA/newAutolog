<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="blockedProducts-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.company_id') </th>
        <th class="th_grid">@lang('models.operation_code') </th>
        <th class="th_grid">@lang('models.product_code') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($blockedProducts as $blockedProduct)
                <tr>
                    <td>{!! $blockedProduct->company_id !!}</td>
            <td>{!! $blockedProduct->operation_code !!}</td>
            <td>{!! $blockedProduct->product_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>