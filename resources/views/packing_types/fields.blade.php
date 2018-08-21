<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
    <!-- Id Field -->
    <input id='id' name='id' type='hidden' value='{!! $packingType->id !!}'>
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}  
@endif

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Tare Field -->
{!! Form::label('tare', Lang::get('models.tare').':') !!}
{!! Form::number('tare', null, ['class' => 'form-control','step' => '0.000001', 'placeholder' => '0,000000']) !!}

<!-- Capacity Kg Field -->
{!! Form::label('capacity_kg', Lang::get('models.capacity_kg').':') !!}
{!! Form::number('capacity_kg', null, ['class' => 'form-control','step' => '0.000001', 'placeholder' => '0,000000']) !!}

<!-- Capacity M3 Field -->
{!! Form::label('capacity_m3', Lang::get('models.capacity_m3').':') !!}
{!! Form::number('capacity_m3', null, ['class' => 'form-control','step' => '0.000001', 'placeholder' => '0,000000']) !!}

<!-- Capacity Un Field -->
{!! Form::label('capacity_un', Lang::get('models.capacity_un').':') !!}
{!! Form::number('capacity_un', null, ['class' => 'form-control']) !!}

<!-- Height Field -->
{!! Form::label('height', Lang::get('models.height').':') !!}
{!! Form::number('height', null, ['class' => 'form-control','step' => '0.000001', 'placeholder' => '0,000000']) !!}

<!-- Width Field -->
{!! Form::label('width', Lang::get('models.width').':') !!}
{!! Form::number('width', null, ['class' => 'form-control','step' => '0.000001', 'placeholder' => '0,000000']) !!}

<!-- Lenght Field -->
{!! Form::label('lenght', Lang::get('models.lenght').':') !!}
{!! Form::number('lenght', null, ['class' => 'form-control','step' => '0.000001', 'placeholder' => '0,000000']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('packingTypes.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
