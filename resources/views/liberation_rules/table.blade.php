<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="liberationRules-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.module_name') </th>
                <th class="th_grid">@lang('models.enabled') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($liberationRules as $liberationRule)
                <tr>
                    <td>{!! $liberationRule->code !!}</td>
                    <td>{!! $liberationRule->module_name !!}</td>
                    <td>{!! $liberationRule->enabled !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>