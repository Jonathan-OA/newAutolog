<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

@if(isset($action) && $action == 'edit')
    <input id='id' name='id' type='hidden' value='{!! $label->id !!}'>
@endif

<!-- Barcode Field -->
{!! Form::label('barcode', Lang::get('models.barcode').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('barcode', null, ['class' => 'form-control', 'readonly']) !!}
@else
    {!! Form::text('barcode', null, ['class' => 'form-control']) !!}
@endif

<!-- Product Code Field -->
{!! Form::label('product_code', Lang::get('models.product_code').':') !!}
{!! Form::text('product_code', null, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'products']) !!}

<!-- Qty Field -->
{!! Form::label('qty', Lang::get('models.qty').':') !!}
{!! Form::number('qty', null, ['class' => 'form-control','step' => '0.000001', 'placeholder' => '0,000000']) !!}

<!-- Uom Code Field -->
{!! Form::label('uom_code', Lang::get('models.uom_code').':') !!}
{!! Form::text('uom_code', null, ['class' => 'form-control','id' => 'autocomplete1', 'table' => 'packings','id_dep' => 'autocomplete','readonly']) !!}

<!-- Prev Qty Field -->
{!! Form::label('prim_qty', Lang::get('models.prim_qty').':') !!}
{!! Form::number('prim_qty', null, ['class' => 'form-control','step' => '0.000001', 'placeholder' => '0,000000']) !!}

<!-- Prev Uom Code Field -->
{!! Form::label('prim_uom_code', Lang::get('models.prim_uom_code').':') !!}
{!! Form::text('prim_uom_code', null, ['class' => 'form-control','id' => 'autocomplete2', 'table' => 'packings','id_dep' => 'autocomplete','readonly']) !!}

<!-- Label Status Id Field -->
<input id='label_status_id' name='label_status_id' type='hidden' value='{!! (!empty($label->label_status_id)) ? $label->label_status_id : 0 !!}'>

<!-- Origin Field -->
<input id='origin' name='origin' type='hidden' value='{!! (!empty($label->origin)) ? $label->origin : '' !!}'>

<!-- Serial Number Field -->
{!! Form::label('serial_number', Lang::get('models.serial_number').':') !!}
{!! Form::text('serial_number', null, ['class' => 'form-control']) !!}

<!-- Batch Field -->
{!! Form::label('batch', Lang::get('models.batch').':') !!}
{!! Form::text('batch', null, ['class' => 'form-control']) !!}

<!-- Batch Supplier Field -->
{!! Form::label('batch_supplier', Lang::get('models.batch_supplier').':') !!}
{!! Form::text('batch_supplier', null, ['class' => 'form-control']) !!}

<!-- Prod Date Field -->
{!! Form::label('prod_date', Lang::get('models.prod_date').':') !!}
{!! Form::date('prod_date', (!empty($label->prod_date)) ? $label->prod_date->format('Y-m-d') : '', ['class' => 'form-control']) !!}

<!-- Due Date Field -->
{!! Form::label('due_date', Lang::get('models.due_date').':') !!}
{!! Form::date('due_date', (!empty($label->due_date)) ? $label->due_date->format('Y-m-d') : '', ['class' => 'form-control']) !!}

<!-- Ripeness Date Field -->
{!! Form::label('ripeness_date', Lang::get('models.ripeness_date').':') !!}
{!! Form::date('ripeness_date', (!empty($label->ripeness_date)) ? $label->ripeness_date->format('Y-m-d') : '', ['class' => 'form-control']) !!}

<!-- Critical Date1 Field -->
{!! Form::label('critical_date1', Lang::get('models.critical_date1').':') !!}
{!! Form::date('critical_date1', (!empty($label->critical_date1)) ? $label->critical_date1->format('Y-m-d') : '', ['class' => 'form-control']) !!}

<!-- Critical Date2 Field -->
{!! Form::label('critical_date2', Lang::get('models.critical_date2').':') !!}
{!! Form::date('critical_date2',  (!empty($label->critical_date2)) ? $label->critical_date2->format('Y-m-d') : '', ['class' => 'form-control']) !!}

<!-- Critical Date3 Field -->
{!! Form::label('critical_date3', Lang::get('models.critical_date3').':') !!}
{!! Form::date('critical_date3', (!empty($label->critical_date3)) ? $label->critical_date3->format('Y-m-d') : '', ['class' => 'form-control']) !!}

<!-- Level Field -->
{!! Form::label('level', Lang::get('models.level').':') !!}
{!! Form::number('level', null, ['class' => 'form-control']) !!}

<!-- Layout Code Field -->
{!! Form::label('label_type_code', Lang::get('models.label_type_code').':') !!}
{!! Form::text('label_type_code', null, ['class' => 'form-control','id' => 'autocomplete3', 'table' => 'label_types']) !!}

<!-- Weight Field -->
{!! Form::label('weight', Lang::get('models.weight').':') !!}
{!! Form::number('weight', null, ['class' => 'form-control']) !!}

<!-- Width Field -->
{!! Form::label('width', Lang::get('models.width').':') !!}
{!! Form::number('width', null, ['class' => 'form-control']) !!}

<!-- Lenght Field -->
{!! Form::label('length', Lang::get('models.length').':') !!}
{!! Form::number('length', null, ['class' => 'form-control']) !!}

<!-- Text1 Field -->
{!! Form::label('obs1', Lang::get('models.obs1').':') !!}
{!! Form::text('obs1', null, ['class' => 'form-control']) !!}

<!-- Text2 Field -->
{!! Form::label('obs2', Lang::get('models.obs2').':') !!}
{!! Form::text('obs2', null, ['class' => 'form-control']) !!}

<!-- Text3 Field -->
{!! Form::label('obs3', Lang::get('models.obs3').':') !!}
{!! Form::text('obs3', null, ['class' => 'form-control']) !!}

<!-- Text4 Field -->
{!! Form::label('obs4', Lang::get('models.obs4').':') !!}
{!! Form::text('obs4', null, ['class' => 'form-control']) !!}

<!-- Text5 Field -->
{!! Form::label('obs5', Lang::get('models.obs5').':') !!}
{!! Form::text('obs5', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('labels.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
