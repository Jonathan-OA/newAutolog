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
{!! Form::number('qty', null, ['id' => 'qty', 'class' => 'form-control', 'step' => '0.000001', 'placeholder' => '0,000000']) !!}

<!-- Uom Code Field -->
{!! Form::label('uom_code', Lang::get('models.uom_code').':') !!}
{!! Form::select('uom_code', $uoms, null, ['id' => 'uom_code', 'class' => 'form-control']) !!}

<!-- Prev Qty Field -->
{!! Form::label('prim_qty', Lang::get('models.prim_qty').':') !!}
{!! Form::number('prim_qty', null, ['class' => 'form-control','step' => '0.000001', 'placeholder' => '0,000000']) !!}

<!-- Prev Uom Code Field -->
{!! Form::label('prim_uom_code', Lang::get('models.prim_uom_code').':') !!}
{!! Form::select('prim_uom_code', $uoms, null, ['class' => 'form-control']) !!}

<!-- Pallet Id Field -->
{!! Form::label('pallet_id', Lang::get('models.pallet_id').':') !!}
{!! Form::number('pallet_id', null, ['class' => 'form-control']) !!}

<!-- Document Id Field -->
<input id='document_id' name='document_id' type='hidden' value='{!! $stock->document_id !!}'>

<!-- Document Item Id Field -->
<input id='document_item_id' name='document_item_id' type='hidden' value='{!! $stock->document_item_id !!}'>

<!-- Task Id Field -->
<input id='task_id' name='task_id' type='hidden' value='{!! $stock->task_id !!}'>

<!-- Finality Field -->
<input id='finality_code' name='finality_code' type='hidden' value='{!! $stock->finality_code !!}'>

<!-- User Id Field -->
<input id='user_id' name='user_id' type='hidden' value='{!! Auth::user()->id !!}'>

<!-- Operation Code Field -->
<input id='operation_code' name='operation_code' type='hidden' value='{!! $stock->operation_code !!}'>

<!-- Volume Id Field -->
{!! Form::label('volume_id', Lang::get('models.volume_id').':') !!}
{!! Form::number('volume_id', (!empty($stock->operation_code))?$stock->operation_code:null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('stocks.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
