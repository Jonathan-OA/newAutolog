<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Source Department Code Field -->
{!! Form::label('source_department_code', Lang::get('models.source_department_code').':') !!}
{!! Form::text('source_department_code', null, ['class' => 'form-control']) !!}

<!-- Source Deposit Code Field -->
{!! Form::label('source_deposit_code', Lang::get('models.source_deposit_code').':') !!}
{!! Form::text('source_deposit_code', null, ['class' => 'form-control']) !!}

<!-- Dest Department Code Field -->
{!! Form::label('dest_department_code', Lang::get('models.dest_department_code').':') !!}
{!! Form::text('dest_department_code', null, ['class' => 'form-control']) !!}

<!-- Dest Deposit Code Field -->
{!! Form::label('dest_deposit_code', Lang::get('models.dest_deposit_code').':') !!}
{!! Form::text('dest_deposit_code', null, ['class' => 'form-control']) !!}

<!-- Operation Code Field -->
{!! Form::label('operation_code', Lang::get('models.operation_code').':') !!}
{!! Form::text('operation_code', null, ['class' => 'form-control']) !!}

<!-- Document Type Code Field -->
{!! Form::label('document_type_code', Lang::get('models.document_type_code').':') !!}
{!! Form::text('document_type_code', null, ['class' => 'form-control']) !!}

<!-- Reset Stock Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reset_stock', Lang::get('models.reset_stock').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('reset_stock', false) !!}
        {!! Form::checkbox('reset_stock', '1', null) !!} 1
    </label>
</div>

<!-- Export Erp Field -->
<div class="form-group col-sm-6">
    {!! Form::label('export_erp', Lang::get('models.export_erp').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('export_erp', false) !!}
        {!! Form::checkbox('export_erp', '1', null) !!} 1
    </label>
</div>

<!-- Operation Erp Field -->
{!! Form::label('operation_erp', Lang::get('models.operation_erp').':') !!}
{!! Form::text('operation_erp', null, ['class' => 'form-control']) !!}

<!-- Cost Center Field -->
{!! Form::label('cost_center', Lang::get('models.cost_center').':') !!}
{!! Form::text('cost_center', null, ['class' => 'form-control']) !!}

<!-- Logical Deposit Field -->
{!! Form::label('logical_deposit', Lang::get('models.logical_deposit').':') !!}
{!! Form::text('logical_deposit', null, ['class' => 'form-control']) !!}

<!-- Enabled Field -->
<div class="form-group col-sm-6">
    {!! Form::label('enabled', Lang::get('models.enabled').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('enabled', false) !!}
        {!! Form::checkbox('enabled', '1', null) !!} 1
    </label>
</div>
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('allowedTransfers.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
