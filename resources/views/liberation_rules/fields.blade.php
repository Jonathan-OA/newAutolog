
<div class="form_fields">
    @if(isset($action) && $action == 'edit')
        <input id='id' name='id' type='hidden' value='{!! $liberationRule->id !!}'>
    @endif
    <!-- Code Field -->
    {!! Form::label('code', Lang::get('models.code').':') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}

    <!-- Moviment Code Field -->
    {!! Form::label('moviment_code', Lang::get('models.moviment_code').':') !!}
    {!! Form::text('moviment_code', $moviment_code, ['class' => 'form-control', 'readonly']) !!}

    <!-- Description Field -->
    {!! Form::label('description', Lang::get('models.description').':') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}

    <!-- Enabled Field -->
    {!! Form::label('enabled', Lang::get('models.enabled').':') !!}
    <div class="onoffswitch">
        <input type="hidden" name="enabled"  value="0" >
        {{ Form::checkbox('enabled', 1, (!empty($liberationRule->enabled)) ? $liberationRule->enabled : 1 ,['class' => 'onoffswitch-checkbox', 'id' => 'enabled']) }}
        <label class="onoffswitch-label" for="enabled">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
        </label>
    </div>

     <!-- Parameters Field -->
     {!! Form::label('parameters', Lang::get('models.parameters').':') !!}
     {!! Form::text('parameters', null, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'parameters', 'multiple']) !!}
     </div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! URL::to('liberationRules/idx/'.$moviment_code) !!}" class="btn btn-default">@lang('buttons.cancel')</a>