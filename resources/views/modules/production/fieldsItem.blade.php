<div class="form_fields">
    @include('adminlte-templates::common.errors')
    
    <!-- Company Id Field -->
    <input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>
    
    <!-- Document Id Field -->
    <input id='document_id' name='document_id' type='hidden' value='{!! $document->id !!}'>
    
    <!-- Product Code Field -->
    {!! Form::label('product_code', Lang::get('models.product_code').':') !!}
    {!! Form::text('product_code', null, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'products']) !!}
    
    <!-- Qty Field -->
    {!! Form::label('qty', Lang::get('models.qty').':') !!}
    {!! Form::number('qty', null, ['class' => 'form-control']) !!}
    
    <!-- Uom Code Field -->
    {!! Form::label('uom_code', Lang::get('models.uom_code').':') !!}
    {!! Form::text('uom_code', null, ['class' => 'form-control', 'id' => 'autocomplete1', 'table' => 'packings', 'id_dep' => 'autocomplete', 'readonly']) !!}
    
    <!-- Document Status Id Field -->
    <input id='document_status_id' name='document_status_id' type='hidden' value='0'>
    
    <!-- Batch Field -->
    {!! Form::label('batch', Lang::get('models.batch').':') !!}
    {!! Form::text('batch', null, ['class' => 'form-control']) !!}
    
    <!-- Batch Supplier Field -->
    {!! Form::label('batch_supplier', Lang::get('models.batch_supplier').':') !!}
    {!! Form::text('batch_supplier', null, ['class' => 'form-control']) !!}
    
    <!-- Serial Number Field -->
    {!! Form::label('serial_number', Lang::get('models.serial_number').':') !!}
    {!! Form::text('serial_number', null, ['class' => 'form-control']) !!}
    
    <!-- Qty Conf Field -->
    {!! Form::label('qty_conf', Lang::get('models.qty_conf').':') !!}
    {!! Form::number('qty_conf', null, ['class' => 'form-control']) !!}
    
    <!-- Qty Ship Field -->
    {!! Form::label('qty_ship', Lang::get('models.qty_ship').':') !!}
    {!! Form::number('qty_ship', null, ['class' => 'form-control']) !!}
    
    <!-- Qty Reject Field -->
    {!! Form::label('qty_reject', Lang::get('models.qty_reject').':') !!}
    {!! Form::number('qty_reject', null, ['class' => 'form-control']) !!}
    
    <!-- Invoice Field -->
    {!! Form::label('invoice', Lang::get('models.invoice').':') !!}
    {!! Form::text('invoice', null, ['class' => 'form-control']) !!}
    
    <!-- Invoice Serial Number Field -->
    {!! Form::label('invoice_serial_number', Lang::get('models.invoice_serial_number').':') !!}
    {!! Form::text('invoice_serial_number', null, ['class' => 'form-control']) !!}
    
    <!-- Sequence Item Field -->
    {!! Form::label('sequence_item', Lang::get('models.sequence_item').':') !!}
    {!! Form::number('sequence_item', null, ['class' => 'form-control']) !!}
    
    
    <!-- Location Code Field -->
    {!! Form::label('location_code', Lang::get('models.location_code').':') !!}
    {!! Form::text('location_code', null, ['class' => 'form-control', 'id' => 'autocomplete3', 'table' => 'locations']) !!}
    
    <!-- Source Field -->
    {!! Form::label('source', Lang::get('models.source').':') !!}
    {!! Form::text('source', null, ['class' => 'form-control']) !!}
    
    <!-- Obs1 Field -->
    {!! Form::label('obs1', Lang::get('models.obs1').':') !!}
    {!! Form::text('obs1', null, ['class' => 'form-control']) !!}
    
    <!-- Obs2 Field -->
    {!! Form::label('obs2', Lang::get('models.obs2').':') !!}
    {!! Form::text('obs2', null, ['class' => 'form-control']) !!}
    
    <!-- Obs3 Field -->
    {!! Form::label('obs3', Lang::get('models.obs3').':') !!}
    {!! Form::text('obs3', null, ['class' => 'form-control']) !!}
    
    <!-- Obs4 Field -->
    {!! Form::label('obs4', Lang::get('models.obs4').':') !!}
    {!! Form::text('obs4', null, ['class' => 'form-control']) !!}
    
    <!-- Obs5 Field -->
    {!! Form::label('obs5', Lang::get('models.obs5').':') !!}
    {!! Form::text('obs5', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('documentItems.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
        