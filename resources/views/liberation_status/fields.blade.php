<div class="form_fields">
@include('adminlte-templates::common.errors')
<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('liberationStatus.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
