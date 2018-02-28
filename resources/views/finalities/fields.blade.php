<div class="form_fields">
@include('adminlte-templates::common.errors')
<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
{!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('finalities.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
