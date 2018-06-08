<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}  
@endif

<!-- Type Field -->
{!! Form::label('type', Lang::get('models.type').':') !!}
{!! Form::select('type', array('Coletor' => 'Coletor', 'Desktop' => 'Desktop'), null, ['class' => 'form-control']) !!}

<!-- Module Field -->
{!! Form::label('module', Lang::get('models.module').':') !!}
{!! Form::select('module', $modules, null, ['class' => 'form-control']) !!}

<!-- Level Field -->
{!! Form::label('level', Lang::get('models.level').':') !!}
{!! Form::select('level', array('1' => '1 - Dirigido', '2' => '2 - Passivo'), null, ['class' => 'form-control']) !!}

<!-- Action Field -->
{!! Form::label('action', Lang::get('models.action').':') !!}
{!! Form::select('action', array('Incluir' => 'Incluir', 'Alterar' => 'Alterar', 'Excluir' => 'Excluir', 'Acessar' => 'Acessar'), null, ['class' => 'form-control']) !!}


<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Local Field -->
{!! Form::label('local', Lang::get('models.local').':') !!}
{!! Form::text('local', null, ['class' => 'form-control']) !!}

<!-- Writes Log Field -->
{!! Form::label('writes_log', Lang::get('models.writes_log').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="writes_log"  value="0" >
    {{ Form::checkbox('writes_log', 1, (!empty($operation->writes_log)) ? $operation->writes_log : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'writes_log']) }}
    <label class="onoffswitch-label" for="writes_log">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

<!-- Enabled Field -->
{!! Form::label('enabled', Lang::get('models.enabled').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="enabled"  value="0" >
    {{ Form::checkbox('enabled', 1, (!empty($operation->enabled)) ? $operation->enabled : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'enabled']) }}
    <label class="onoffswitch-label" for="enabled">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('operations.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
