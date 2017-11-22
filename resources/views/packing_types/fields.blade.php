<div class="form_fields">
@include('adminlte-templates::common.errors')
<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
{!! Form::text('code', null, ['class' => 'form-control']) !!}

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Tare Field -->
{!! Form::label('tare', Lang::get('models.tare').':') !!}
{!! Form::number('tare', null, ['class' => 'form-control']) !!}

<!-- Capacity Kg Field -->
{!! Form::label('capacity_kg', Lang::get('models.capacity_kg').':') !!}
{!! Form::number('capacity_kg', null, ['class' => 'form-control']) !!}

<!-- Capacity M3 Field -->
{!! Form::label('capacity_m3', Lang::get('models.capacity_m3').':') !!}
{!! Form::number('capacity_m3', null, ['class' => 'form-control']) !!}

<!-- Height Field -->
{!! Form::label('height', Lang::get('models.height').':') !!}
{!! Form::number('height', null, ['class' => 'form-control']) !!}

<!-- Width Field -->
{!! Form::label('width', Lang::get('models.width').':') !!}
{!! Form::number('width', null, ['class' => 'form-control']) !!}

<!-- Lenght Field -->
{!! Form::label('lenght', Lang::get('models.lenght').':') !!}
{!! Form::number('lenght', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('packingTypes.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
