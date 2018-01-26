<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="modules-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.module') </th>
        <th class="th_grid">@lang('models.submodule') </th>
        <th class="th_grid">@lang('models.name') </th>
        <th class="th_grid">@lang('models.enabled') </th>
        <th class="th_grid">@lang('models.icon') </th>
        <th class="th_grid">@lang('models.url') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($modules as $module)
                <tr>
                    <td>{!! $module->module !!}</td>
            <td>{!! $module->submodule !!}</td>
            <td>{!! $module->name !!}</td>
            <td>{!! $module->enabled !!}</td>
            <td>{!! $module->icon !!}</td>
            <td>{!! $module->url !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>