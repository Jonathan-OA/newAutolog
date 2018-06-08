<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Courier Id Field -->
{!! Form::label('courier_id', Lang::get('models.courier_id').':') !!}
{!! Form::number('courier_id', null, ['class' => 'form-control']) !!}

<!-- Vehicle Type Id Field -->
{!! Form::label('vehicle_type_id', Lang::get('models.vehicle_type_id').':') !!}
{!! Form::number('vehicle_type_id', null, ['class' => 'form-control']) !!}

<!-- Number Plate Field -->
{!! Form::label('number_plate', Lang::get('models.number_plate').':') !!}
{!! Form::text('number_plate', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('vehicles.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
