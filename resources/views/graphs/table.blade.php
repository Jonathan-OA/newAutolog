<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="graphs-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.company_id') </th>
        <th class="th_grid">@lang('models.code') </th>
        <th class="th_grid">@lang('models.title') </th>
        <th class="th_grid">@lang('models.type') </th>
        <th class="th_grid">@lang('models.color') </th>
        <th class="th_grid">@lang('models.enabled') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($graphs as $graph)
                <tr>
                    <td>{!! $graph->company_id !!}</td>
            <td>{!! $graph->code !!}</td>
            <td>{!! $graph->title !!}</td>
            <td>{!! $graph->type !!}</td>
            <td>{!! $graph->color !!}</td>
            <td>{!! $graph->enabled !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>