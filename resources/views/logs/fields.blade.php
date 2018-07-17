<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- Company Id Field -->
<input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- User Id Field -->
{!! Form::label('user_id', Lang::get('models.user_id').':') !!}
{!! Form::number('user_id', null, ['class' => 'form-control']) !!}

<!-- Operation Code Field -->
{!! Form::label('operation_code', Lang::get('models.operation_code').':') !!}
{!! Form::text('operation_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('logs.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
