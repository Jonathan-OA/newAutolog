<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Barcode Field -->
{!! Form::label('barcode', Lang::get('models.barcode').':') !!}
{!! Form::text('barcode', null, ['class' => 'form-control']) !!}

<!-- Date Field -->
{!! Form::label('date', 'Date:') !!}
{!! Form::date('date', (!empty($pallet->date)) ? \Carbon\Carbon::parse($pallet->date) : 'null', ['class' => 'form-control']) !!}

<!-- Status Field -->
{!! Form::label('status', Lang::get('models.status').':') !!}
{!! Form::select('status', array('1' => 'Ativo', '0' => 'Inativo'), null, ['class' => 'form-control']) !!}

<!-- Location Code Field -->
{!! Form::label('location_code', Lang::get('models.location_code').':') !!}
{!! Form::text('location_code', null, ['class' => 'form-control','id' => 'autocomplete']) !!}

<!-- Document Id Field -->
{!! Form::label('document_id', Lang::get('models.document_id').':') !!}
{!! Form::number('document_id', null, ['class' => 'form-control']) !!}

<!-- Height Field -->
{!! Form::label('height', Lang::get('models.height').':') !!}
{!! Form::number('height', null, ['class' => 'form-control']) !!}

<!-- Stacking Field -->
{!! Form::label('stacking', Lang::get('models.stacking').':') !!}
{!! Form::number('stacking', null, ['class' => 'form-control']) !!}

<!-- Packing Type Code Field -->
{!! Form::label('packing_type_code', Lang::get('models.packing_type_code').':') !!}
{!! Form::select('location_function_code', $packing_types, (!empty($pallet->packing_type_code)) ? $pallet->packing_type_code : 'null', ['class' => 'form-control']) !!}

</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('pallets.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
