<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Pallet Id Field -->
<input id='pallet_id' name='pallet_id' type='hidden' value='{!! $palletId !!}'>

<!-- Item Code Field -->
{!! Form::label('product_code', Lang::get('models.product_code').':') !!}
{!! Form::text('product_code', null, ['class' => 'form-control','id' => 'autocomplete', 'table' => 'products']) !!}

<!-- Qty Field -->
{!! Form::label('qty', Lang::get('models.qty').':') !!}
{!! Form::number('qty', null, ['class' => 'form-control','step' => '0.000001','placeholder' => '0,000000']) !!}

<!-- Uom Code Field -->
{!! Form::label('uom_code', Lang::get('models.uom_code').':') !!}
{!! Form::text('uom_code', null, ['class' => 'form-control','id' => 'autocomplete1', 'table' => 'packings', 'id_dep' => 'autocomplete', 'readonly']) !!}

<!-- Prim Qty Field -->
{!! Form::label('prev_qty', Lang::get('models.prim_qty').':') !!}
{!! Form::number('prev_qty', null, ['class' => 'form-control','step' => '0.000001','placeholder' => '0,000000']) !!}

<!-- Prim Uom Code Field -->
{!! Form::label('prev_uom_code', Lang::get('models.prim_uom_code').':') !!}
{!! Form::text('prev_uom_code', null, ['class' => 'form-control','id' => 'autocomplete2', 'table' => 'packings', 'id_dep' => 'autocomplete', 'readonly']) !!}

<!-- Label Id Field -->
{!! Form::label('label_id', Lang::get('models.label_id').':') !!}
{!! Form::number('label_id', null, ['class' => 'form-control']) !!}

<!-- Activity Id Field -->
<input id='activity_id' name='activity_id' type='hidden' value='{!! (!empty($palletItem->activity_id)) ? $palletItem->activity_id : null !!}'>


<!-- Status Field -->
{!! Form::label('pallet_status_id', Lang::get('models.status').':') !!}
{!! Form::select('pallet_status_id', $palletStatus, (!empty($palletItem->pallet_status_id)) ? $palletItem->pallet_status_id : '', ['class' => 'form-control']) !!}


<!-- Turn Field -->
{!! Form::label('turn', Lang::get('models.turn').':') !!}
{!! Form::number('turn', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! action('PalletItemController@index',[$palletId]) !!}" class="btn btn-default">@lang('buttons.cancel')</a>
