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
{!! Form::number('qty', null, ['class' => 'form-control']) !!}

<!-- Uom Code Field -->
{!! Form::label('uom_code', Lang::get('models.uom_code').':') !!}
{!! Form::select('uom_code', $uom_cads, (!empty($palletItem->uom_code)) ? $palletItem->uom_code : 'null', ['class' => 'form-control']) !!}

<!-- Prim Qty Field -->
{!! Form::label('prim_qty', Lang::get('models.prim_qty').':') !!}
{!! Form::number('prim_qty', null, ['class' => 'form-control']) !!}

<!-- Prim Uom Code Field -->
{!! Form::label('prim_uom_code', Lang::get('models.prim_uom_code').':') !!}
{!! Form::select('prim_uom_code', $uom_cads, (!empty($palletItem->prim_uom_code)) ? $palletItem->prim_uom_code : 'null', ['class' => 'form-control']) !!}

<!-- Label Id Field -->
{!! Form::label('label_id', Lang::get('models.label_id').':') !!}
{!! Form::number('label_id', null, ['class' => 'form-control']) !!}

<!-- Activity Id Field -->
{!! Form::label('activity_id', Lang::get('models.activity_id').':') !!}
{!! Form::number('activity_id', null, ['class' => 'form-control']) !!}

<!-- Status Field -->
{!! Form::label('status', Lang::get('models.status').':') !!}
{!! Form::select('status', array('1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

<!-- Turn Field -->
{!! Form::label('turn', Lang::get('models.turn').':') !!}
{!! Form::number('turn', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! action('PalletItemController@index',[$palletId]) !!}" class="btn btn-default">@lang('buttons.cancel')</a>
