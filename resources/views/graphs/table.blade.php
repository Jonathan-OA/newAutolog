<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="graphs-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.description') </th>
        <th class="th_grid">@lang('models.type') </th>
        <th class="th_grid">@lang('models.qry') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($graphs as $graph)
                <tr>
                    <td>{!! $graph->description !!}</td>
            <td>{!! $graph->type !!}</td>
            <td>{!! $graph->qry !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>