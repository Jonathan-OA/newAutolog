<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="labelLayouts-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.label_type_code') </th>
                <th class="th_grid">@lang('models.printer_type_code') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.action') </th>
            </thead>
            <tbody>
            @foreach($labelLayouts as $labelLayout)
                <tr>
                    <td>{!! $labelLayout->code !!}</td>
                    <td>{!! $labelLayout->label_type_code !!}</td>
                    <td>{!! $labelLayout->printer_type_code !!}</td>
                    <td>{!! $labelLayout->description !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>