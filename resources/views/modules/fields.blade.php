<div class="form_fields">
@include('adminlte-templates::common.errors')
<!-- Module Field -->
{!! Form::label('module', Lang::get('models.module').':') !!}
{!! Form::text('module', null, ['class' => 'form-control']) !!}

<!-- Submodule Field -->
{!! Form::label('submodule', Lang::get('models.submodule').':') !!}
{!! Form::text('submodule', null, ['class' => 'form-control']) !!}

<!-- Name Field -->
{!! Form::label('name', Lang::get('models.name').':') !!}
{!! Form::text('name', null, ['class' => 'form-control']) !!}

<!-- Enabled Field -->
{!! Form::label('enabled', Lang::get('models.enabled').':') !!}
{!! Form::select('enabled', array('1' => 'Sim', '0' => 'Não'), null, ['class' => 'form-control']) !!}

<!-- Icon Field -->
{!! Form::label('icon', Lang::get('models.icon').':') !!}
{!! Form::text('icon', null, ['class' => 'form-control']) !!}

<!-- Url Field -->
{!! Form::label('url', Lang::get('models.url').':') !!}
{!! Form::text('url', null, ['class' => 'form-control']) !!}

<!-- Moviment Code Field -->
{!! Form::label('moviment_code', Lang::get('models.moviment_code').':') !!}
{!! Form::text('moviment_code', null, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'moviments']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('modules.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
