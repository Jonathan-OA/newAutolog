<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Department Code Field -->
{!! Form::label('department_code', Lang::get('models.department_code').':') !!}
{!! Form::select('department_code', $departments, (!empty($deposit->department_code)) ? $deposit->department_code : 'null', ['class' => 'form-control']) !!}

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('code', null, ['class' => 'form-control','readonly' => 'true']) !!}
    <!-- Id Field -->
    <input id='id' name='id' type='hidden' value='{!! $deposit->id !!}'>
@else
    {!! Form::text('code', null, ['class' => 'form-control']) !!}  
@endif

<!-- Deposit Type Code Field -->
{!! Form::label('deposit_type_code', Lang::get('models.deposit_type_code').':') !!}
{!! Form::select('deposit_type_code', $dep_types, (!empty($deposit->deposit_type_code)) ? $deposit->deposit_type_code : 'null', ['class' => 'form-control']) !!}

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Status Field -->
{!! Form::label('status', Lang::get('models.status').':') !!}
<div class="onoffswitch">
    <input type="hidden" name="status"  value="0" >
    {{ Form::checkbox('status', 1, (!empty($deposit->status)) ? $deposit->status : 0 ,['class' => 'onoffswitch-checkbox', 'id' => 'status']) }}
    <label class="onoffswitch-label" for="status">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('deposits.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
