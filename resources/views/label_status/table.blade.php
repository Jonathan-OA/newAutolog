<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="labelStatus-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.id') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($labelStatus as $labelStatus)
                <tr>
                    <td>{!! $labelStatus->id !!}</td>
                    <td>{!! $labelStatus->description !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>