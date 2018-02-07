<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Client Id Field -->
{!! Form::label('client_id', Lang::get('models.client_id').':') !!}
{!! Form::text('client_id', null, ['class' => 'form-control']) !!}

<!-- Item Code Field -->
{!! Form::label('item_code', Lang::get('models.item_code').':') !!}
{!! Form::text('item_code', null, ['class' => 'form-control']) !!}

<!-- Qty Field -->
{!! Form::label('qty', Lang::get('models.qty').':') !!}
{!! Form::number('qty', null, ['class' => 'form-control']) !!}

<!-- Uom Code Field -->
{!! Form::label('uom_code', Lang::get('models.uom_code').':') !!}
{!! Form::text('uom_code', null, ['class' => 'form-control']) !!}

<!-- Prim Qty Field -->
{!! Form::label('prim_qty', Lang::get('models.prim_qty').':') !!}
{!! Form::number('prim_qty', null, ['class' => 'form-control']) !!}

<!-- Prim Uom Code Field -->
{!! Form::label('prim_uom_code', Lang::get('models.prim_uom_code').':') !!}
{!! Form::text('prim_uom_code', null, ['class' => 'form-control']) !!}

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

<!-- Date Field -->
{!! Form::label('date', 'Date:') !!}
{!! Form::date('date', null, ['class' => 'form-control']) !!}

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
{!! Form::label('prod_date', 'Prod Date:') !!}
{!! Form::date('prod_date', null, ['class' => 'form-control']) !!}

<!-- Due Date Field -->
{!! Form::label('due_date', 'Due Date:') !!}
{!! Form::date('due_date', null, ['class' => 'form-control']) !!}

<!-- Ripeness Date Field -->
{!! Form::label('ripeness_date', 'Ripeness Date:') !!}
{!! Form::date('ripeness_date', null, ['class' => 'form-control']) !!}

<!-- Critical Date1 Field -->
{!! Form::label('critical_date1', 'Critical Date1:') !!}
{!! Form::date('critical_date1', null, ['class' => 'form-control']) !!}

<!-- Critical Date2 Field -->
{!! Form::label('critical_date2', 'Critical Date2:') !!}
{!! Form::date('critical_date2', null, ['class' => 'form-control']) !!}

<!-- Critical Date3 Field -->
{!! Form::label('critical_date3', 'Critical Date3:') !!}
{!! Form::date('critical_date3', null, ['class' => 'form-control']) !!}

<!-- Status Field -->
{!! Form::label('status', Lang::get('models.status').':') !!}
{!! Form::number('status', null, ['class' => 'form-control']) !!}

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
{!! Form::label('text1', Lang::get('models.text1').':') !!}
{!! Form::text('text1', null, ['class' => 'form-control']) !!}

<!-- Text2 Field -->
{!! Form::label('text2', Lang::get('models.text2').':') !!}
{!! Form::text('text2', null, ['class' => 'form-control']) !!}

<!-- Text3 Field -->
{!! Form::label('text3', Lang::get('models.text3').':') !!}
{!! Form::text('text3', null, ['class' => 'form-control']) !!}

<!-- Text4 Field -->
{!! Form::label('text4', Lang::get('models.text4').':') !!}
{!! Form::text('text4', null, ['class' => 'form-control']) !!}

<!-- Text5 Field -->
{!! Form::label('text5', Lang::get('models.text5').':') !!}
{!! Form::text('text5', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('labels.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
