<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="deposits-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.department_code') </th>
                <th class="th_grid">@lang('models.deposit_type_code') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.status') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($deposits as $deposit)
                <tr>
                    <td>{!! $deposit->code !!}</td>
                    <td>{!! $deposit->department_code !!}</td>
                    <td>{!! $deposit->deposit_type_code !!}</td>
                    <td>{!! $deposit->description !!}</td>
                    <td>{!! $deposit->status !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>