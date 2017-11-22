<div class="form_fields">
@include('adminlte-templates::common.errors')
<!-- Company Id Field -->
{!! Form::label('company_id', Lang::get('models.company_id').':') !!}
{!! Form::number('company_id', null, ['class' => 'form-control']) !!}

<!-- Code Field -->
{!! Form::label('code', Lang::get('models.code').':') !!}
{!! Form::text('code', null, ['class' => 'form-control']) !!}

<!-- Description Field -->
{!! Form::label('description', Lang::get('models.description').':') !!}
{!! Form::text('description', null, ['class' => 'form-control']) !!}

<!-- Item Type Code Field -->
{!! Form::label('item_type_code', Lang::get('models.item_type_code').':') !!}
{!! Form::text('item_type_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
{!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
<a href="{!! route('groups.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
