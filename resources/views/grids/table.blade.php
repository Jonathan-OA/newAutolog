<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="grids-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.company_id') </th>
        <th class="th_grid">@lang('models.module') </th>
        <th class="th_grid">@lang('models.submodule') </th>
        <th class="th_grid">@lang('models.columns') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($grids as $grid)
                <tr>
                    <td>{!! $grid->company_id !!}</td>
            <td>{!! $grid->module !!}</td>
            <td>{!! $grid->submodule !!}</td>
            <td>{!! $grid->columns !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>