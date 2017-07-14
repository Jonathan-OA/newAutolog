<div class="form_fields">
@include('adminlte-templates::common.errors')
<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
{!! Form::number('code', null, ['class' => 'form-control']) !!}

<!-- Type Field -->
{!! Form::label('type', Lang::get('models.type').':') !!}
{!! Form::select('type', ['COLETOR' => 'Coletor', 'DESKTOP' => 'Desktop'], null, ['placeholder' => Lang::get('models.sel_type'),'class' => 'form-control']) !!}

<!-- Module Field -->
{!! Form::label('module', Lang::get('models.module').':') !!}
{!! Form::select('module', $modules, null, ['placeholder' => Lang::get('models.sel_module'),'class' => 'form-control']) !!}


<!-- Level Field -->
{!! Form::label('level', Lang::get('models.level').':') !!}
{!! Form::number('level', null, ['class' => 'form-control']) !!}

<!-- Action Field -->
{!! Form::label('action', Lang::get('models.action').':') !!}
{!! Form::text('action', null, ['class' => 'form-control']) !!}

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Local Field -->
{!! Form::label('local', Lang::get('models.local').':') !!}
{!! Form::text('local', null, ['class' => 'form-control']) !!}

<!-- Writes Log Field -->
{!! Form::label('writes_log', Lang::get('models.writes_log').':') !!}
{!! Form::number('writes_log', null, ['class' => 'form-control']) !!}

<!-- Enabled Field -->
{!! Form::label('enabled', Lang::get('models.enabled').':') !!}
{!! Form::select('enabled', ['0' => 'Inativa', '1' => 'Ativa'], null, ['class' => 'form-control']) !!}

</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('operations.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
