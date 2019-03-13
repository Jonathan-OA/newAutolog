<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered table-striped" id="documentTypeRules-table" cellspacing="0" width="100%">
            <thead>
                
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.order') </th>
                <th class="th_grid">@lang('models.parameters') </th>
                <th class="th_grid"></th>
            </thead>
            <tbody >
            @foreach($documentTypeRules as $documentTypeRule)
                <tr>
                    <td>{!! $documentTypeRule->code !!}</td>
                    <td>{!! $documentTypeRule->description !!}</td>
                    <td></td>
                    <td class="td_center">{!! Form::number('order', $documentTypeRule->order) !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>