<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="" style="margin: 0 15px 0 15px">
        <table class="table table-bordered" id="documentTypes-table" cellspacing="0" width="100%">
            <thead>
                <th class="th_grid">@lang('models.code') </th>
                <th class="th_grid">@lang('models.description') </th>
                <th class="th_grid">@lang('models.moviment_code') </th>
                <th class="th_grid">@lang('models.action')</th>
            </thead>
            <tbody>
            @foreach($documentTypes as $documentType)
                <tr>
                    <td>{!! $documentType->code !!}</td>
                    <td>{!! $documentType->description !!}</td>
                    <td>{!! $documentType->moviment_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>