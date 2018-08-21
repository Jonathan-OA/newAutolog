<div class="form_fields">
@include('adminlte-templates::common.errors')
<!-- Alerta de erro personalizados/ sucesso -->
@include('flash::message')          

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Barcode Field -->
{!! Form::label('barcode', Lang::get('models.barcode').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('barcode', null, ['class' => 'form-control','readonly' => 'true']) !!}
@else
    {!! Form::text('barcode', null, ['class' => 'form-control']) !!}  
@endif

<!-- Status Field -->
<input id='pallet_status_id' name='pallet_status_id' type='hidden' value='{!! (!empty($pallet->pallet_status_id)) ? $pallet->pallet_status_id : 0 !!}'>

<!-- Location Code Field -->
{!! Form::label('location_code', Lang::get('models.location_code').':') !!}
{!! Form::text('location_code', null, ['class' => 'form-control','id' => 'autocomplete', 'table' => 'locations']) !!}

<!-- Document Id Field -->
<input id='document_id' name='document_id' type='hidden' value='{!! (!empty($pallet->document_id)) ? $pallet->document_id : null !!}'>

<!-- Height Field -->
{!! Form::label('height', Lang::get('models.height').':') !!}
{!! Form::number('height', null, ['class' => 'form-control']) !!}

<!-- Stacking Field -->
{!! Form::label('stacking', Lang::get('models.stacking').':') !!}
{!! Form::number('stacking', null, ['class' => 'form-control']) !!}

<!-- Packing Type Code Field -->
{!! Form::label('packing_type_code', Lang::get('models.packing_type_code').':') !!}
{!! Form::text('packing_type_code', null, ['class' => 'form-control','id' => 'autocomplete1', 'table' => 'packing_types']) !!}

</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('pallets.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
