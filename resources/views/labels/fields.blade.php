<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Barcode Field -->
{!! Form::label('barcode', Lang::get('models.barcode').':') !!}
{!! Form::text('barcode', null, ['class' => 'form-control']) !!}

<!-- Product Code Field -->
{!! Form::label('product_code', Lang::get('models.product_code').':') !!}
{!! Form::text('product_code', null, ['class' => 'form-control']) !!}

<!-- Qty Field -->
{!! Form::label('qty', Lang::get('models.qty').':') !!}
{!! Form::number('qty', null, ['class' => 'form-control']) !!}

<!-- Uom Code Field -->
{!! Form::label('uom_code', Lang::get('models.uom_code').':') !!}
{!! Form::text('uom_code', null, ['class' => 'form-control']) !!}

<!-- Prev Qty Field -->
{!! Form::label('prev_qty', Lang::get('models.prev_qty').':') !!}
{!! Form::number('prev_qty', null, ['class' => 'form-control']) !!}

<!-- Prev Uom Code Field -->
{!! Form::label('prev_uom_code', Lang::get('models.prev_uom_code').':') !!}
{!! Form::text('prev_uom_code', null, ['class' => 'form-control']) !!}

<!-- Document Id Field -->
{!! Form::label('document_id', Lang::get('models.document_id').':') !!}
{!! Form::number('document_id', null, ['class' => 'form-control']) !!}

<!-- Document Item Id Field -->
{!! Form::label('document_item_id', Lang::get('models.document_item_id').':') !!}
{!! Form::number('document_item_id', null, ['class' => 'form-control']) !!}

<!-- Origin Field -->
{!! Form::label('origin', Lang::get('models.origin').':') !!}
{!! Form::number('origin', null, ['class' => 'form-control']) !!}

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
{!! Form::date('prod_date', null, ['class' => 'form-control']) !!}

<!-- Due Date Field -->
{!! Form::label('due_date', Lang::get('models.due_date').':') !!}
{!! Form::date('due_date', null, ['class' => 'form-control']) !!}

<!-- Ripeness Date Field -->
{!! Form::label('ripeness_date', Lang::get('models.ripeness_date').':') !!}
{!! Form::date('ripeness_date', null, ['class' => 'form-control']) !!}

<!-- Critical Date1 Field -->
{!! Form::label('critical_date1', Lang::get('models.critical_date1').':') !!}
{!! Form::date('critical_date1', null, ['class' => 'form-control']) !!}

<!-- Critical Date2 Field -->
{!! Form::label('critical_date2', Lang::get('models.critical_date2').':') !!}
{!! Form::date('critical_date2', null, ['class' => 'form-control']) !!}

<!-- Critical Date3 Field -->
{!! Form::label('critical_date3', Lang::get('models.critical_date3').':') !!}
{!! Form::date('critical_date3', null, ['class' => 'form-control']) !!}

<!-- Label Status Id Field -->
{!! Form::label('label_status_id', Lang::get('models.label_status_id').':') !!}
{!! Form::number('label_status_id', null, ['class' => 'form-control']) !!}

<!-- Level Field -->
{!! Form::label('level', Lang::get('models.level').':') !!}
{!! Form::number('level', null, ['class' => 'form-control']) !!}

<!-- Travel Id Field -->
{!! Form::label('travel_id', Lang::get('models.travel_id').':') !!}
{!! Form::number('travel_id', null, ['class' => 'form-control']) !!}

<!-- Task Id Field -->
{!! Form::label('task_id', Lang::get('models.task_id').':') !!}
{!! Form::number('task_id', null, ['class' => 'form-control']) !!}

<!-- Layout Code Field -->
{!! Form::label('layout_code', Lang::get('models.layout_code').':') !!}
{!! Form::text('layout_code', null, ['class' => 'form-control']) !!}

<!-- Weight Field -->
{!! Form::label('weight', Lang::get('models.weight').':') !!}
{!! Form::number('weight', null, ['class' => 'form-control']) !!}

<!-- Width Field -->
{!! Form::label('width', Lang::get('models.width').':') !!}
{!! Form::number('width', null, ['class' => 'form-control']) !!}

<!-- Lenght Field -->
{!! Form::label('lenght', Lang::get('models.lenght').':') !!}
{!! Form::number('lenght', null, ['class' => 'form-control']) !!}

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
