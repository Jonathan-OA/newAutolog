<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="activities-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.user_id') </th>
                <th class="th_grid">@lang('models.date') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.document_number') </th>
                <th class="th_grid">@lang('models.label_id') </th>
                <th class="th_grid">@lang('models.pallet_barcode') </th>
                <th class="th_grid">@lang('models.qty') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($activities as $activity)
                <tr>
                    <td>{!! $activity->code !!}</td>
                    <td>{!! $activity->date !!}</td>
                    <td>{!! $activity->description !!}</td>
                    <td>{!! $activity->number !!}</td>
                    <td>{!! $activity->label_barcode !!}</td>
                    <td>{!! $activity->pallet_barcode !!}</td>
                    <td>{!! $activity->qty !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>