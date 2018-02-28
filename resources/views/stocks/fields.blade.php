<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Product Code Field -->
{!! Form::label('product_code', Lang::get('models.product_code').':') !!}
{!! Form::text('product_code', null, ['class' => 'form-control','id' => 'autocomplete', 'table' => 'products']) !!}

<!-- Label Id Field -->
{!! Form::label('label_id', Lang::get('models.label_id').':') !!}
{!! Form::number('label_id', null, ['class' => 'form-control']) !!}

<!-- Location Code Field -->
{!! Form::label('location_code', Lang::get('models.location_code').':') !!}
{!! Form::text('location_code', null, ['class' => 'form-control','id' => 'autocomplete1', 'table' => 'locations']) !!}

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

<!-- Pallet Id Field -->
{!! Form::label('pallet_id', Lang::get('models.pallet_id').':') !!}
{!! Form::number('pallet_id', null, ['class' => 'form-control']) !!}

<!-- Document Id Field -->
{!! Form::label('document_id', Lang::get('models.document_id').':') !!}
{!! Form::number('document_id', null, ['class' => 'form-control']) !!}

<!-- Document Item Id Field -->
{!! Form::label('document_item_id', Lang::get('models.document_item_id').':') !!}
{!! Form::number('document_item_id', null, ['class' => 'form-control']) !!}

<!-- Task Id Field -->
{!! Form::label('task_id', Lang::get('models.task_id').':') !!}
{!! Form::number('task_id', null, ['class' => 'form-control']) !!}

<!-- Finality Field -->
{!! Form::label('finality_code', Lang::get('models.finality_code').':') !!}
{!! Form::select('finality_code', $finalities, null, ['class' => 'form-control']) !!}

<!-- User Id Field -->
{!! Form::label('user_id', Lang::get('models.user_id').':') !!}
{!! Form::number('user_id', null, ['class' => 'form-control']) !!}

<!-- Operation Code Field -->
{!! Form::label('operation_code', Lang::get('models.operation_code').':') !!}
{!! Form::text('operation_code', null, ['class' => 'form-control','id' => 'autocomplete2', 'table' => 'operations']) !!}

<!-- Volume Id Field -->
{!! Form::label('volume_id', Lang::get('models.volume_id').':') !!}
{!! Form::number('volume_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('stocks.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
