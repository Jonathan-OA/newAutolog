<div class="form_fields">
@include('adminlte-templates::common.errors')
<!-- Id Field -->
{!! Form::label('id', Lang::get('models.id').':') !!}
{!! Form::text('id', null, ['class' => 'form-control']) !!}
<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('palletStatus.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
