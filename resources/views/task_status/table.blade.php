<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="taskStatus-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.id') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($taskStatus as $taskStatus)
                <tr>
                    <td>{!! $taskStatus->id !!}</td>
                    <td>{!! $taskStatus->description !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>