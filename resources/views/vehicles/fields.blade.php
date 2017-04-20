<div class="form_fields">
<!-- Company Id Field -->
{!! Form::label('company_id', 'Company Id:') !!}
{!! Form::number('company_id', null, ['class' => 'form-control']) !!}

<!-- Courier Id Field -->
{!! Form::label('courier_id', 'Courier Id:') !!}
{!! Form::number('courier_id', null, ['class' => 'form-control']) !!}

<!-- Vehicle Type Id Field -->
{!! Form::label('vehicle_type_id', 'Vehicle Type Id:') !!}
{!! Form::number('vehicle_type_id', null, ['class' => 'form-control']) !!}

<!-- Number Plate Field -->
{!! Form::label('number_plate', 'Number Plate:') !!}
{!! Form::text('number_plate', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
<a href="{!! route('vehicles.index') !!}" class="btn btn-default">Cancelar</a>
