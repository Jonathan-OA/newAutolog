<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="locationFunctions-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($locationFunctions as $locationFunction)
                <tr>
                    <td>{!! $locationFunction->code !!}</td>
                    <td>{!! $locationFunction->description !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>