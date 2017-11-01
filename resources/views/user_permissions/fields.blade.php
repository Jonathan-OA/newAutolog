<div class="form_fields">
@include('adminlte-templates::common.errors')
<!-- User Type Code Field -->
{!! Form::label('user_type_code', Lang::get('models.user_type_code').':') !!}
{!! Form::text('user_type_code', null, ['class' => 'form-control']) !!}

<!-- Operation Code Field -->
{!! Form::label('operation_code', Lang::get('models.operation_code').':') !!}
{!! Form::text('operation_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('userPermissions.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
