<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="documentTypeRules-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.company_id') </th>
                <th class="th_grid">@lang('models.document_type_code') </th>
                <th class="th_grid">@lang('models.liberation_rule_code') </th>
                <th class="th_grid">@lang('models.order') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($documentTypeRules as $documentTypeRule)
                <tr>
                    <td>{!! $documentTypeRule->company_id !!}</td>
                    <td>{!! $documentTypeRule->document_type_code !!}</td>
                    <td>{!! $documentTypeRule->liberation_rule_code !!}</td>
                    <td>{!! $documentTypeRule->order !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>