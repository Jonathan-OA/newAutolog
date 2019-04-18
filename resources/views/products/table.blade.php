<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered  table-striped" id="products-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.product_type_code') </th>
                <th class="th_grid">@lang('models.group_code') </th>
                <th class="th_grid">@lang('models.subgroup_code') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{!! $product->code !!}</td>
                    <td>{!! $product->description !!}</td>
                    <td>{!! $product->product_type_code !!}</td>
                    <td>{!! $product->group_code !!}</td>
                    <td>{!! $product->subgroup_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>