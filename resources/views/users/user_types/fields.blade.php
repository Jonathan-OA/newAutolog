<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}  
@endif

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Active Field -->
{!! Form::label('active', Lang::get('models.status').':') !!}
<div class="onoffswitch">
        <input type="hidden" name="active"  value="0" >
        {{ Form::checkbox('active', 1, (!empty($userType->active)) ? $userType->active : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'active']) }}
        <label class="onoffswitch-label" for="active">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
        </label>
</div>
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('userTypes.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
