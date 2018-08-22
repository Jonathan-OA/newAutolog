<div class="form_fields">
@include('adminlte-templates::common.errors')

<!-- ID Field -->
{!! Form::label('id', Lang::get('models.id').':') !!}
@if(isset($action) && $action == 'edit')
    {!! Form::text('id', null, ['class' => 'form-control', 'readonly']) !!}
@else
    {!! Form::text('id', null, ['class' => 'form-control']) !!}
@endif

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('taskStatus.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
