<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="configs-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.value') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($configs as $config)
                <tr>
                    <td>{!! $config->code !!}</td>
                    <td>{!! $config->description !!}</td>
                    <td>{!! $config->value !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>