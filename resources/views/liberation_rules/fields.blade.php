<div class="form_fields">
@include('adminlte-templates::common.errors')
<!-- Code Field -->
                                      {!! Form::label('code', Lang::get('models.code').':') !!}
                                      @if(isset($action) && $action == 'edit')
                                         {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
                                      @else
                                         {!! Form::text('code', null, ['class' => 'form-control']) !!}
                                      @endif

<!-- Module Name Field -->
{!! Form::label('module_name', Lang::get('models.module_name').':') !!}
{!! Form::text('module_name', null, ['class' => 'form-control']) !!}

<!-- Enabled Field -->
{!! Form::label('enabled', Lang::get('models.enabled').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="enabled"  value="0" >
    {{ Form::checkbox('enabled', 1, (!empty($allowedTransfer->enabled)) ? $liberationRules->enabled : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'enabled']) }}
    <label class="onoffswitch-label" for="enabled">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('liberationRules.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
