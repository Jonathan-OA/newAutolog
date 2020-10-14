<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id="company_id" name="company_id" type="hidden" value="{!! Auth::user()->company_id !!}">

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
     <!-- Id Field -->
     <input id='id' name='id' type='hidden' value='{!! $user->id !!}'>
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}  
@endif

<!-- Name Field -->
{!! Form::label('name', Lang::get('models.name').':') !!}
{!! Form::text('name', null, ['class' => 'form-control']) !!}

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', Lang::get('models.password').':') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<!-- Password-confirm Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password_confirmation', Lang::get('models.password-confirm').':') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
{!! Form::label('email', 'Email:') !!}
{!! Form::email('email', null, ['class' => 'form-control']) !!}

<!-- User Type Code Field -->
{!! Form::label('user_type_code', Lang::get('models.user_type_code').':') !!}
{!! Form::select('user_type_code', $user_types, null, ['class' => 'form-control']) !!}

<!-- Status Field -->
{!! Form::label('status', Lang::get('models.status').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="status"  value="0" >
    {{ Form::checkbox('status', 1, (!empty($user->status)) ? $user->status : 1 ,['class' => 'onoffswitch-checkbox', 'id' => 'status']) }}
    <label class="onoffswitch-label" for="status">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('users.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
