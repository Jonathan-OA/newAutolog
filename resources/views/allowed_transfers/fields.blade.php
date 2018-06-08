<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Orig Department Code Field -->
{!! Form::label('orig_department_code', Lang::get('models.orig_department_code').':') !!}
{!! Form::text('orig_department_code', null, ['class' => 'form-control','id' => 'autocomplete', 'table' => 'departments']) !!}

<!-- Orig Deposit Code Field -->
{!! Form::label('orig_deposit_code', Lang::get('models.orig_deposit_code').':') !!}
{!! Form::text('orig_deposit_code', null, ['class' => 'form-control', 'id' => 'autocomplete1', 'table' => 'deposits', 'id_dep' => 'autocomplete', 'readonly']) !!}

<!-- Dest Department Code Field -->
{!! Form::label('dest_department_code', Lang::get('models.dest_department_code').':') !!}
{!! Form::text('dest_department_code', null, ['class' => 'form-control','id' => 'autocomplete2', 'table' => 'departments']) !!}

<!-- Dest Deposit Code Field -->
{!! Form::label('dest_deposit_code', Lang::get('models.dest_deposit_code').':') !!}
{!! Form::text('dest_deposit_code', null, ['class' => 'form-control', 'id' => 'autocomplete3', 'table' => 'deposits', 'id_dep' => 'autocomplete2', 'readonly']) !!}

<!-- Operation Code Field -->
{!! Form::label('operation_code', Lang::get('models.operation_code').':') !!}

@if(isset($action) && $action == 'edit')
    <!-- Se ação == Editar, não permite selecionar multiplos valores no campo. Só aceita na inserção. -->
    {!! Form::text('operation_code', null, ['class' => 'form-control', 'id' => 'autocomplete4', 'table' => 'operations']) !!}
@else
    {!! Form::text('operation_code', null, ['class' => 'form-control', 'id' => 'autocomplete4', 'table' => 'operations', 'multiple']) !!}
@endif

<!-- Document Type Code Field -->
{!! Form::label('document_type_code', Lang::get('models.document_type_code').':') !!}
{!! Form::text('document_type_code', null, ['class' => 'form-control', 'id' => 'autocomplete5', 'table' => 'document_types']) !!}

<!-- Reset Stock Field -->
{!! Form::label('reset_stock', Lang::get('models.reset_stock').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="reset_stock"  value="0" >
    {{ Form::checkbox('reset_stock', 1, (!empty($allowedTransfer->reset_stock)) ? $allowedTransfer->reset_stock : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'reset_stock']) }}
    <label class="onoffswitch-label" for="reset_stock">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Export Erp Field -->
{!! Form::label('export_erp', Lang::get('models.export_erp').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="export_erp"  value="0" >
    {{ Form::checkbox('export_erp', 1, (!empty($allowedTransfer->export_erp)) ? $allowedTransfer->export_erp : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'export_erp']) }}
    <label class="onoffswitch-label" for="export_erp">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
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
{!! Form::label('enabled', Lang::get('models.enabled').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="enabled"  value="0" >
    {{ Form::checkbox('enabled', 1, (!empty($allowedTransfer->enabled)) ? $allowedTransfer->enabled : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'enabled']) }}
    <label class="onoffswitch-label" for="enabled">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>


</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('allowedTransfers.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
