<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="palletStatus-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.id') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($palletStatus as $paleteStatus)
                <tr>
                        <td>{!! $paleteStatus->id !!}</td>
                        <td>{!! $paleteStatus->description !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>