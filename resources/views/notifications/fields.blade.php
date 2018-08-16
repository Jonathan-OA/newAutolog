<div class="form_fields">
@include('adminlte-templates::common.errors')
<!-- Message Field -->
{!! Form::label('message', Lang::get('models.message').':') !!}
{!! Form::textarea('message', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('notifications.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
